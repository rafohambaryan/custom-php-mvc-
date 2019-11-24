<h2 style="text-align:center;border-bottom: 5px solid #00fffe;color: #00bfbf;font-size: 45px">Friend All Photos</h2>
<div class="friend_gallery">
    <?php if (!empty($data[0])): ?>
        <?php foreach ($data[0] as $index => $key): ?>
            <div class="friend_gallery_min img_fr_<?= $index ?>" data-id = "<?= $index ?>">
                <img src="<?= SCRIPT_URL ?>public/images/gallery/<?= $key ?>" alt="" width="100%" class="img_friend">
            </div>
        <?php endforeach; ?>
    <?php else:?>
    <div style="margin: 0 auto">
        <img src="<?= SCRIPT_URL ?>public/images/default_image.jpg" alt="">
    </div>
    <?php endif; ?>
</div>