<?php
return [
    '' => 'UsersController@index@GET',
    'doLogin' => 'UsersController@doLogin@GET',
    'login' => 'UsersController@login@POST',
    'doRegister' => 'UsersController@doRegister@GET',
    'registration' => 'UsersController@registration@POST',
    'activation' => 'UsersController@activation@GET',
    'account' => 'UsersController@account_user@GET',
    'users_info' => 'UsersController@users_info@POST',
    'logout' => 'UsersController@logout@POST',
    'account_user/upload-avatar' => 'UsersController@upload_avatar@POST',
    'rmv' => 'UsersController@remove_account@POST',
    'lang/{lang}' => 'UsersController@language@GET',
];