<?php

class GalleryController extends Controller
{

    public function create()
    {
        $user = $this->model('User');
        $user->test_insert('images_users', array('user_id' => $_SESSION['user_id'], 'name_folder' => 'NewFolder'), 'i%s%');
        $this->redirect();
    }

    public function rename_folder()
    {
        $_REQUEST['new_name'] = trim($_REQUEST['new_name'], '');
        $_REQUEST['new_name'] = filter_var($_REQUEST['new_name'], FILTER_SANITIZE_STRING);

        if (!empty($_REQUEST['folder_id'] and !empty($_REQUEST['new_name']))) {
            $user = $this->model('User');
            $user->update_db('images_users', $_REQUEST['folder_id'] . " AND user_id =  '{$_SESSION['user_id']}' ", "name_folder = '{$_REQUEST['new_name']}'");
            echo "1";
        } else {
            echo "2";
        }

    }

    public function delete_folder()
    {
        if (!empty($_REQUEST['folder_id'])) {
            $user = $this->model('User');
            $test = $user->selected('images_users', $_REQUEST['folder_id'] . " AND user_id = '{$_SESSION['user_id']}'");
            if (!empty(json_decode($test[0]->gallery))) {
                echo "2";
                die;
            } else
                $user->delete('images_users', " id = '{$_REQUEST['folder_id']}' AND user_id = '{$_SESSION['user_id']}'");
            echo "1";
        }
    }

    public function delete_folder_all()
    {
        if (!empty($_REQUEST['folder_id'])) {
            $user = $this->model('User');
            $test = $user->selected('images_users', $_REQUEST['folder_id'] . " AND user_id = '{$_SESSION['user_id']}'");
            $array = json_decode($test[0]->gallery);
            foreach ($array as $index => $item) {
                unlink(ROOT . "/public/images/gallery/{$item}");
            }
            $user->delete('images_users', " id = '{$_REQUEST['folder_id']}' AND user_id = '{$_SESSION['user_id']}'");
            echo "1";
        }
    }

    public function session_gallery()
    {
        if (!empty($_REQUEST['folder_id'])) {
            $user = $this->model('User');
            $test = $user->selected('images_users', $_REQUEST['folder_id'] . " AND user_id = '{$_SESSION['user_id']}'");
            $_SESSION['gallery_id'] = $_REQUEST['folder_id'];
            echo json_encode(["1", $test]);
        }
    }

    public function remove_image_in_folder()
    {
        if (!empty($_REQUEST['image'])) {
            $user = $this->model('User');
            $test = $user->selected('images_users', $_SESSION['gallery_id'] . " AND user_id = '{$_SESSION['user_id']}'")[0];
            $array = json_decode($test->gallery);
            $array = (array)$array;
            unlink(ROOT . "/public/images/gallery/gallery_{$_REQUEST['image']}");
            unset($array['image_' . explode('.', $_REQUEST['image'])[0]]);
            $array = json_encode($array);
            $user->update_db('images_users', $_SESSION['gallery_id'] . " AND user_id = '{$_SESSION['user_id']}'", "gallery = '{$array}'");
            echo '1';
        }
    }

    public function gallery($folder)
    {
        if (!empty($_SESSION['user_id']) AND !empty($_SESSION['gallery_id'])) {
            $this->_class('Friends');
            $this->render('account/gallery', [urldecode($folder)]);
            $user_id = $_SESSION['user_id'];
            $gallery_id = $_SESSION['gallery_id'];
            session_unset();
            $_SESSION['user_id'] = $user_id;
            $_SESSION['gallery_id'] = $gallery_id;
        } else {
            $this->location('account_user');
        }
    }

    public function upload_gallery_img()
    {
        if (!empty($_FILES)) {
            $file_ext = pathinfo($_FILES['upload']['name'], PATHINFO_EXTENSION);
            $extension = ['png', 'jpg', 'gif', 'jpeg'];
            if (!in_array($file_ext, $extension) OR $_FILES['upload']['size'] > 7000000 OR $_FILES['upload']['size'] === 0) {
                $_SESSION['error_image_size'] = '1';
                goto end;
            }
            if (!is_dir(ROOT . '/public/images/gallery')) {
                mkdir(ROOT . '/public/images/gallery', 0777, true);
            }
            $time = time();
            $image_name = "gallery_" . $time . "." . $file_ext;
            $user = $this->model('User');
            $test = $user->selected('images_users', $_SESSION['gallery_id'] . " AND user_id = '{$_SESSION['user_id']}'");
            if (!empty($test[0]->gallery)) {
                $array = json_decode($test[0]->gallery);
                $array = (array)$array;
                if (count($array) > 10) {
                    $_SESSION['limited_size_photo'] = '1';
                    //@TODO print size error
                    goto end;
                }
//
//                echo "<pre>";
//                var_dump($array);
//                die;
                $array["image_" . $time] = $image_name;
                $array = json_encode($array);
                $user->update_db('images_users', $_SESSION['gallery_id'] . " AND user_id = '{$_SESSION['user_id']}'", "gallery = '{$array}'");
                move_uploaded_file($_FILES['upload']['tmp_name'], ROOT . '/public/images/gallery/' . $image_name);
            } else {
                $photo = json_encode(['image_' . $time => $image_name]);
                $user->update_db('images_users', $_SESSION['gallery_id'] . " AND user_id = '{$_SESSION['user_id']}'", "gallery = '{$photo}'");
                move_uploaded_file($_FILES['upload']['tmp_name'], ROOT . '/public/images/gallery/' . $image_name);
            }
        }
        end:
        $this->redirect();
    }

    public function add_avatar()
    {
        $image = 'gallery_' . $_REQUEST['image'];
        copy(ROOT . '/public/images/gallery/' . $image, ROOT . '/public/images/avatar/avatar_' . $_SESSION['user_id'] . '.jpg');
        echo '1';
    }

    public function gallery_private()
    {
        $user = $this->model('User');
        $folder = $user->selected('images_users', $_REQUEST['folder_id'])[0];
        if ($folder->private === '0') {
            $user->update_db('images_users', $_REQUEST['folder_id'], 'private = 1');
        } else {
            $user->update_db('images_users', $_REQUEST['folder_id'], 'private = 0');
        }
        $folder_color = $user->selected('images_users', $_SESSION['user_id'] . " AND private = 1", 'id', 'user_id ');
        echo json_encode($folder_color);

    }


    public function friend_gallery($data)
    {
        if (!empty($_SESSION['friend_gallery_id'])) {
            $user = $this->model('User');
            $friend_images = $user->selected('images_users', $_SESSION['friend_gallery_id'] . " AND private = 0", '*', 'user_id');
            $friend_images = (array)$friend_images;
            $array = [];
            foreach ($friend_images as $index => $image) {
                $arr = (array)json_decode($image->gallery);
                foreach ($arr as $i => $item) {
                    array_push($array,$item);
                }
            }
            $this->render('account/friend_gallery', [$array]);
        } else {
            $this->location('account');
        }
    }
}