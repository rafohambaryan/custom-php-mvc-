<?php
return [
    'account_user/create' => 'GalleryController@create@POST',
    'gallery/{folder}' => 'GalleryController@gallery@GET',
    'rename_folder' => 'GalleryController@rename_folder@PUT',
    'delete_folder' => 'GalleryController@delete_folder@DEL',
    'gallery_private' => 'GalleryController@gallery_private@PUT',
    'delete_folder_all' => 'GalleryController@delete_folder_all@DEL',
    'account/gallery/remove_image_in_folder' => 'GalleryController@remove_image_in_folder@DEL',
    'session_gallery' => 'GalleryController@session_gallery@PATCH',
    'account/gallery/uploads' => 'GalleryController@upload_gallery_img@POST',
    'account/gallery/add_avatar' => 'GalleryController@add_avatar@PUT',

];