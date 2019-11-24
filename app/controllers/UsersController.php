<?php

use mysql_xdevapi\Session;
use app\language\Language;
/**
 * Created by PhpStorm.
 * User: user
 * Date: 3/22/2016
 * Time: 12:14 AM
 */
class UsersController extends Controller
{
    public function index()
    {

        $auth = $this->model('Auth');
//        $auth -> procedure();
        $auth->create_db();
        try {
            $auth->selected('users', '');
        } catch (PDOException $e) {
            if ($e->getCode() === '42S02') {
                $auth->createDB(DB_TABLE, USER_TABLE);
                $auth->createDB('friendShip', FRIENDS_TABLE);
                $auth->createDB('user_address', USER_ADDRESS_TABLE);
                $auth->createDB('country', COUNTRY_TABLE);
                $auth->createDB('city', CITY_TABLE);
                $auth->createDB('phone', PHONE_TABLE);
                $auth->createDB('images_users', IMAGES_TABLE);
                $auth->createDB('message_friends', MESSAGE_TABLE);
                $auth->test_insert('country', array('country' => 'Armenia', 'code' => '+374'), 's%s%');
                $auth->test_insert('country', array('country' => 'Russia', 'code' => '+7'), 's%s%');
                $auth->test_insert('country', array('country' => 'English', 'code' => '+33'), 's%s%');
                $auth->test_insert('country', array('country' => 'Germany', 'code' => '+44'), 's%s%');
                $auth->test_insert('city', array('country_id' => 1, 'city' => 'Shirak'), 'i%s%');
                $auth->test_insert('city', array('country_id' => 1, 'city' => 'Armavir'), 'i%s%');
                $auth->test_insert('city', array('country_id' => 1, 'city' => 'Tavush'), 'i%s%');
                $auth->test_insert('city', array('country_id' => 1, 'city' => 'Lori'), 'i%s%');
                $auth->test_insert('city', array('country_id' => 1, 'city' => 'Sevan'), 'i%s%');
                $auth->test_insert('city', array('country_id' => 2, 'city' => 'Armavir'), 'i%s%');
                $auth->test_insert('city', array('country_id' => 2, 'city' => 'Arsk'), 'i%s%');
                $auth->test_insert('city', array('country_id' => 2, 'city' => 'Babushkin'), 'i%s%');
                $auth->test_insert('city', array('country_id' => 2, 'city' => 'Krasnadar'), 'i%s%');
                $auth->test_insert('city', array('country_id' => 3, 'city' => 'London'), 'i%s%');
                $auth->test_insert('city', array('country_id' => 3, 'city' => 'Coventry'), 'i%s%');
                $auth->test_insert('city', array('country_id' => 3, 'city' => 'Derby'), 'i%s%');
                $auth->test_insert('city', array('country_id' => 3, 'city' => 'Oxford'), 'i%s%');
                $auth->test_insert('city', array('country_id' => 4, 'city' => 'Myunxen'), 'i%s%');
                $auth->test_insert('city', array('country_id' => 4, 'city' => 'Berlin'), 'i%s%');
                $auth->test_insert('city', array('country_id' => 4, 'city' => 'Drezden'), 'i%s%');
                $auth->test_insert('city', array('country_id' => 4, 'city' => 'Hessen'), 'i%s%');
                $auth->test_insert('phone', array('country_id' => 1, 'code' => '93'), 'i%s%');
                $auth->test_insert('phone', array('country_id' => 1, 'code' => '94'), 'i%s%');
                $auth->test_insert('phone', array('country_id' => 1, 'code' => '98'), 'i%s%');
                $auth->test_insert('phone', array('country_id' => 1, 'code' => '77'), 'i%s%');
                $auth->test_insert('phone', array('country_id' => 1, 'code' => '91'), 'i%s%');
                $auth->test_insert('phone', array('country_id' => 1, 'code' => '99'), 'i%s%');
                $auth->test_insert('phone', array('country_id' => 2, 'code' => '8'), 'i%s%');
                $auth->test_insert('phone', array('country_id' => 2, 'code' => '9'), 'i%s%');
                $auth->test_insert('phone', array('country_id' => 3, 'code' => '18'), 'i%s%');
                $auth->test_insert('phone', array('country_id' => 3, 'code' => '14'), 'i%s%');
                $auth->test_insert('phone', array('country_id' => 4, 'code' => '5'), 'i%s%');
                $auth->test_insert('phone', array('country_id' => 4, 'code' => '65'), 'i%s%');
                $auth->test_insert('phone', array('country_id' => 4, 'code' => '11'), 'i%s%');
            }
        }
        $this->render(AUTH_PATH);
    }

    public function doRegister()
    {
        $this->render(REGISTER_PATH);

    }

    public function registration()
    {
        $valid = $this->validate($_POST);
        $data = $_POST;


        if ($valid) {
            unset($data['repeat']);
            $activation_code = md5(rand(1, 100));
            $data['activation_code'] = $activation_code;
            $argon_hash = password_hash($data['password'], PASSWORD_ARGON2I);
            $data['password'] = str_replace(ARGON2, '', $argon_hash);

            $users = $this->model('User');
//            echo "<pre>";
//            var_dump($this->test($data));
//            exit;
//           $users->insert(DB_TABLE, $data, 's%s%s%i%s%s%s%s%s');
            $users->insert(DB_TABLE, $data, 's%s%s%s%s%s%s%s');
            if ($data['gender'] === 'female') {
//                copy('public/images/avatar_female.jpg', "app/views/account/images/avatar/avatar_" . $_SESSION['last_id'] . ".jpg");
                copy('public/images/avatar_female.jpg', "public/images/avatar/avatar_" . $_SESSION['last_id'] . ".jpg");
            } else {
                copy('public/images/avatar_male.jpg', "public/images/avatar/avatar_" . $_SESSION['last_id'] . ".jpg");
//                copy('public/images/avatar_male.jpg', "app/views/account/images/avatar/avatar_" . $_SESSION['last_id'] . ".jpg");
            }
            if (!empty($_SESSION['last_id'])) {
                $this->_class('Email');
                $email = new Email();
                $to = $data['email'];
                $subject = "Friend Ship";
                $messages = $email->content_html(SCRIPT_URL . 'activation?code=' . $activation_code . "_" . $_SESSION['last_id'], $data['name'], $data['surename']);
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                $headers .= 'From: <info@rafogitc.tk>' . "\r\n";
                mail($to, $subject, $messages, $headers);
            }
            $_SESSION['msg_ok'] = OK_ACTIVE;
            $this->location('activation');
        } else {
//            $_GET['url'] = 'users/doRegister';
//            $this->doRegister();
            $this->redirect_error($data);
        }

    }

    public function doLogin()
    {
        $this->render(LOGIN_PATH);
    }

    public function login()
    {
//        var_dump($_POST);
        $valid = $this->login_validate($_POST);
        if ($valid) {
            $this->location('account');
        } else {
            $this->redirect_error($_POST, 'doLogin');
        }
    }

    public function validate($data)
    {
        if (!empty($data)) {

            if (empty($data['gender'])) {
                $_SESSION['gender'] = md5('error');
                $_SESSION['msg_all'] = EMPTY_ERROR;
            }
            foreach ($data as $i => $i_key) {
                if (empty($i_key)) {
                    $_SESSION[$i] = md5('error');
                    $_SESSION['msg_all'] = EMPTY_ERROR;
                }
            }
            if (empty($_SESSION)) {
                $test = $this->model('User');
                Validate::validate_email($data['email']);

                if (!empty($_SESSION)) {
                    return false;
                }
                $test1 = $test->test_uniq(DB_TABLE, $data['email']);

                if (!$test1) {
                    $_SESSION['email_duplicate'] = DUPLICATE_EMAIL;
                    return false;
                }
                Validate::valid_birthday($data['birthday']);
                Validate::valid_str($data['name'], 'name');
                Validate::valid_str($data['username'], 'username');
                Validate::valid_str($data['surename'], 'surename');

                $password = Validate::valid_str($data['password'], 'password');
                $repeat = Validate::valid_str($data['repeat'], 'password_2');
                Validate::repeat_password($password, $repeat);

                if (!empty($_SESSION)) {
                    return false;
                }
                return $test;
            } else {
                return false;
            }


        } else {
            $_SESSION['error_redirect'] = ERROR_REDIRECT;
            return false;
        }
    }

    public function redirect_error($data, $error = 'doRegister')
    {
        foreach ($data as $index => $items) {
            if (!empty($items)) {
                $_SESSION[$index] = $items;
            }
        }
        if (!empty($_SESSION['error_redirect'])) {
            $this->render(AUTH_PATH);
            exit;
        }
        $this->location($error);
    }

    public function login_validate($data)
    {
        if (!empty($data)) {
            Validate::valid_empty($data);
            if (empty($_SESSION)) {
                Validate::validate_email($data['email']);
                if (empty($_SESSION)) {
                    $user = $this->model('User');
                    $test = $user->test_uniq(DB_TABLE, $data['email']);
                    if (!$test) {
                        Validate::valid_str($data['password'], 'password');
                        if (empty($_SESSION)) {
                            $user_info = $user->select(DB_TABLE, (array)$data, 's%');
//                            var_dump($user_info);
//                            die;
                            $password = ARGON2 . $user_info[0]->password;
                            if (!password_verify($data['password'], $password)) {
                                $_SESSION['password_off'] = 'False password';
                            } else {
                                $_SESSION['user_id'] = $user_info[0]->id;
                                return true;
                            }
                        } else {
                            return false;
                        }
                    } else {
                        $_SESSION['email_off'] = 'False E-mail';
                    }

                }
            } else {
                $this->redirect_error($data, 'doLogin');
            }
        } else {
            $_SESSION['error_redirect'] = ERROR_REDIRECT;
            return false;

        }
        return false;
    }

    public function logout()
    {
        session_unset();
        $this->location('doLogin');
    }

    public function account_user()
    {
        if (!empty($_SESSION['user_id'])) {
            unset($_SESSION['friend_gallery_id']);
            unset($_SESSION['gallery_id']);
            $users = $this->model('User');
            $test_active = $users->selected('users', $_SESSION['user_id'], 'activation_code');
            if ($test_active[0]->activation_code === '1') {
                $country = $users->selected('country', '');
                $user = $users->selected('users', $_SESSION['user_id']);
//                var_dump($avatar);
//                die;
                $this->_class('Friends');
                $this->render("account/index", array($country, $user));
            } else {
                $_SESSION['msg_ok'] = '1';
                unset($_SESSION['user_id']);
                $this->location('activation');
            }
            $user = $_SESSION['user_id'];
            session_unset();
            $_SESSION['user_id'] = $user;

        } else {
            $this->doLogin();
        }

    }

    public function users_info()
    {
        if (!empty($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
            session_unset();
            foreach ($_POST as $index => $item) {
                if (empty($item)) {
                    $_SESSION[$index] = md5('error');
                }
            }
            $_POST['phone'] = Validate::valid_phone($_POST['phone']);
            if (empty($_SESSION)) {
                $user = $this->model('User');
                $_SESSION['user_id'] = $user_id;
                $country = $user->selected('country', $_POST['country']);
                $phone = $country[0]->code . $_POST['phone_code'] . $_POST['phone'];
                $user->update_db('users', $_SESSION['user_id'], 'phone =' . $phone);
                $user->test_insert('user_address', array('user_id' => $_SESSION['user_id'], 'country' => $country[0]->country, 'city' => $_POST['city']), 'i%s%s%');
                $this->location('account');
                exit;
            } else {
                $_SESSION['user_id'] = $user_id;
                foreach ($_POST as $index => $item) {
                    if (!empty($item)) {
                        $_SESSION[$index] = $item;
                    }
                }
                $this->account_user();
            }
        } else {
            $this->doLogin();
        }
    }

    public function activation()
    {
        if (!empty($_SESSION['msg_ok'])) {
            $this->render('auth/activate');
            die;
        }
        if (!empty($_GET['code']) and strlen($_GET['code']) > 32) {
            $test = explode('_', $_GET['code']);
            $user = $this->model('User');
            $us = $user->selected('users', $test[1], 'activation_code');
            if (!empty($us)) {
                switch (true) {
                    case $us[0]->activation_code === $test[0]:
                        $user->update_db('users', $test[1], "activation_code = '1'");
                        $_SESSION['true_active'] = OK_ACTIVE;
                        break;
                    case $us[0]->activation_code === '1' :
                        $_SESSION['add_active'] = 'arden activ e ';
                        break;
                }
                $this->render('auth/activate');
                die;
            } else {
                $this->render(LOGIN_PATH);
            }
        } else {
            $this->location('doLogin');
        }
    }

    public function upload_avatar()
    {
        if (!empty($_FILES)) {
            $file_ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
            $extension = ['png', 'jpg', 'gif', 'jpeg'];
            if (!in_array($file_ext, $extension) OR $_FILES['avatar']['size'] > 1000000 OR $_FILES['avatar']['size'] === 0) {
                $_SESSION['error_avImage_size'] = '1';
                goto end;
            }
            if (!is_dir(ROOT . '/public/images/avatar')) {
                mkdir(ROOT . '/public/images/avatar', 0777, true);
            }
            move_uploaded_file($_FILES['avatar']['tmp_name'], ROOT . '/public/images/avatar/avatar_' . $_SESSION['user_id'] . ".jpg");

        }
        end:
        $this->location('account');
    }

    public function remove_account()
    {
        if (!empty($_POST[md5('111')]) and !empty($_SESSION['user_id'])) {
            unlink(ROOT."/public/images/avatar/avatar_{$_SESSION['user_id']}.jpg");
            $user = $this->model('User');
            $images = $user->selected('images_users', $_SESSION['user_id'],'*','user_id');
            foreach ($images as $index => $image) {
                $array = (array)json_decode($image->gallery);
                if (!empty($array)){
                    foreach ($array as $i => $item) {
                        unlink(ROOT."/public/images/gallery/{$item}");
                   }
                }
            }
            $user->delete('users', "id = {$_SESSION['user_id']}");
            $this->location('/');

            exit;
        }
        if (!empty($_SESSION['user_id'])) {
            $this->location('account');
        } else {
            $this->location('/');
        }
    }

    public function error_page()
    {
        $this->render('auth/error_page');
    }

    public function language($lang)
    {
        setcookie("lang", $lang, time() + (3600 * 99), '/');
        $this->redirect();
    }
}