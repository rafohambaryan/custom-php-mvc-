<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 3/22/2016
 * Time: 12:13 AM
 */
use app\language\Language;
 class Controller
{
    public function model($model)
    {
        require_once(ROOT . '/app/models/' . $model . PHP_EXT);
        return new $model();
    }

    public function render($view, $data = [])
    {
        require_once(ROOT . '/app/views/app' . PHP_EXT);
    }

    public function _class($class)
    {
        require_once(ROOT . '/app/controllers/' . $class . PHP_EXT);
//        return new $class();
    }

    public function location($router)
    {
        header("Location:" . SCRIPT_URL . $router);
        exit;
    }

    public function redirect()
    {
        $referer = @$_SERVER['HTTP_REFERER'];
        if (!empty($referer)) {
            $redirect = str_replace(SCRIPT_URL,'',$referer);
               $this->location($redirect);
        }else{
            $this->location('');
        }
    }

}