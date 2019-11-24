<?php
Validate::location('activate');
?>
<fieldset class="fieldset" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <legend class="legend"><h2>Friend Ship Login</h2></legend>
    <form action="<?= SCRIPT_URL ?>login" method="post">
        <div class="flex">

            <div class="one">
                <label for="email" <?php if (!empty($_SESSION['email'])) Validate::test_color($_SESSION['email']) ?>><?= Language::__("home.email") ?></label>
                <label for="password" <?php if (!empty($_SESSION['password'])) Validate::test_color($_SESSION['password']) ?>><?= Language::__("home.password") ?></label>
            </div>
            <div class="two">
                <input type="text" name="email" id="email"
                       placeholder="Login..." <?php if (!empty($_SESSION['email'])) Validate::test_input($_SESSION['email']);
                if (!empty($_SESSION['error_email'])) Validate::test_color($_SESSION['error_email']) ?>>
                <input type="password" name="password" id="password"
                       placeholder="Password..." <?php if (!empty($_SESSION['password'])) Validate::test_input($_SESSION['password']);
                if (!empty($_SESSION['error_password'])) Validate::test_color($_SESSION['error_password']) ?>>
            </div>
        </div>
        <div style="text-align: center"><input type="submit" value="<?= Language::__('home.login') ?>"></div>
    </form>
    <div style="text-align: center"><a href="<?= SCRIPT_URL ?>"><input type="button" value="<?= Language::__('home.registration') ?>"></a>
    </div>
    <?php
    if (!empty($_SESSION['msg_ok'])) {
        echo "<h2 style='text-align: center;color: #1fff00'>" . $_SESSION['msg_ok'] . "</h2>";
    }
    if (!empty($_SESSION['password']) and $_SESSION['password'] === md5('error') or !empty($_SESSION['email']) and $_SESSION['email'] === md5('error')) {
        echo "<h2 style='text-align: center;color: #ff200f'>" . EMPTY_ERROR . "</h2>";
    }
    if (!empty($_SESSION['email_off'])) {
        echo "<h2 style='text-align: center;color: #ff200f'>" . $_SESSION['email_off'] . "</h2>";
    }
    if (!empty($_SESSION['password_off'])) {
        echo "<h2 style='text-align: center;color: #ff200f'>" . $_SESSION['password_off'] . "</h2>";
    }
    ?>
</fieldset>
<?php
session_unset();
session_destroy();
?>