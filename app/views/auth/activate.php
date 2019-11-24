<?php if (!empty($_SESSION['msg_ok'])) : ?>
    <p style="font-size: 25px">a confirmation address was requested at your email address please confirm it <a
                href="https://e.mail.ru/messages/inbox/">E-main</a></p>
<?php endif; ?>

<?php if (!empty($_SESSION['true_active'])) : ?>
    <p style="font-size: 25px"><?= $_SESSION['true_active'] ?></p>
<?php endif; ?>

<?php if (!empty($_SESSION['add_active'])) : ?>
    <p style="font-size: 25px"><?= $_SESSION['add_active'] ?></p>
<?php endif; ?>
<?php
    echo "<script>" . "setTimeout(function(){location.href='https://rafogitc.tk/doLogin'},5000)" . "</script>";
session_unset();
session_destroy();
?>
