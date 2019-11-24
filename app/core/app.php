<?php

namespace app\core;

 class App
{
    public function __construct( $controller,  $method)
    {
        if (is_file(CONTROLLERS . $controller . PHP_EXT)) {
            require_once(CONTROLLERS . $controller . PHP_EXT);
            if (method_exists($controller, $method)) {
                if (isset($_SESSION['api'])){
                    call_user_func_array([new $controller(), $method],[$_SESSION['api']]);
                    unset($_SESSION['api']);
                    die;
                }
               call_user_func(array(new $controller(), $method));

               die;
            }
            echo 'method not define';
        }else{
            echo 'controller not define';
        }
    }
}