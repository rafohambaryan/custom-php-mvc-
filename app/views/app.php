<!DOCTYPE html>
<html lang="<?php if (!empty($_COOKIE['lang'])) echo $_COOKIE['lang']; else echo 'en'?>">
<?php
require_once 'partials/head.php';
require_once 'partials/header.php';
echo "<body><main>";
if (is_file(__DIR__.'/'.$view.'.php')) {
    require_once $view . PHP_EXT;
}else{
    echo 'render i sxal arjeq';
}
echo "</main> </body>";
require_once 'partials/footer.php';
echo "</html>";

?>
