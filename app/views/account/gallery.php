<?php
$gallery = new Friends();
$folder_images = $gallery->get_folder_images();
$my_info = $gallery->get_my_info();
//echo "<pre>";
//var_dump($my_info);
//die;

?>

<div style="display: flex" id="galleryAvatar">
    <a href="<?= SCRIPT_URL ?>account" id="avatar_user">
        <img src="<?= SCRIPT_URL ?>public/images/avatar/avatar_<?= $_SESSION['user_id'] ?>.jpg" class="img_avatar"
             alt="">
    </a>
    <div style="margin: 0 25px 25px 25px ">
        <h3>Name: <?= $my_info->name ?></h3>
        <h3>Surename: <?= $my_info->surename ?></h3>
        <h3>E-mail: <?= $my_info->email ?></h3>
        <h3>Phone: <?= $my_info->phone ?></h3>
    </div>
</div>

<div id="upload_photos_gallery">
    <form action="<?= SCRIPT_URL ?>account/gallery/uploads" method="post" enctype="multipart/form-data">
        <label for="upload_gallery">
            <img src="<?= SCRIPT_URL ?>public/images/38711-200.png" alt="upload" class="upload_gallery"><br>
        </label>
        <input type="file" id="upload_gallery" style="display: none" name="upload" required>
        <button class="submit__upl" type="submit">+</button>
    </form>
</div>
<h2 style="text-align:center;border-bottom: 5px solid #00fffe;color: #00bfbf;font-size: 45px"><?= $data[0] ?></h2>
<div class="gallery_a">
    <?php if (!empty($folder_images)): ?>
        <?php foreach ($folder_images as $i => $i_key): ?>
            <div class="gallery-a img_<?= $i ?>">
                <img src="<?= SCRIPT_URL ?>public/images/gallery/<?= $i_key ?>" alt="<?= $i ?>" class="photo_gallery">
                <button class="remove_image_in_folder">X</button>
                <button class='add_avatar'>V</button>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div style="margin: 0 auto">
            <img src="<?= SCRIPT_URL ?>public/images/default_image.jpg" alt="">
        </div>
    <?php endif; ?>
</div>
