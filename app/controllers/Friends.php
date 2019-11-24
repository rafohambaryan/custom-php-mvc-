<?php

class Friends extends Controller
{
    public function get_my_info(){
        $users = $this->model('User');
        return $users->selected('users',$_SESSION['user_id'])[0];
    }
    public function getUsers()
    {
        $arr = [];
        $arr_true = [];
        $users = $this->model('User');
        $us = $users->selected('friendShip', $_SESSION['user_id'], 'friend_id', 'user_id');
        $usrs = $users->selected('users', $_SESSION['user_id']." and activation_code = '1'", '*', 'id ', '<>');
        foreach ($us as $index => $u) {
            array_push($arr, $u->friend_id);
        }
        foreach ($usrs as $index => $usr) {
            if (!in_array($usr->id, $arr)) {
                array_push($arr_true, $usr);
            }
        }
        return $arr_true;

    }

    public function setUsers()
    {
        $users = $this->model('User');
        $friend = $users->selected('friendShip', $_SESSION['user_id'], 'friend_id, friend', 'user_id ', '=');
        $arr = [];
        foreach ($friend as $index => $item) {
            if ($item->friend === '1') {
                array_push($arr, $users->selected('users', $item->friend_id));
            }
        }
        return $arr;
    }

    public function addUsers()
    {
        $users = $this->model('User');
        $arr = [];
        $add = $users->selected('friendShip', $_SESSION['user_id'] . " AND friend = '0'", 'user_id', 'friend_id ', '=');
        foreach ($add as $index => $item) {
            array_push($arr, $users->selected('users', $item->user_id));
        }
        return $arr;
    }
    public function  get_gallery_folder(){
        $users = $this->model('User');
        $folder = $users->selected("images_users",$_SESSION['user_id'],'*','user_id');
        return $folder;
    }
    public function get_folder_images(){
        $folder_images = null;
        if (!empty($_SESSION['user_id'] AND !empty($_SESSION['gallery_id']))){
            $users = $this->model('User');
            $folder_images = $users->selected('images_users',$_SESSION['gallery_id'] . " AND user_id = '{$_SESSION['user_id']}'");
            $folder_images = json_decode($folder_images[0]->gallery);
        }
        return $folder_images;
    }

}