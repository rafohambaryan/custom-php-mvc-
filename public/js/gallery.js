$(document).ready(function () {
    $('.rename_bt').click(function () {
        let id = $(this).prev().attr("data-id");
        // $('.rename_folder_name').toggle("block");
        $('#ren_' + id).toggle("block");
    });
    $('.rename_ok').click(function () {
        let folder_id = $(this).prev().attr("data-id"),
            new_name = $(this).prev().val();
        $.ajax({
            url: "rename_folder",
            type: "PUT",
            dataType: "JSON",
            data: {folder_id: folder_id, new_name: new_name},
            success: function (data) {
                if (data === 1) {
                    $('.ren_inp_' + folder_id).val('');
                    $('#name_folder_' + folder_id).text(new_name);
                    $('#ren_' + folder_id).toggle("none");
                    $('.ren_inp_' + folder_id).css("border", "1px solid");
                } else {
                    $('.ren_inp_' + folder_id).css("border", "2px solid red");
                }
            }
        });

    });
    $('.gallery_folder_del').click(function () {
        let folder_id = $(this).attr("data-id");

        $.ajax({
            url: "delete_folder",
            type: "DEL",
            dataType: "JSON",
            data: {folder_id: folder_id},
            success: function (data) {
                if (data === 1) {
                    $('.gallery_rem_' + folder_id).remove();
                } else if (data === 2) {
                    let test = confirm("jnjel file-i bolor nkarner@");
                    if (test) {
                        $.ajax({
                            url: "delete_folder_all",
                            type: "DEL",
                            dataType: "JSON",
                            data: {folder_id: folder_id},
                            success: function (data) {
                                if (data === 1) {
                                    $('.gallery_rem_' + folder_id).remove();
                                }
                            }
                        });
                    }

                }
            }
        });
    });
    $('.gallery_folder').click(function () {
        let folder_id = $(this).attr("autocapitalize");

        $.ajax({
            url: "session_gallery",
            type: "PATCH",
            dataType: "JSON",
            data: {folder_id: folder_id},
            success: function (data) {
                if (data[0] === '1') {
                    location.href = 'account/gallery/' + data[1][0].name_folder;
                }
            }
        });

    });
    $('.remove_image_in_folder').click(function () {
        let image = $(this).prev().attr('alt'),
            alt = image;
        image = image.split("_")[1];
        let ext = $(this).prev()[0].currentSrc.split(image)[1];
        image = image + ext;
        $.ajax({
            url: "remove_image_in_folder",
            type: "DEL",
            dataType: "JSON",
            data: {image: image},
            success: function (data) {
                if (data === 1) {
                    $('.img_' + alt).remove();
                }
            }
        });

    });
    $(document).on('click', '.add_avatar', function () {
        let image = $(this).prev().prev().attr('alt');
        image = image.split('_')[1];
        let ext = $(this).prev().prev()[0].currentSrc.split(image)[1];
        $.ajax({
            url: "add_avatar",
            type: "PUT",
            dataType: "JSON",
            data: {image: image + ext},
            success: function (data) {
                if (data === 1) {
                    window.history.go(-1);
                    window.history.back();
                    window.location.replace('');
                    // location.reload();

                }
            }
        });
    });
    $(document).on('click', '.private_gallery', function () {
        let folder_id = $(this).attr('data-id');
        $.ajax({
            url: "gallery_private",
            type: "PUT",
            dataType: 'JSON',
            data: {folder_id: folder_id},
            success: function (data) {
                $('.private_gallery').css('background-color', '#5dff00');
                for (let i of data) {
                    $('.private_' + i.id).css('background-color', 'red');
                }
            }
        });
    });

    $(document).on('click', '.logo_users_friend', function () {
        let friend_id = $(this).attr('alt');
        $.ajax({
            url: "session_friend_gallery_id",
            type: "PUT",
            dataType: 'JSON',
            data: {friend_id: friend_id},
            success: function (data) {
                location.href = data;
            }
        });
    });
    $(document).on('click','.friend_gallery_min',function () {
        let img_id = $(this).attr('data-id');
        if (sessionStorage.getItem('zoom') === 'ok'){
            $('.img_fr_'+img_id).css('width', '320px');
            sessionStorage.setItem('zoom','no');
        }else {
            $('.img_fr_'+img_id).css('width', '600px');
            sessionStorage.setItem('zoom','ok');
        }
    })

    // $('#create_new_folder').click(function () {
    //     $.ajax({
    //         url: "account_user/create",
    //         type: "POST",
    //         dataType: "JSON",
    //         success:function (data) {
    //             $('.gallery__a').remove();
    //             for (let i of data[0]) {
    //                 $('.gallery_a').append(
    //                    "<div class='gallery__a gallery_rem_"+i.id+"'>\n" +
    //                     "                        <div class='gallery_folder' autocapitalize='"+i.id+"'>\n" +
    //                     "                            <img src='"+data[1]+"public/images/default_gallery.png' alt='' width='100%' style='border-radius: 50%;'>\n" +
    //                     "                        </div>\n" +
    //                     "                        <p id='name_folder_"+i.id+"'>"+i.name_folder+"</p>\n" +
    //                     "                        <p>"+i.created+"</p>\n" +
    //                     "                        <div style='margin-top: 15px'>\n" +
    //                     "                            <button data-id = '"+i.id+"' class='gallery_folder_del' >Delete</button>\n" +
    //                     "                            <button class='rename_bt'>Rename</button>\n" +
    //                     "                        </div>\n" +
    //                     "                        <div class='rename_folder_name' id='ren_"+i.id+"'>\n" +
    //                     "                            <input type='text' placeholder='New Name' style='width: 60%' data-id = '"+i.id+"'  class='ren_inp_"+i.id+"' >\n" +
    //                     "                            <button class='rename_ok'>OK</button>\n" +
    //                     "                        </div>\n" +
    //                     "                    </div>"
    //                 );
    //             }
    //             console.log(data);
    //         }
    //     });
    // });
});