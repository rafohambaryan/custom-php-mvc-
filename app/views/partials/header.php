<header>
<!--    <div class="language_header">-->
<!--         <button class="lang" lang="am"  style="background-color:--><?php //if(Language::get_lang() === 'am') echo '#00bfbf'; else echo '#F0F0F0'?><!--">arm</button>-->
<!--         <button class="lang" lang="ru"  style="background-color:--><?php //if(Language::get_lang() === 'ru') echo '#00bfbf'; else echo '#F0F0F0'?><!--">rus</button>-->
<!--         <button class="lang" lang="en"  style="background-color:--><?php //if(Language::get_lang() === 'en') echo '#00bfbf'; else echo '#F0F0F0'?><!--">eng</button>-->
<!--    </div>-->


    <div class="language_header">
        <a href="<?= SCRIPT_URL ?>lang/am"><button class="lang_1" style="background-color:<?php if(Language::get_lang() === 'am') echo '#00bfbf'; else echo '#F0F0F0'?>">arm</button></a>
        <a href="<?= SCRIPT_URL ?>lang/en"><button class="lang_1" style="background-color:<?php if(Language::get_lang() === 'en') echo '#00bfbf'; else echo '#F0F0F0'?>">eng</button></a>
        <a href="<?= SCRIPT_URL ?>lang/ru"><button class="lang_1" style="background-color:<?php if(Language::get_lang() === 'ru') echo '#00bfbf'; else echo '#F0F0F0'?>">rus</button></a>
    </div>

  <h2 style="color: #99fffd" >Friend Ship</h2>
    <?php if (!empty($_SESSION['user_id'])): ?>
    <form action="<?= SCRIPT_URL ?>logout" method="post" id="user_exit_site">
        <input type="submit" value="Exit">
    </form>
    <?php endif;?>
    <?php if (!empty($_SESSION['friend_gallery_id']) or !empty($_SESSION['gallery_id'])): ?>
        <div class = 'redirect_home'>
            <a href="https://rafogitc.tk/account">
                <img src="<?= SCRIPT_URL ?>public/images/gallery-homepage-icon-png-2.png" alt="" width="80px" height="80px">
            </a>
        </div>
    <?php endif;?>
</header>