// for previewing to post image
var input = document.querySelector("#select_post_img")
input.addEventListener("change", preview)

function preview() {
    var fileobject = this.files[0]
    var filereader = new FileReader()

    filereader.readAsDataURL(fileobject)

    filereader.onload = function() {
        var image_src = filereader.result
        var image = document.querySelector("#post_img")
        image.setAttribute('src', image_src)
        image.setAttribute('style', 'display')
    }
}


//for subscribing a user
$('.subbtn').click(function() {
    var user_id_v = $(this).data('userId');
    var button = this;
    $(button).attr('disabled', true)

    $.ajax({
        url: 'assets/php/ajax.php?subscribe',
        method: 'post',
        dataType: 'json',
        data: { user_id: user_id_v },
        success: function(response) {
            if (response['status']) {
                $(button).attr('disabled', false)
                $(button).data('userId', 0)
                $(button).html('<i class="bi bi-check-circle-fill"></i> Unsubscribe')
                location.reload()

            } else {
                $(button).attr('disabled', false)
                alert('Something went wrong')
            }
        }
    });
});

//for unsubscribing a user
$('.unsubbtn').click(function() {
    var user_id_v = $(this).data('userId');
    var button = this;
    $(button).attr('disabled', true)

    $.ajax({
        url: 'assets/php/ajax.php?unsubscribe',
        method: 'post',
        dataType: 'json',
        data: { user_id: user_id_v },
        success: function(response) {
            if (response['status']) {
                $(button).attr('disabled', false)
                $(button).data('userId', 0)
                $(button).html('<i class="bi bi-person-plus-fill me-3"></i> Subscribe')
                location.reload()

            } else {
                $(button).attr('disabled', false)
                alert('Something went wrong')
            }
        }
    });
});

// for liking the posts
$('.like_btn').click(function() {
    var post_id_v = $(this).data('postId');
    var button = this;
    $(button).attr('disabled', true)

    $.ajax({
        url: 'assets/php/ajax.php?like',
        method: 'post',
        dataType: 'json',
        data: { post_id: post_id_v },
        success: function(response) {

            if (response['status']) {
                $(button).attr('disabled', false)
                $(button).hide()
                $(button).siblings('.unlike_btn').show()
                location.reload()
            } else {
                $(button).attr('disabled', false)
                alert('Something went wrong')
            }
        }
    });
});

// for unliking the posts
$('.unlike_btn').click(function() {
    var post_id_v = $(this).data('postId');
    var button = this;
    $(button).attr('disabled', true)

    $.ajax({
        url: 'assets/php/ajax.php?unlike',
        method: 'post',
        dataType: 'json',
        data: { post_id: post_id_v },
        success: function(response) {

            if (response['status']) {
                $(button).attr('disabled', false)
                $(button).hide()
                $(button).siblings('.like_btn').show()
                location.reload()

            } else {
                $(button).attr('disabled', false)
                alert('Something went wrong')
            }
        }
    });
});

// for disliking the posts
$('.dislike_btn').click(function() {
    var post_id_v = $(this).data('postId');
    var button = this;
    $(button).attr('disabled', true)

    $.ajax({
        url: 'assets/php/ajax.php?dislike',
        method: 'post',
        dataType: 'json',
        data: { post_id: post_id_v },
        success: function(response) {
            if (response['status']) {
                $(button).attr('disabled', false)
                $(button).hide()
                $(button).siblings('.undislike_btn').show()
                location.reload()
            } else {
                $(button).attr('disabled', false)
                alert('Something went wrong')
            }
        }
    });
});

// for removing dislike from a post
$('.undislike_btn').click(function() {
    var post_id_v = $(this).data('postId');
    var button = this;
    $(button).attr('disabled', true)

    $.ajax({
        url: 'assets/php/ajax.php?undislike',
        method: 'post',
        dataType: 'json',
        data: { post_id: post_id_v },
        success: function(response) {
            if (response['status']) {
                $(button).attr('disabled', false)
                $(button).hide()
                $(button).siblings('.dislike_btn').show()
                location.reload()
            } else {
                $(button).attr('disabled', false)
                alert('Something went wrong')
            }
        }
    });
});

// for adding comments
$('.add-comment').click(function() {
    var button = this;
    var comment_v = $(button).siblings('.comment-input').val()
    if (comment_v == '') {
        return 0;
    }
    var post_id_v = $(this).data('postId')
    var cs = $(this).data('cs')

    $(button).attr('disabled', true)
    $(button).siblings('.comment-input').attr('disabled', true)
    $.ajax({
        url: 'assets/php/ajax.php?addcomment',
        method: 'post',
        dataType: 'json',
        data: { post_id: post_id_v, comment: comment_v },
        success: function(response) {

            if (response['status']) {
                $(button).attr('disabled', false)
                $(button).siblings('.comment-input').attr('disabled', false)
                $(button).siblings('.comment-input').val('')
                $("#" + cs).append(response['comment'])
                $('.nce').hide()

            } else {
                $(button).attr('disabled', false)
                $(button).siblings('.comment-input').attr('disabled', false)
                alert('Something went wrong')
            }
        }
    });
});

var sr = false;
$("#search").focus(function() {
    $("#search_result").show();
});

$("#close_search").click(function() {
    $("#search_result").hide();
});

$("#search").keyup(function() {
    var keyword_v = $(this).val();

    $.ajax({
        url: 'assets/php/ajax.php?search',
        method: 'post',
        dataType: 'json',
        data: { keyword: keyword_v },
        success: function(response) {
            console.log(response);
            if (response.status) {
                $("#sra").html(response.users);
            } else {
                $("#sra").html('<p class="text-center text-muted">No users found.</p>');
            }
        }
    });

});

$("#show_not").click(function() {
    $.ajax({
        url: 'assets/php/ajax.php?notread',
        method: 'post',
        dataType: 'json',
        success: function(response) {
            if (response.status) {
                $(".un-count").hide();
            }
        }
    });

});