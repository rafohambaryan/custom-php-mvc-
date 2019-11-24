<?php

class Validate
{
    public static function valid_str($name, $error)
    {
        $new_name = filter_var($name, FILTER_SANITIZE_STRING);
        if (!(strlen($new_name) > 2 && strlen($new_name) < 35)) {
            return $_SESSION['error_' . $error] = md5('error');
        }
        return $new_name;
    }

    public static function valid_phone($data)
    {
        $data = filter_var($data, FILTER_SANITIZE_STRING);
        if (!filter_var($data, FILTER_VALIDATE_INT) or strlen($data) < 6 or strlen($data) > 13 or preg_match('/[+]/',$data)) {
            $_SESSION['error_phone'] = md5('error');
        }
        return $data;
    }

    public static function validate_email($data)
    {
        $email = filter_var($data, FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error_email'] = md5('error');
        }

        return $email;
    }

    public static function repeat_password($data, $data1)
    {
        if ($data !== $data1)
            $_SESSION['password_<>'] = md5('error');

    }

    public static function valid_birthday($date)
    {

        $path = "/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/";
        $datearr = explode('-', $date);
        $c_d = date('Y');
        if ($datearr[0] !== "") {
            if ($datearr[1] <= 12 && $datearr[2] <= 31
                && $c_d - $datearr[0] >= 18) {
                return preg_match($path, $date);
            } else {
                $_SESSION['error_bday'] = ERROR_BIRTHDAY;
                return false;
            }
        }
    }

////////////////////////////////////////////////------------////////////////
    public static function test_color(&$key)
    {
        if ($key === md5('error')) {
            echo 'style="color: red"';
        }
    }

    public static function test_input(&$key)
    {
        if ($key !== md5('error')) {
            echo 'value="' . $key . '"';
        }
    }

    public static function test_gender(&$key, $value)
    {
        if ($key === $value) echo "checked";
    }

    public static function valid_empty($data)
    {
        foreach ($data as $index => $datum) {
            if (empty($datum)) {
                $_SESSION[$index] = md5('error');
            }
        }
    }
    public static function location($data){
        if (!empty($_SESSION['location'])) {
            echo "<script>" . "window.location.href='index.php?url=users/".$data."'" . "</script>";
            unset($_SESSION['location']);
            die;
        }
    }
}