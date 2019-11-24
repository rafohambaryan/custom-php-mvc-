function setCookie(key, value, date) {
    let d = new Date();
    d.setTime(d.getTime() + (date * 24 * 60 * 60 * 1000));
    let expires = "expires=" + d.toUTCString();
    document.cookie = key + "=" + value + ";" + expires + ";path=/";
}

$(document).ready(function () {
    $('.lang').click(function () {
        let lang = $(this)[0]['lang'];
        setCookie("lang", lang, 10);
        location.reload();
    });

    $('#country').change(function () {
        $code = $(this).val();
        $('.aa').remove();
        $.ajax({
            // url: 'app/core/Ajax.php',
            url: 'country_city',
            type: 'POST',
            dataType: 'json',
            context: {element: $(this)},
            data: {id: $code},
            success: function (data) {
                // console.log(data);
                for ($item of data[0]) {
                    $('#city').append('<option value="' + $item.city + '" class="aa">' + $item.city + '</option>')
                }
                for ($i of data[2]) {
                    $('#phone').append('<option value="' + $i.code + '" class="aa">' + $i.code + '</option>')
                }
                $('#code').text(data[1][0].code);
            },
            error: function (data) {
                console.log(data);
                $('#city').val('');
                $('#code').text('code');
            }
        });
    });
    $("input").keyup(function () {
        $("input").css("color", "black");
    });
    $("#owl-demo").owlCarousel({

        autoPlay: 3000, //Set AutoPlay to 3 seconds

        items: 4,
        itemsDesktop: [1199, 3],
        itemsDesktopSmall: [979, 3]

    });
    //send friend request to selected friend
    $('.add_fr').click(function () {
        $user_id = $(this).attr('data-id');
        $fr_id = $(this).prev().val();

        $.ajax({
            url: 'add_friend',
            type: 'POST',
            dataType: 'json',
            context: {element: $(this)},
            data: {
                user_id: $user_id,
                fr_id: $fr_id
            },
            success: function (data) {
                console.log(data);
                if (data === 1)
                    this.element.attr('disabled', 'true')
            },
            error: function (data) {
                // console.log(data);

            }
        });
    });
    $('.add_y').click(function () {
        $user_id = $(this).attr('data-id');
        $fr_id = $(this).prev().val();
        $.ajax({
            url: 'yes_friend',
            type: 'PUT',
            dataType: 'json',
            context: {element: $(this)},
            data: {
                user_id: $user_id,
                fr_id: $fr_id
            },
            success: function (data) {
                if (data === 1)
                    $('.' + $fr_id).remove();
            },
            error: function (data) {
                // console.log(data);

            }
        });
    });
    $('.remove').click(function () {
        $user_id = $(this).attr('data-id');
        $fr_id = $(this).prev().val();
        $.ajax({
            url: 'on_friend',
            type: 'DELETE',
            dataType: 'json',
            context: {element: $(this)},
            data: {
                user_id: $user_id,
                fr_id: $fr_id
            },
            success: function (data) {
                if (data === 1)
                    $('.' + $fr_id).remove();
            },
            error: function (data) {
                // console.log(data);

            }
        });
    });

    $('.remove_user').click(function () {
        $user_id = $(this).attr('data-id');
        $fr_id = $(this).prev().val();
        $.ajax({
            url: 'remove_fr',
            type: 'DELETE',
            dataType: 'json',
            context: {element: $(this)},
            data: {
                user_id: $user_id,
                fr_id: $fr_id
            },
            success: function (data) {
                if (data === 1)
                    $('.us_' + $fr_id).remove();
            },
            error: function (data) {
                // console.log(data);

            }
        });
    });
////////////////////////////////////////////////////////////////////////
    $('#send_avatar').hover(function () {
        $(this).css({backgroundColor: ''});
    });
    $('.message_none_display').click(function () {
        $('.message_display').css("display", "none");
        sessionStorage.setItem("asdfghjkl", "no");
    });
    $('.messages_friends').click(function () {
        $('.message_display').css("display", "none");
        $friend_id = $(this).prev().val();
        $user_id = $('#user_id').val();
        sessionStorage.setItem("asdfghjkl", $friend_id);
        get_messages($user_id, $friend_id);
        $('.display_none_' + $friend_id).css("display", "block");
    });


    sessionStorage.setItem("asdfghjkl", 'no');

    function test_message() {
        let user_id = $('#user_id').val();
        // console.log(user_id);
        if (sessionStorage.getItem("asdfghjkl") !== 'no' && user_id !== undefined) {
            get_messages(user_id, sessionStorage.getItem("asdfghjkl"));
        }
    }

    setInterval(test_message, 2000);




});

function get_messages(user_id, friend_id) {
    $.ajax({
        type: "PATCH",
        dataType: "JSON",
        url: "message",
        data: {user_id: user_id, friend_id: friend_id},
        success: function (data) {
            $('.rem_message').remove();
            for (let i of data[0]) {
                $('.my_message').append('<p class="rem_message">' + i + '</p>');
            }
            for (let i of data[1]) {
                $('.friend_message').append('<p class="rem_message">' + i + '</p>');
            }
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function send_message(user_id, friend_id) {
    let message = $('.message_value_send_' + friend_id).val();
    $.ajax({
        type: "PATCH",
        dataType: "JSON",
        url: "insert_message",
        data: {user_id: user_id, friend_id: friend_id, message: message},
        success: function (data) {
            if (data === 1) {
                $('.message_value_send_' + friend_id).val('').css("border", "1px");
                get_messages(user_id, friend_id);

            } else if (data === 2) {
                $('.message_value_send_' + friend_id).css("border", "3px solid red");
            }
        }
    });
}

function messages_get_read() {
    $.ajax({
        url: 'messages_get_read',
        type: 'PATCH',
        dataType: 'JSON',
        success: function (data) {
            $('.send_msg').css('background-color' , 'transparent');
            for (let i of data){
                $('.msg_'+i.user_id).css('background-color' , 'red');
            }
        }
    });
}

setInterval(messages_get_read,2500);
