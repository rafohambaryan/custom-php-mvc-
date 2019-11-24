<?php
//db constants
define('DB_HOST', 'localhost');
define('DB_USER', 'rafogitc_friend');
define('DB_BASE', 'rafogitc_friend');
define('DB_TABLE', 'users');
define('DB_PASSWORD', '7yS)Y=1Nf^nq');



define("SCRIPT_URL", $_SERVER['REQUEST_SCHEME']."://" . $_SERVER['SERVER_NAME'] . "/");
define("ROOT", $_SERVER['DOCUMENT_ROOT']);
define('PHP_EXT', '.php');
define('MODELS', $_SERVER['DOCUMENT_ROOT'] . '/app/models/');
define('CONTROLLERS', $_SERVER['DOCUMENT_ROOT'] . '/app/controllers/');
define('VIEWS', $_SERVER['DOCUMENT_ROOT'] . '/app/views/');
define('CONTROLLER_NAME', 'UsersController');
define('ACTION_NAME', 'index');
define('ARGON2', '$argon2i$v=19$m=65536,t=4,p=1$');


//views
define('AUTH_PATH', 'auth/index');
define('LOGIN_PATH', 'auth/login');
define('ACCOUNT', 'auth/account');
define('REGISTER_PATH', 'auth/register');
define("ACCOUNT_PATH", 'account/index');

//create tables


//error messages
define('ERROR_REDIRECT', 'You aren\'t registration!');
define('ERROR_NAME', 'Please insert symbols less then 35!');
define('EMPTY_ERROR', 'Please insert all fields!');
define('ERROR_EMAIL', 'Please insert valid email!');
define('ERROR_BIRTHDAY', 'Please insert valid day 18+!');
define('ERROR_PASSWORD', 'Please insert first element uppercase string!');
define('ERROR_EQUAL_PASSWORD', 'Please equal password & confirm password!');
define("ERROR_USER", 'Axper jan chka');
define("ERROR_GET_USER", 'Get error');
define("LOGIN", 'Login');
define("CITY", 'City');
define("REGION", 'Region');
define("REGISTRATION", 'Registration');
define("CONNECT_SUCCESS", 'Connected successfully');
define("CONNECT_FAILED", 'Connected failed: ');
define('DUPLICATE_EMAIL', 'Busy E-mail address');
define("OK_ACTIVE", 'Շնորհակալություն');
define("ACTIVATE_ON", 'False Activation Code');


define('USER_TABLE', 'id  INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  name  VARCHAR(30) NOT NULL
  COLLATE utf8_unicode_ci,
  username  VARCHAR(30) NOT NULL
  COLLATE utf8_unicode_ci,
  surename  VARCHAR(30) NOT NULL
  COLLATE utf8_unicode_ci,
  phone VARCHAR(25),
  email VARCHAR(40) NOT NULL
  COLLATE utf8_unicode_ci UNIQUE,
  birthday  DATE  NOT NULL,
  password VARCHAR(255)  NOT NULL
  COLLATE utf8_unicode_ci,
  gender VARCHAR(10) NOT NULL
  COLLATE utf8_unicode_ci,
  activation_code VARCHAR(100) NOT NULL
  COLLATE utf8_unicode_ci,
  created DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id)');

define("COUNTRY_TABLE", "
  id      TINYINT(255) UNSIGNED NOT NULL AUTO_INCREMENT,
  country VARCHAR(30)           NOT NULL COLLATE utf8_unicode_ci,
  code    VARCHAR(10)           NOT NULL COLLATE utf8_unicode_ci,
  PRIMARY KEY (id)");
define("CITY_TABLE", "
 id         TINYINT(255) NOT NULL AUTO_INCREMENT,
  country_id TINYINT(255) UNSIGNED,
  city       VARCHAR(30)  NOT NULL COLLATE utf8_unicode_ci,
  PRIMARY KEY (id),
  FOREIGN KEY (country_id) REFERENCES country (id) ON UPDATE CASCADE ON DELETE CASCADE ");
define("PHONE_TABLE", "
id  INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  country_id TINYINT(255) UNSIGNED ,
  code VARCHAR(5) NOT NULL ,
  PRIMARY KEY (id),
  FOREIGN KEY (country_id) REFERENCES country(id) ON UPDATE CASCADE ON DELETE CASCADE");
define("USER_ADDRESS_TABLE", "
  id  INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  user_id INT(11) UNSIGNED,
  country VARCHAR(50) NOT NULL COLLATE utf8_unicode_ci,
  city VARCHAR(50) NOT NULL COLLATE utf8_unicode_ci,
  PRIMARY KEY (id),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE ");
define("FRIENDS_TABLE", "
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    user_id INT(11) UNSIGNED,
    friend_id INT(11) UNSIGNED,
    friend TINYINT(1) DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    update_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE ,
    FOREIGN KEY (friend_id) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE 
");

define('IMAGES_TABLE', ' 
    id          INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    user_id     INT(11) UNSIGNED NOT NULL,
    name_folder VARCHAR(255)     NOT NULL COLLATE utf8_unicode_ci,
    gallery     JSON,
    created     DATETIME DEFAULT CURRENT_TIMESTAMP,
    private     TINYINT(1) DEFAULT 0,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE
');

define('MESSAGE_TABLE', "
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    user_id INT(11) UNSIGNED NOT NULL ,
    friend_id INT(11) UNSIGNED NOT NULL ,
    messages JSON,
   reade TINYINT(25) DEFAULT 0 ,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE ,
    FOREIGN KEY (friend_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
");