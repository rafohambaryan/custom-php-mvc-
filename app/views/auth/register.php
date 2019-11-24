<fieldset class="fieldset">
    <legend class="legend"><h2>Friend Ship Registration</h2></legend>
    <form action="<?= SCRIPT_URL ?>registration" method="post">
        <div class="flex">
            <div class="one">
                <label for="name" <?php if (!empty($_SESSION['name'])) Validate::test_color($_SESSION['name']) ?>>Name</label>
                <label for="username" <?php if (!empty($_SESSION['username'])) Validate::test_color($_SESSION['username']) ?>>Username</label>
                <label for="surename" <?php if (!empty($_SESSION['surename'])) Validate::test_color($_SESSION['surename']) ?>>Surename</label>

                <label for="email" <?php if (!empty($_SESSION['email'])) Validate::test_color($_SESSION['email']) ?>><?= Language::__("home.email") ?></label>
                <label for="birthday" <?php if (!empty($_SESSION['birthday'])) Validate::test_color($_SESSION['birthday']) ?>><?= Language::__("home.birthday") ?></label>
                <label for="gender" <?php if (!empty($_SESSION['gender'])) Validate::test_color($_SESSION['gender']) ?>><?= Language::__("home.gender") ?></label>
                <label for="password" <?php if (!empty($_SESSION['password'])) Validate::test_color($_SESSION['password']) ?>><?= Language::__("home.password") ?></label>
                <label for="repeat" <?php if (!empty($_SESSION['repeat'])) Validate::test_color($_SESSION['repeat']) ?>>Repeat
                    Password</label>
            </div>
            <div class="two">
                <input type="text" name="name" id="name"
                       placeholder="Name..." <?php if (!empty($_SESSION['name'])) Validate::test_input($_SESSION['name']);
                if (!empty($_SESSION['error_name'])) Validate::test_color($_SESSION['error_name']) ?>>
                <input type="text" name="username" id="username"
                       placeholder="Username..." <?php if (!empty($_SESSION['username'])) Validate::test_input($_SESSION['username']);
                if (!empty($_SESSION['error_username'])) Validate::test_color($_SESSION['error_username']) ?>>
                <input type="text" name="surename" id="surename"
                       placeholder="Surename..." <?php if (!empty($_SESSION['surename'])) Validate::test_input($_SESSION['surename']);
                if (!empty($_SESSION['error_surename'])) Validate::test_color($_SESSION['error_surename']) ?>>
                <div style="position: relative">
                    <input type="text" name="email" id="email"
                           placeholder="E-mail..." <?php if (!empty($_SESSION['email'])) Validate::test_input($_SESSION['email']);
                    if (!empty($_SESSION['error_email'])) Validate::test_color($_SESSION['error_email']) ?>>
                    <span style="position: absolute; right: -135px;top: 18px;color: red"> <?php if (!empty($_SESSION['email_duplicate'])) echo $_SESSION['email_duplicate'] ?></span>
                </div>

                <div style="position: relative">
                    <?php
                    $bird = date('Y')-'18' .'-01-01';
                    ?>
                    <input type="date" name="birthday" id="birthday" value="<?= $bird ?>"
                           style="width: 100%" <?php if (!empty($_SESSION['birthday'])) Validate::test_input($_SESSION['birthday']) ?> >
                    <span style="position: absolute; right: -190px;top: 18px;color: red"> <?php if (!empty($_SESSION['error_bday'])) echo $_SESSION['error_bday'] ?></span>
                </div>
                <div id="aaa">
                    <label for="male"><?= Language::__("home.male") ?></label>
                    <input type="radio" id="male" name="gender"
                           value="male" <?php if (!empty($_SESSION['gender'])) Validate::test_gender($_SESSION['gender'], 'male') ?>>
                    <label for="female"><?= Language::__("home.female") ?></label>
                    <input type="radio" id="female" name="gender"
                           value="female" <?php if (!empty($_SESSION['gender'])) Validate::test_gender($_SESSION['gender'], 'female') ?>>
                </div>

                <input type="password" name="password" id="password"
                       placeholder="Password..." <?php if (!empty($_SESSION['password'])) Validate::test_input($_SESSION['password']);
                if (!empty($_SESSION['error_password'])) Validate::test_color($_SESSION['error_password']) ?>>
                <input type="password" name="repeat" id="repeat"
                       placeholder="Password..." <?php if (!empty($_SESSION['repeat'])) Validate::test_input($_SESSION['repeat']);
                if (!empty($_SESSION['password_<>'])) Validate::test_color($_SESSION['password_<>']) ?>>
            </div>
        </div>
        <div style="text-align: center"><input type="submit" value="<?= Language::__('home.registration') ?>"></div>
    </form>
    <div style="text-align: center"><a href="<?= SCRIPT_URL ?>doLogin"><input type="button" value="<?= Language::__('home.login') ?>"></a></div>
    <?php if (!empty($_SESSION['msg_all'])): ?>
        <h2 style="text-align: center;color: red"><?= $_SESSION['msg_all'] ?></h2>
    <?php endif; ?>
</fieldset>
<?php
session_unset();
session_destroy();
?>