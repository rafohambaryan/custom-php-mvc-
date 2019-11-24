<?php if ($data[1][0]->phone !== null): ?>
    <?php
//    echo "<pre>";
//    var_dump($data[1]);

    $obj_frs = new Friends();
    $frs = $obj_frs->getUsers();
    $add = $obj_frs->addUsers();
    $my_friends = $obj_frs->setUsers();
    $folder_gallery = $obj_frs->get_gallery_folder();
//    echo "<pre>";
//    var_dump($folder_gallery);
//    die;
    ?>
    <div style="display: flex">
        <form action="<?= SCRIPT_URL ?>account_user/upload-avatar" method="post" enctype="multipart/form-data">
            <label for="file">
                <img src="<?= SCRIPT_URL ?>public/images/avatar/avatar_<?= $_SESSION['user_id'] ?>.jpg"
                     class="img_avatar" alt="">
            </label>
            <input type="file" id="file" name="avatar" style="display: none" required>
            <br>
            <input type="submit" id="send_avatar" value="Images"
                   style="padding: 5px 28px;<?php if (!empty($_SESSION['error_avImage_size'])) echo "background-color: red;"; ?>">
        </form>
        <div style="margin: 25px">
            <h3>Name: <?= $data[1][0]->name ?></h3>
            <h3>Surename: <?= $data[1][0]->surename ?></h3>
            <h3>E-mail: <?= $data[1][0]->email ?></h3>
            <h3>Phone: <?= $data[1][0]->phone ?></h3>
        </div>
    </div>
    <div>
        <h2 style="text-align:center;border-bottom: 5px solid #00fffe;color: #00bfbf;font-size: 45px">Gallery</h2>
        <div>
            <form action="<?= SCRIPT_URL ?>account_user/create" method="post">
                <button type="submit" style="border: none;border-radius: 50%;background-color: transparent"><img src="<?= SCRIPT_URL ?>public/images/create_folder.jpg" alt="" style="border-radius: 50%;width: 100px"></button>
            </form>
        </div>
        <div class="gallery_a">
            <?php if (!empty($folder_gallery)): ?>
                <?php foreach ($folder_gallery as $index => $item) : ?>
                    <div class='gallery__a gallery_rem_<?= $item->id ?>'>
                        <!-- -->
                        <!-- -->
                        <div class="private_gallery private_<?= $item->id ?>" data-id = "<?= $item->id ?>" style="background-color: <?php if ($item->private === '0') echo '#5dff00'; else echo 'red'?>"></div>
                        <!-- -->
                        <!-- -->
                        <div class='gallery_folder' autocapitalize='<?= $item->id ?>'>
                            <img src='<?= SCRIPT_URL ?>public/images/default_gallery.png' alt='' width='100%' style='border-radius: 50%;'>
                        </div>
                        <p id='name_folder_<?= $item->id ?>'><?= $item->name_folder ?></p>
                        <p><?= $item->created ?></p>
                        <div style='margin-top: 15px'>
                            <button data-id = '<?= $item->id ?>' class='gallery_folder_del' >Delete</button>
                            <button class='rename_bt'>Rename</button>
                        </div>
                        <div class='rename_folder_name' id='ren_<?= $item->id ?>'>
                            <input type='text' placeholder='New Name' style='width: 60%' data-id = '<?= $item->id ?>'  class='ren_inp_<?= $item->id ?>' >
                            <button class='rename_ok'>OK</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <hr style="height: 10px;background-color: #99fffd">
    <div class="flex" style="margin: 25px 0">
        <div class="one friends">
            <h3 style="position: absolute;top: 0;">My friends</h3>
            <?php if (!empty($my_friends)): ?>
                <?php foreach ($my_friends as $index => $item) : ?>
                    <div class="add <?= "us_" . $item[0]->id ?>">
                        <!-- message true or false -->
                        <div class="send_msg msg_<?= $item[0]->id ?>"></div>
                        <h3><?= $item[0]->name ?></h3>
                        <img src="<?= SCRIPT_URL ?>public/images/avatar/avatar_<?= $item[0]->id ?>.jpg"
                             class="logo_users logo_users_friend" alt="<?= $item[0]->id ?>">
                        <input type="hidden" value="<?= $item[0]->id ?>">
                        <button class="messages_friends">Message</button>
                        <input type="hidden" value="<?= $item[0]->id ?>">
                        <button class="remove_user" data-id="<?= $_SESSION['user_id'] ?>">Remove</button>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="two">
            <?php if (!empty($add)): ?>
                <?php foreach ($add as $index => $item) : ?>
                    <div class="add <?= $item[0]->id ?> on_add">
                        <h3><?= $item[0]->name ?></h3>
                        <img src="<?= SCRIPT_URL ?>public/images/avatar/avatar_<?= $item[0]->id ?>.jpg"
                             class=logo_users alt="" width="100%">
                        <p>Drug</p>
                        <input type="hidden" value="<?= $item[0]->id ?>">
                        <button class="add_y" data-id="<?= $_SESSION['user_id'] ?>">YES</button>
                        <input type="hidden" value="<?= $item[0]->id ?>">
                        <button class="remove" data-id="<?= $_SESSION['user_id'] ?>">NO</button>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>
    </div>
    <div id="owl-demo" style="margin: 25px auto;width: 50%;">
        <?php if (!empty($frs)): ?>
            <?php foreach ($frs as $index => $fr) : ?>
                <div class="item">
                    <?= $fr->name ?>
                    <br>
                    <img src="<?= SCRIPT_URL ?>public/images/avatar/avatar_<?= $fr->id ?>.jpg"
                         class=logo_users alt=""><br>
                    <input type="hidden" value="<?= $fr->id ?>" class="fr_id">
                    <button type="button" data-id="<?= $_SESSION['user_id'] ?>" class="add_fr">Add Friend</button>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <div class="item">
    </div>
    <!--messages -->
    <?php if (!empty($my_friends)): ?>
        <?php foreach ($my_friends as $index => $item) : ?>
            <div class="message_display display_none_<?= $item[0]->id ?>">
                <button class="message_none_display">X</button>
                <fieldset class="mmm">
                    <legend class="legend" style="color: #030005"><h3>Message</h3></legend>
                    <div class="my_message">
                        <strong><?= $data[1][0]->name ?></strong>
                    </div>
                    <div class="friend_message" data-id="<?= $item[0]->id ?>">
                        <strong><?= $item[0]->name ?></strong>
                    </div>
                </fieldset>
                <input type="text" placeholder="Message..." class="message_value_send_<?= $item[0]->id ?>">
                <button value="<?= $item[0]->id ?>" class="send_message"
                        onclick="send_message(<?= $_SESSION['user_id'] ?>,this.value)">Send
                </button>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    <input type="hidden" value="<?= $_SESSION['user_id'] ?>" id="user_id">
<?php else: ?>
    <form action="<?= SCRIPT_URL ?>users_info" method="post">
        <div class="flex">
            <div class="one">
                <label for="country" <?php if (!empty($_SESSION['country'])) Validate::test_color($_SESSION['country']) ?>>Country</label>
                <label for="city" <?php if (!empty($_SESSION['city'])) Validate::test_color($_SESSION['city']) ?>>City</label>
                <label for="phone" <?php if (!empty($_SESSION['phone'])) Validate::test_color($_SESSION['phone']) ?> >Phone</label>
            </div>
            <div class="two">
                <select id="country" name="country">
                    <option value="">Select the country</option>
                    <?php foreach ($data[0] as $i => $item): ?>
                        <option value="<?= $i + 1 ?>"><?= $item->country ?></option>
                    <?php endforeach; ?>
                </select>
                <select id="city" name="city">
                    <option value="">select the city</option>
                </select>
                <div style="display: flex; align-items: center;">
                    <div style="width: 37px" id="code">code</div>
                    <select id="phone" name="phone_code">
                        <option value="">code</option>
                    </select>
                    <input type="text" name="phone"
                           placeholder="Phone..." <?php if (!empty($_SESSION['phone'])) Validate::test_input($_SESSION['phone']);
                    if (!empty($_SESSION['error_phone'])) Validate::test_color($_SESSION['error_phone']) ?>>
                </div>
            </div>
        </div>
        <div style="text-align: center"><input type="submit" value="send"></div>
    </form>
<?php endif; ?>
