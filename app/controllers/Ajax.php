<?php



class Ajax extends Controller
{
    public function country_city()
    {
        $ajax = $this->model('User');
        if (!empty($_REQUEST['id'])) {
            $city = $ajax->selected('city', $_REQUEST['id'], '*', 'country_id');
            $phone = $ajax->selected('phone', $_REQUEST['id'], '*', 'country_id');
            $code = $ajax->selected('country', $_REQUEST['id'], 'code');
            echo json_encode(array($city, $code, $phone));
        }

    }

    public function add_friend()
    {
        $ajax = $this->model('User');
        if (!empty($_REQUEST['user_id']) && $_REQUEST['fr_id']) {
            $test = $ajax->selected('friendShip', $_REQUEST['user_id'] . " and friend_id = " . $_REQUEST['fr_id'], 'friend', 'user_id');
            if (empty($test))
                $ajax->insertDB('friendShip', array("user_id" => $_REQUEST['user_id'], "friend_id" => $_REQUEST['fr_id']), 'i%i%');
            echo '1';
        }
    }

    public function yes_friend()
    {
        $ajax = $this->model('User');
        if (!empty($_REQUEST['user_id']) && $_REQUEST['fr_id']) {
            $test = $ajax->selected('friendShip', $_REQUEST['user_id'] . " and user_id = " . $_REQUEST['fr_id'] . " or (user_id = " . $_REQUEST['user_id'] . " and friend_id = " . $_REQUEST['fr_id'] . ")", 'user_id, friend_id', 'friend_id');
            if (count($test) === 1) {
                $ajax->insertDB('friendShip', array("user_id" => $_REQUEST['user_id'], "friend_id" => $_REQUEST['fr_id']), 'i%i%');
            }
            $ajax->update_db('friendShip', $_REQUEST['user_id'] . " AND user_id = {$_REQUEST['fr_id']}", 'friend = 1', 'friend_id = ');
            $ajax->update_db('friendShip', $_REQUEST['fr_id'] . " AND user_id = {$_REQUEST['user_id']}", 'friend = 1', 'friend_id = ');
            $ajax->insertDB('message_friends', array("user_id" => $_REQUEST['fr_id'], "friend_id" => $_REQUEST['user_id'], 'messages' => json_encode(array('Hello'))), 'i%i%s%');
            $ajax->insertDB('message_friends', array("user_id" => $_REQUEST['user_id'], "friend_id" => $_REQUEST['fr_id'], 'messages' => json_encode(array('Hello Friend'))), 'i%i%s%');

        }
        echo '1';
    }

    public function on_friend()
    {
        $ajax = $this->model('User');
        if (!empty($_REQUEST['user_id']) && $_REQUEST['fr_id']) {
            $ajax->delete('friendShip', 'friend_id = ' . $_REQUEST['user_id'] . " AND user_id = " . $_REQUEST['fr_id']);
        }
        echo '1';
    }

    public function remove_fr()
    {
        $ajax = $this->model('User');
        if (!empty($_REQUEST['user_id']) && $_REQUEST['fr_id']) {
            $ajax->delete('friendShip', 'user_id = ' . $_REQUEST['user_id'] . " AND friend_id = " . $_REQUEST['fr_id']);
            $ajax->delete('friendShip', 'user_id = ' . $_REQUEST['fr_id'] . " AND friend_id = " . $_REQUEST['user_id']);
            $ajax->delete('message_friends', 'user_id = ' . $_REQUEST['user_id'] . " AND friend_id = " . $_REQUEST['fr_id']);
            $ajax->delete('message_friends', 'user_id = ' . $_REQUEST['fr_id'] . " AND friend_id = " . $_REQUEST['user_id']);
        }
        echo '1';
    }

    public function message()
    {
        if (!empty($_REQUEST['user_id'] and !empty($_REQUEST['friend_id']))) {
            $ajax = $this->model('User');
            $user_mess = $ajax->selected('message_friends', $_REQUEST['user_id'] . " AND friend_id = '{$_REQUEST['friend_id']}'", '*', 'user_id');
            $friend_mess = $ajax->selected('message_friends', $_REQUEST['friend_id'] . " AND friend_id = '{$_REQUEST['user_id']}'", '*', 'user_id');
            $ajax->update_db('message_friends', $_REQUEST['friend_id'], 'reade = 0', 'user_id = ');
            $user_mess = json_decode($user_mess[0]->messages);
            $friend_mess = json_decode($friend_mess[0]->messages);

            echo json_encode(array($user_mess, $friend_mess));
        }
    }

    public function insert_msg()
    {
        $message = filter_var($_REQUEST['message'], FILTER_SANITIZE_STRING);
        $message = filter_var($message, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!empty($_REQUEST['user_id'] and !empty($_REQUEST['friend_id'])) and !empty($message)) {
            $select = $this->model('User');
            $user_mess = $select->selected('message_friends', $_REQUEST['user_id'] . " AND friend_id = '{$_REQUEST['friend_id']}'", '*', 'user_id');
            $user_mess = json_decode($user_mess[0]->messages);
            if (count($user_mess) > 10) {
                array_shift($user_mess);
            }
            array_push($user_mess, $message);
            $user_mess = json_encode($user_mess);
            $select->update_db('message_friends', $_REQUEST['user_id'] . " AND friend_id = '{$_REQUEST['friend_id']}'", " messages = '{$user_mess}' , reade = '1'", 'user_id = ');
            echo "1";
        } else {
            echo "2";
        }

    }

    public function messages_get_read()
    {
        $users = $this->model('User');
        $friend = $users->selected('friendShip', $_SESSION['user_id'], 'friend_id, friend', 'user_id ', '=');
        $arr = [];
        foreach ($friend as $index => $item) {
            if ($item->friend === '1') {
                array_push($arr, $users->selected('users', $item->friend_id, 'id')[0]);
            }
        }
        $array = [];
        foreach ($arr as $index => $item) {
            $test = $users->selected('message_friends', $item->id, '*', 'user_id')[0];
            if ($test->reade === '1') {
                array_push($array, $test);
            }
        }

        echo json_encode($array);
    }

    public function session_friend_gallery_id()
    {
        $_SESSION['friend_gallery_id'] = $_REQUEST['friend_id'];
        echo json_encode(SCRIPT_URL.'account/friend/'.rand(99999,9999999));
    }

}