<footer><h2>Footer</h2>
    <?php if (!empty($_SESSION['user_id'])): ?>
        <form action="<?= SCRIPT_URL ?>rmv" method="post" id="user_exit_site">
            <input type="hidden" name="<?= md5('111') ?>" value="1">
            <input type="submit" value="Remove">
        </form>
    <?php endif;?>

</footer>
<!--  jQuery 1.7+  -->
<script src="<?= SCRIPT_URL ?>public/js/jquery-3.4.1.min.js"></script>
<script src="<?= SCRIPT_URL ?>public/js/owl.carousel.js"></script>
<script src="<?= SCRIPT_URL ?>public/js/init.js"></script>
<script src="<?= SCRIPT_URL ?>public/js/gallery.js"></script>
<script src="<?= SCRIPT_URL ?>public/js/vue.js"></script>


