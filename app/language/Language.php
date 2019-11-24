<?php


 class Language
{
    public static function get_lang()
    {
        $lang = 'en';
        if (!empty($_COOKIE['lang'])) {
            $lang = $_COOKIE['lang'];
        }
        return $lang;
    }

    public static function __($lang)
    {
        $test = explode('.', $lang);
        $language = $lang;

        if (empty($_COOKIE['lang']) OR !is_dir(__DIR__ . '/' . $_COOKIE['lang'])) {
            $_COOKIE['lang'] = 'en';
        }
        if (!empty($_COOKIE['lang']) AND is_dir(__DIR__ . '/' . $_COOKIE['lang'])) {
            if (is_file(__DIR__ . '/' . $_COOKIE['lang'] . '/' . $test[0] . '.php')) {
                $langs = require __DIR__ . '/' . $_COOKIE['lang'] . '/' . $test[0] . '.php';
                if (!empty($langs[$test[1]])) {
                    $language = $langs[$test[1]];
                }
            }
        }
        return $language;

    }

}