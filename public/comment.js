$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    console.log($('meta[name="csrf-token"]').attr('content'));
    $.ajax({
        type: 'GET',
        url: "http://127.0.0.1:8000/api/comment/",
        dataType: 'json',
        success: function (response) {
            console.log(response)
            if (response.success) {
                var formDefault = '<h1>Comments</h1>' +
                    '<form id="commentForm" action="" method="post">' +
                '<div class="d-flex">' +
                '<div class="form-image pe-2">' +
                '<img src="https://w7.pngwing.com/pngs/981/150/png-transparent-admin-user-web-creanimasi-web-icon.png" alt="" style="width: 50px;height: 50px;">' +
                '</div>' +
                '<div class="form-content w-100">' +
                '<input type="hidden" name="user_id" value="1">' +
                '<input type="hidden" name="parent_id" value="0">' +
                '<label for="commentName" class="form-label fw-bold commentName mb-2 fs-6"></label>' +
                '<input type="text" class="form-control commentText" name="content" id="commentText" style="color:#BBB" placeholder="Enter your reply">' +
                '<div class="d-flex justify-content-end align-items-center my-2">' +
                '<button type="submit" class="btn btn-primary"> Submit </button>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</form>' +
                '<div id="comments">' +
                '</div>';
                $('.box-comment-system.comment').prepend(formDefault);
                response.comment.forEach(function (comment) {
                    renderComment(comment);
                });
                $(".commentText").emojioneArea({
                    pickerPosition: "bottom",
                    tonesStyle: "bullet",
                });
            } else {
                console.error('Failed to fetch comments');
            }
        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
        }
    });

    function renderComment(comment) {
        var createdTime = new Date(comment.created_at);
        var currentTime = new Date();
        var timeDifference = Math.abs(currentTime - createdTime);
        var minutesDifference = Math.floor(timeDifference / (1000 * 60));
        var timeAgo;

        if (minutesDifference < 6) {
            timeAgo = minutesDifference + ' minute ago';
        } else if (minutesDifference < 60) {
            timeAgo = minutesDifference + ' minutes ago';
        } else if (minutesDifference < 1440) { // 1440 minutes = 24 hours
            timeAgo = Math.floor(minutesDifference / 60) + ' hours ago';
        } else {
            timeAgo = Math.floor(minutesDifference / 1440) + ' days ago';
        }

        if (timeAgo === '0 minute ago') {
            timeAgo = 'Just sent';
        }
        var newCommentHTML =
            '<div class="comment">' +
            '<div class="d-flex">' +
            '<div class="box-image pe-2 ">' +
            '<img src="https://w7.pngwing.com/pngs/981/150/png-transparent-admin-user-web-creanimasi-web-icon.png" alt="" style="width: 50px;height: 50px;">' +
            '</div>' +
            '<div class="box-content">' +
            '<label for="commentName" class="form-label fw-bold mb-2 fs-6">' + comment.user.name + '</label>' +
            '<span class="m-0 ps-2" style="font-size: 12px;">' + timeAgo + ' </span>' +
            '<p>' + comment.content + '</p>' +
            '<button class="reply-btn btn btn-outline-primary" data-parent-id="' + comment.id + '" style="font-size: 10px;">Reply</button>' +
            '</div>' +
            '<span class="share-container">' +
            '<span class="share-content ps-2"><i class="fas fa-share-square"></i></span>' +
            '<div class="social-network ps-2">' +
            '<a href="https://www.facebook.com/sharer/sharer.php?u=http://comment-system.test/home" target="_blank"><i class="fab fa-facebook-square fs-3 pe-2" title="Facebook"></i></a>' +
            '<a href="https://twitter.com/intent/tweet?&url=http://comment-system.test/home" target="_blank"><i class="fab fa-twitter-square fs-3 pe-2" title="Twitter"></i></a>' +
            '<a href="https://t.me/share/url?url=http://comment-system.test/home" target="_blank"><i class="fab fa-telegram fs-3 pe-2" title="Telegram"></i></a>' +
            '<a href="https://www.linkedin.com/shareArticle?mini=true&title=Comment System&url=http%3A%2F%2Fcomment-system.test%2Fhome" target="_blank"><i class="fab fa-linkedin fs-3 pe-2" title="Linkedin"></i></a>' +
            '<a href="https://www.reddit.com/submit?url=http://comment-system.test/home" target="_blank"><i class="fab fa-reddit-square fs-3 pe-2" title="Reddit"></i></a>' +
            '<a href="https://www.quora.com/share?url=http://comment-system.test/home" target="_blank"><i class="fab fa-quora fs-3 pe-2" title="Quora"></i></a>' +
            '<a class="tumblr-share-button" href="https://www.tumblr.com/share?url=http://comment-system.test/home" target="_blank"><i class="fab fa-tumblr-square fs-3 pe-2" title="Tumblr"></i></a>' +
            '<a class="count_pinterest" href="javascript:pinIt();"><i class="fab fa-pinterest-square fs-3 pe-2" title="Pinterest"></i></a>' +
            '</div>' +
            '</span>' +
            '</div>' +
            '<form class="reply-form" style="display: none;">' +
            '<div class="d-flex">' +
            '<div class="form-image pe-2">' +
            '<img src="https://w7.pngwing.com/pngs/981/150/png-transparent-admin-user-web-creanimasi-web-icon.png" alt="" style="width: 50px;height: 50px;">' +
            '</div>' +
            '<div class="form-content w-100">' +
            '<input type="hidden" name="parent_id" value="' + comment.id + '">' +
            '<input type="hidden" name="user_id" value="{{ auth()->user()->id }}">' +
            '<input type="hidden" name="parent_id">' +
            '<label for="commentName" class="form-label fw-bold commentName mb-2 fs-6">{{ auth()->user()->name }}</label>' +
            '<input type="text" class="form-control commentText" name="content" id="commentText" placeholder="Enter your reply">' +
            '<div class="d-flex justify-content-end align-items-center my-2">' +
            '<button type="submit" class="btn btn-primary"> Submit </button>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</form>' +
            '<div class="replies"></div>';


        if (Array.isArray(comment.replies) && comment.replies.length > 0) {
            comment.replies.reverse();
            comment.replies.forEach(function (reply) {
                var user = comment.user.name;
                newCommentHTML += renderReply(reply, user);
            });
        }
        newCommentHTML += '</div>';
        $('.box-comment-system.comment').append(newCommentHTML);
        $('.reply-form').css('display', 'none');
    }

    function renderReply(reply, user) {
        var createdTime = new Date(reply.created_at);
        var currentTime = new Date();
        var timeDifference = Math.abs(currentTime - createdTime);
        var minutesDifference = Math.floor(timeDifference / (1000 * 60));
        var timeAgo;

        if (minutesDifference < 6) {
            timeAgo = minutesDifference + ' minute ago';
        } else if (minutesDifference < 60) {
            timeAgo = minutesDifference + ' minutes ago';
        } else if (minutesDifference < 1440) { // 1440 minutes = 24 hours
            timeAgo = Math.floor(minutesDifference / 60) + ' hours ago';
        } else {
            timeAgo = Math.floor(minutesDifference / 1440) + ' days ago';
        }

        if (timeAgo === '0 minute ago') {
            timeAgo = 'Just sent';
        }


        var replyHTML =
            '<div class="comment1">' +
            '<div class="d-flex">' +
            '<div class="box-image pe-2">' +
            '<img src="https://w7.pngwing.com/pngs/981/150/png-transparent-admin-user-web-creanimasi-web-icon.png" alt="" style="width: 50px;height: 50px;">' +
            '</div>' +
            '<div class="box-content">' +
            '<label for="commentName" class="form-label fw-bold mb-2 fs-6">' + user + '</label>' +
            '<span class="m-0 ps-2" style="font-size: 12px;">' + timeAgo + ' </span>' +
            '<p>' + reply.content + '</p>' +
            '</div>' +
            '<span class="share-container">' +
            '<span class="share-content ps-2"><i class="fas fa-share-square"></i></span>' +
            '<div class="social-network ps-2">' +
            '<a href="https://www.facebook.com/sharer/sharer.php?u=http://comment-system.test/home" target="_blank"><i class="fab fa-facebook-square fs-3 pe-2" title="Facebook"></i></a>' +
            '<a href="https://twitter.com/intent/tweet?&url=http://comment-system.test/home" target="_blank"><i class="fab fa-twitter-square fs-3 pe-2" title="Twitter"></i></a>' +
            '<a href="https://t.me/share/url?url=http://comment-system.test/home" target="_blank"><i class="fab fa-telegram fs-3 pe-2" title="Telegram"></i></a>' +
            '<a href="https://www.linkedin.com/shareArticle?mini=true&title=Comment System&url=http%3A%2F%2Fcomment-system.test%2Fhome" target="_blank"><i class="fab fa-linkedin fs-3 pe-2" title="Linkedin"></i></a>' +
            '<a href="https://www.reddit.com/submit?url=http://comment-system.test/home" target="_blank"><i class="fab fa-reddit-square fs-3 pe-2" title="Reddit"></i></a>' +
            '<a href="https://www.quora.com/share?url=http://comment-system.test/home" target="_blank"><i class="fab fa-quora fs-3 pe-2" title="Quora"></i></a>' +
            '<a class="tumblr-share-button" href="https://www.tumblr.com/share?url=http://comment-system.test/home" target="_blank"><i class="fab fa-tumblr-square fs-3 pe-2" title="Tumblr"></i></a>' +
            '<a class="count_pinterest" href="javascript:pinIt();"><i class="fab fa-pinterest-square fs-3 pe-2" title="Pinterest"></i></a>' +
            '</div>' +
            '</span>' +
            '</div>' +
            '<div class="replies">' +
            '</div></div>';
        return replyHTML;
    }

    $(document).on('submit', '#commentForm', function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: "http://127.0.0.1:6600/comment",
            data: formData,
            success: function (response) {
                console.log(response.comment);
                if (response.success) {
                    var createdTime = new Date(response.comment.created_at);
                    var currentTime = new Date();
                    var timeDifference = Math.abs(currentTime - createdTime);
                    var minutesDifference = Math.floor(timeDifference / (1000 * 60));
                    var timeAgo;
                    if (minutesDifference < 6) {
                        timeAgo = minutesDifference + ' minute ago';
                    } else if (minutesDifference < 60) {
                        timeAgo = minutesDifference + ' minutes ago';
                    } else if (minutesDifference < 1440) { // 1440 minutes = 24 hours
                        timeAgo = Math.floor(minutesDifference / 60) + ' hours ago';
                    } else {
                        timeAgo = Math.floor(minutesDifference / 1440) + ' days ago';
                    }

                    if (timeAgo === '0 minute ago') {
                        timeAgo = 'Just sent';
                    }
                    var newCommentHTML =
                        '<div class="comment">' +
                        '<div class="d-flex">' +
                        '<div class="box-image pe-2">' +
                        '<img src="https://w7.pngwing.com/pngs/981/150/png-transparent-admin-user-web-creanimasi-web-icon.png" alt="" style="width: 50px;height: 50px;">' +
                        '</div>' +
                        '<div class="box-content">' +
                        '<label for="commentName" class="form-label fw-bold mb-2 fs-6">' + response.comment.user + '</label>' +
                        '<span class="m-0 ps-2" style="font-size: 12px;">' + timeAgo + ' </span>' +
                        '<p>' + response.comment.content + '</p>' +
                        '<button class="reply-btn btn btn-outline-primary" data-parent-id="' + response.comment.id + '" style="font-size: 10px;">Reply</button>' +
                        '</div>' +
                        '<span class="share-container">' +
                        '<span class="share-content ps-2"><i class="fas fa-share-square"></i></span>' +
                        '<div class="social-network ps-2">' +
                        '<a href="https://www.facebook.com/sharer/sharer.php?u=http://comment-system.test/home" target="_blank"><i class="fab fa-facebook-square fs-3 pe-2" title="Facebook"></i></a>' +
                        '<a href="https://twitter.com/intent/tweet?&url=http://comment-system.test/home" target="_blank"><i class="fab fa-twitter-square fs-3 pe-2" title="Twitter"></i></a>' +
                        '<a href="https://t.me/share/url?url=http://comment-system.test/home" target="_blank"><i class="fab fa-telegram fs-3 pe-2" title="Telegram"></i></a>' +
                        '<a href="https://www.linkedin.com/shareArticle?mini=true&title=Comment System&url=http%3A%2F%2Fcomment-system.test%2Fhome" target="_blank"><i class="fab fa-linkedin fs-3 pe-2" title="Linkedin"></i></a>' +
                        '<a href="https://www.reddit.com/submit?url=http://comment-system.test/home" target="_blank"><i class="fab fa-reddit-square fs-3 pe-2" title="Reddit"></i></a>' +
                        '<a href="https://www.quora.com/share?url=http://comment-system.test/home" target="_blank"><i class="fab fa-quora fs-3 pe-2" title="Quora"></i></a>' +
                        '<a class="tumblr-share-button" href="https://www.tumblr.com/share?url=http://comment-system.test/home" target="_blank"><i class="fab fa-tumblr-square fs-3 pe-2" title="Tumblr"></i></a>' +
                        '<a class="count_pinterest" href="javascript:pinIt();"><i class="fab fa-pinterest-square fs-3 pe-2" title="Pinterest"></i></a>' +
                        '</div>' +
                        '</span>' +
                        '</div>' +
                        '<form class="reply-form" method="post" style="display: none;">' +
                        '<div class="d-flex">' +
                        '<div class="form-image pe-2">' +
                        '<img src="https://w7.pngwing.com/pngs/981/150/png-transparent-admin-user-web-creanimasi-web-icon.png" alt="" style="width: 50px;height: 50px;">' +
                        '</div>' +
                        '<div class="form-content w-100">' +
                        '<input type="hidden" name="user_id" value="{{ auth()->user()->id }}">' +
                        '<input type="hidden" name="parent_id" value="' + response.comment.id + '">' +
                        '<label for="commentName" class="form-label fw-bold commentName mb-2 fs-6">{{ auth()->user()->name }}</label>' +
                        '<input type="text" class="form-control commentText" name="content" id="commentText" placeholder="Enter your reply">' +
                        '<div class="d-flex justify-content-end align-items-center my-2">' +
                        '<button type="submit" class="btn btn-primary"> Submit </button>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</form>' +
                        '<div class="replies"></div>' +
                        '</div>';

                    $('.emojionearea-editor').html('');
                    // Nếu là comment cấp 1, thêm vào #comments
                    if (response.comment.parent_id == null) {
                        $('#comments').prepend(newCommentHTML);
                    } else {
                        var parentComment = $('#comments').find(
                            '.comment[data-comment-id="' + response.comment
                                .parent_id + '"]');
                        if (parentComment.length > 0) {
                            parentComment.find('.replies').prepend(newCommentHTML);
                        } else {
                            $('#comments').prepend(newCommentHTML);
                        }
                    }

                    // Xóa nội dung trong input
                    $('#commentForm input[name="content"]').val('');
                } else {
                    console.error('Failed to create comment');
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });


    $(document).on('submit', '.reply-form', function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        var $form = $(this);
        $.ajax({
            type: 'POST',
            url: "http://127.0.0.1:6600/comment",
            data: formData,
            success: function (response) {
                console.log(response);
                if (response.success) {
                    var createdTime = new Date(response.comment.created_at);
                    var currentTime = new Date();
                    var timeDifference = Math.abs(currentTime - createdTime);
                    var minutesDifference = Math.floor(timeDifference / (1000 * 60));
                    var timeAgo;

                    if (minutesDifference < 6) {
                        timeAgo = minutesDifference + ' minute ago';
                    } else if (minutesDifference < 60) {
                        timeAgo = minutesDifference + ' minutes ago';
                    } else if (minutesDifference < 1440) {
                        timeAgo = Math.floor(minutesDifference / 60) + ' hours ago';
                    } else {
                        timeAgo = Math.floor(minutesDifference / 1440) + ' days ago';
                    }

                    if (timeAgo === '0 minute ago') {
                        timeAgo = 'Just sent';
                    }
                    // Thêm reply mới vào danh sách hiển thị
                    var newReplyHTML =
                        '<div class="comment">' +
                        '<div class="d-flex">' +
                        '<div class="box-image pe-2">' +
                        '<img src="https://w7.pngwing.com/pngs/981/150/png-transparent-admin-user-web-creanimasi-web-icon.png" alt="" style="width: 50px;height: 50px;">' +
                        '</div>' +
                        '<div class="box-content">' +
                        '<label for="commentName" class="form-label fw-bold mb-2 fs-6">' + response.comment.user + '</label>' +
                        '<span class="m-0 ps-2" style="font-size: 12px;">' + timeAgo + ' </span>' +
                        '<p>' + response.comment.content + '</p>' +
                        '</div>' +
                        '<span class="share-container">' +
                        '<span class="share-content ps-2"><i class="fas fa-share-square"></i></span>' +
                        '<div class="social-network ps-2">' +
                        '<a href="https://www.facebook.com/sharer/sharer.php?u=http://comment-system.test/home" target="_blank"><i class="fab fa-facebook-square fs-3 pe-2" title="Facebook"></i></a>' +
                        '<a href="https://twitter.com/intent/tweet?&url=http://comment-system.test/home" target="_blank"><i class="fab fa-twitter-square fs-3 pe-2" title="Twitter"></i></a>' +
                        '<a href="https://t.me/share/url?url=http://comment-system.test/home" target="_blank"><i class="fab fa-telegram fs-3 pe-2" title="Telegram"></i></a>' +
                        '<a href="https://www.linkedin.com/shareArticle?mini=true&title=Comment System&url=http%3A%2F%2Fcomment-system.test%2Fhome" target="_blank"><i class="fab fa-linkedin fs-3 pe-2" title="Linkedin"></i></a>' +
                        '<a href="https://www.reddit.com/submit?url=http://comment-system.test/home" target="_blank"><i class="fab fa-reddit-square fs-3 pe-2" title="Reddit"></i></a>' +
                        '<a href="https://www.quora.com/share?url=http://comment-system.test/home" target="_blank"><i class="fab fa-quora fs-3 pe-2" title="Quora"></i></a>' +
                        '<a class="tumblr-share-button" href="https://www.tumblr.com/share?url=http://comment-system.test/home" target="_blank"><i class="fab fa-tumblr-square fs-3 pe-2" title="Tumblr"></i></a>' +
                        '<a class="count_pinterest" href="javascript:pinIt();"><i class="fab fa-pinterest-square fs-3 pe-2" title="Pinterest"></i></a>' +
                        '</span>' +
                        '</div>' +
                        '</div>' +
                        '<div class="replies"></div>' +
                        '</div>';
                    ;
                    $form.siblings('.replies').prepend(newReplyHTML);
                    // Xóa nội dung trong input
                    $('.commentText').val('');
                    $('.reply-form').css('display', 'none');
                    $('.emojionearea-editor').html('');

                } else {
                    console.error('Failed to create reply');
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });


    $(document).on('click', '.reply-btn', function () {
        var $replyForm = $(this).closest('.comment').find('.reply-form');
        var parentId = $(this).data('parent-id');
        $replyForm.toggle();
        if ($replyForm.is(':visible')) {
            $replyForm.find('input[name="parent_id"]').val(parentId);
        }
    });
    $(document).on('click', '.share-content', function () {
        var socialNetwork = $(this).next('.social-network');
        socialNetwork.toggle();
    });

    $(document).on('click', '.social-network a', function (e) {
        e.stopPropagation();
    });
    function pinIt() {
        var e = document.createElement('script');
        e.setAttribute('type', 'text/javascript');
        e.setAttribute('charset', 'UTF-8');
        e.setAttribute('src', 'https://assets.pinterest.com/js/pinmarklet.js?r=' + Math.random() * 99999999);
        document.body.appendChild(e);
    }
});
