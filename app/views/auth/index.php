<?php
if (isset($_SESSION['error_redirect'])):?>
    <h2><?= $_SESSION['error_redirect'] ?></h2>
<?php endif; ?>
    <fieldset class="fieldset">
        <legend class="legend"><h2>Friend Ship</h2></legend>
        <div style="display: flex; justify-content: center">
            <a href="<?= SCRIPT_URL ?>doRegister"><input type="button" value="<?= Language::__('home.registration') ?>"></a>
            <a href="<?= SCRIPT_URL ?>doLogin"><input type="button" value="<?= Language::__('home.login')?>"></a>
        </div>
    </fieldset>

<?php
session_unset();
session_destroy();
?>