<!-- resources/views/comments/index.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:url" content="http://comment-system.test/">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Comment System">
    <meta property="og:description" content="Your Page Description">
    <meta property="og:image"
          content="https://store-images.s-microsoft.com/image/apps.39241.13695268441854138.b66d38c1-5399-4eb1-919c-81ca75db686f.2c431d86-0de1-4c9a-a4ca-53cc8332ef13?h=464">
    <title>Comments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://platform.tumblr.com/v1/share.js"></script>

</head>

<body>
<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                <!-- Authentication Links -->
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
<div class="container comment mt-5">

</div>

<style>
    .social-network {
        display: none;
    }

    .comment1 {
        border-left: 2px solid #ccc;
        padding-left: 10px;
    }

    .comment:first-child {
        border-left: none;
    }

    .reply-form,
    .replies {
        margin-left: 20px;
    }

    .reply-btn {
        margin-bottom: 10px;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
<script>
    $(document).ready(function () {
        // Perform AJAX request to fetch comments data
        $.ajax({
            type: 'GET',
            url: "{{ route('home1') }}",
            dataType: 'json', // Specify the expected data type
            success: function (response) {
                console.log(response)
                if (response.success) {
                    var formDefault = '<h1>Comments</h1>' +
                        '<form id="commentForm" action="{{ route('comment.store') }}" method="post">' +
                        '@csrf' +
                        '<input type="hidden" name="user_id" value="{{ auth()->user()->id }}">' +
                        '<input type="hidden" name="parent_id">' +
                        '<label for="commentName" class="form-label fw-bold commentName mb-2 fs-5">{{ auth()->user()->name }}</label>' +
                        '<input type="text" class="form-control commentText pb-2 mb-4 rounded-0 text-dark border-bottom border-dark outline-0 border-0" name="content" id="commentText" placeholder="Enter your reply">' +
                        '<div class="d-flex justify-content-between align-items-center my-2">' +
                        '<p id="iconButton" class="m-0 iconButton"><i class="far fa-laugh"></i></p>' +
                        '<button type="submit" class="btn btn-primary"> Submit </button>' +
                        '</div>' +
                        '</form>' +
                        '<div id="comments">' +
                        '</div>';

                    $('.container.comment').prepend(formDefault);
                    response.comment.forEach(function (comment) {
                        renderComment(comment);
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
            if (minutesDifference === 0) {
                minutesDifference = 1;
            }
            var newCommentHTML =
                '<div class="comment">' +
                '<label for="commentName" class="form-label fw-bold mb-2 fs-5">' + comment.user.name + '</label>' +
                '<p class="m-0">' + minutesDifference + ' minute ago</p>' +
                '<p>' + comment.content + '</p>' +
                '<button class="reply-btn btn btn-outline-primary" data-parent-id="' + comment.id + '">Reply</button>' +
                '<form class="reply-form" style="display: none;">' +
                '@csrf' +
                '<input type="hidden" name="parent_id" value="' + comment.id + '">' +
                '<input type="hidden" name="user_id" value="{{ auth()->user()->id }}">' +
                '<label for="commentName" class="form-label fw-bold commentName mb-2 fs-5">{{ auth()->user()->name }}</label>' +
                '<input type="text" class="form-control commentText pb-2 mb-2 rounded-0 text-dark border-bottom border-dark outline-0 border-0" name="content" placeholder="Enter your reply">' +
                '<div class="d-flex justify-content-between align-items-center my-2">' +
                '<p id="iconButton" class="m-0"><i class="far fa-laugh"></i></p>' +
                '<button type="submit" class="btn btn-primary">Submit</button>' +
                '</div>' +
                '</form>' +
                '<div class="replies"></div>';

            if (Array.isArray(comment.replies) && comment.replies.length > 0) {
                comment.replies.forEach(function (reply) {
                    var user = comment.user.name;
                    newCommentHTML += renderReply(reply,user);
                });
            }

            newCommentHTML += '</div>';
            // Append the new comment HTML to the container
            $('.container.comment').append(newCommentHTML);
        }

        function renderReply(reply ,user) {
            var createdTime = new Date(reply.created_at);
            var currentTime = new Date();
            var timeDifference = Math.abs(currentTime - createdTime);
            var minutesDifference = Math.floor(timeDifference / (1000 * 60));
            if (minutesDifference === 0) {
                minutesDifference = 1;
            }

            var replyHTML =
                '<div class="comment1">' +
                '<label for="commentName" class="form-label fw-bold mb-2 fs-5">' + user + '</label>' +
                '<p class="m-0">' + minutesDifference + 'minute ago</p>' +
                '<p>' + reply.content + '</p>' +
                '<button class="reply-btn btn btn-outline-primary" data-parent-id="' + reply.id + '">Reply</button>' +
                '<form class="reply-form" style="display: none;">' +
                '@csrf' +
                '<input type="hidden" name="parent_id" value="' + reply.id + '">' +
                '<input type="hidden" name="user_id" value="' + reply.user_id + '">' +
                '<label for="commentName" class="form-label fw-bold commentName mb-2 fs-5">{{ auth()->user()->name }}</label>' +
                '<input type="text" class="form-control commentText pb-2 mb-2 rounded-0 text-dark border-bottom border-dark outline-0 border-0" name="content" placeholder="Enter your reply">' +
                '<div class="d-flex justify-content-between align-items-center my-2">' +
                '<p id="iconButton" class="m-0"><i class="far fa-laugh"></i></p>' +
                '<button type="submit" class="btn btn-primary">Submit</button>' +
                '</div>' +
                '</form>' +
                '<div class="replies">';

            if (Array.isArray(reply.replies) && reply.replies.length > 0) {
                reply.replies.forEach(function (nestedReply) {
                    replyHTML += renderReply(nestedReply);
                });
            }
            replyHTML += '</div></div>';
            return replyHTML;
        }

        $(document).on('submit', '#commentForm', function (e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: "{{ route('comment.store') }}",
                data: formData,
                success: function (response) {
                    console.log(response.comment);
                    if (response.success) {
                        var createdTime = new Date(response.comment.created_at);
                        var currentTime = new Date();
                        var timeDifference = Math.abs(currentTime - createdTime);
                        var minutesDifference = Math.floor(timeDifference / (1000 * 60));
                        if (minutesDifference === 0) {
                            minutesDifference = 1;
                        }
                        var newCommentHTML =

                            '<div class="comment">' +
                            '<label for="commentName" class="form-label fw-bold mb-2 fs-5">' + response.comment.user + '</label>' +
                            // '<p class="m-0">' + minutesDifference + 'minute ago</p>' +
                            '<p>' + response.comment.content + '</p>' +
                            '<button class="reply-btn btn btn-outline-primary" data-parent-id="' + response.comment.id + '">Reply</button>' +

                            '<form class="reply-form" style="display: none;">' +
                            '@csrf' +
                            '<label for="commentName" class="form-label fw-bold fs-5">{{ auth()->user()->name }}</label>' +
                            '<input type="hidden" name="parent_id" value="' + response.comment.id + '">' +
                            '<input type="hidden" name="user_id" value="{{ auth()->user()->id }}">' +
                            '<input type="text" class="form-control commentText pb-2 mb-2 rounded-0 text-dark border-bottom border-dark outline-0 border-0" name="content" placeholder="Enter your reply">' +
                            '<div class="d-flex justify-content-between align-items-center my-2">' +
                            '<p id="iconButton" class="m-0"><i class="far fa-laugh"></i></p>' +
                            '<button type="submit" class="btn btn-primary">Submit</button>' +
                            '</div>' +
                            '</form>' +
                            '<div class="replies"></div>' +
                            '</div>';


                        // Nếu là comment cấp 1, thêm vào #comments
                        if (response.comment.parent_id == null) {
                            $('#comments').prepend(newCommentHTML);
                            $('.commentText').val('');
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
                url: "{{ route('comment.store') }}",
                data: formData,
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                        var createdTime = new Date(response.comment.created_at);
                        var currentTime = new Date();
                        var timeDifference = Math.abs(currentTime - createdTime);
                        var minutesDifference = Math.floor(timeDifference / (1000 * 60));
                        if (minutesDifference === 0) {
                            minutesDifference = 1;
                        }
                        // Thêm reply mới vào danh sách hiển thị
                        var newReplyHTML =
                            '<div class="comment">' +
                            '<label for="commentName" class="form-label fw-bold mb-2 fs-5">' + response.comment.user + '</label>' +
                            '<p class="m-0">' + minutesDifference + 'minute ago</p>' +
                            '<p>' + response.comment.content + '</p>' +
                            '<button class="reply-btn btn btn-outline-primary" data-parent-id="' + response.comment.id + '">Reply</button>' +

                            '<form class="reply-form" style="display: none;">' +
                            '@csrf' +
                            '<label for="commentName" class="form-label fw-bold fs-5">{{ auth()->user()->name }}</label>' +
                            '<input type="hidden" name="parent_id" value="' + response.comment.id + '">' +
                            '<input type="hidden" name="user_id" value="{{ auth()->user()->id }}">' +
                            '<input type="text" class="form-control commentText pb-2 mb-2 rounded-0 text-dark border-bottom border-dark outline-0 border-0" name="content" placeholder="Enter your reply">' +
                            '<div class="d-flex justify-content-between align-items-center my-2">' +
                            '<p id="iconButton" class="m-0"><i class="far fa-laugh"></i></p>' +
                            '<button type="submit" class="btn btn-primary">Submit</button>' +
                            '</div>' +
                            '</form>' +
                            '<div class="replies"></div>' +
                            '</div>';
                        ;
                        $form.siblings('.replies').prepend(newReplyHTML);
                        // Xóa nội dung trong input
                        $('.commentText').val('');

                    } else {
                        console.error('Failed to create reply');
                    }
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });


        // Hiển thị form reply khi nhấp vào nút Reply
        $(document).on('click', '.reply-btn', function () {
            var $replyForm = $(this).siblings('.reply-form');
            var parentId = $(this).data('parent-id');

            // Toggle hiển thị/ẩn form reply
            $replyForm.toggle();

            // Nếu form reply được hiển thị, thiết lập giá trị cho input parent_id
            if ($replyForm.is(':visible')) {
                $replyForm.find('input[name="parent_id"]').val(parentId);
            }
        });

        $(document).on('click', '.iconButton', function () {
            var modal = $('#iconModal');
            modal.css('display', 'block');

            var iconList = $('#iconList');
            iconList.html(''); // Xóa nội dung cũ

            var icons = [
                '\u{1F600}', '\u{1F601}', '\u{1F602}', '\u{1F603}', '\u{1F604}', '\u{1F605}', '\u{1F606}', '\u{1F607}', '\u{1F608}', '\u{1F609}',
                '\u{1F60A}', '\u{1F60B}', '\u{1F60C}', '\u{1F60D}', '\u{1F60E}', '\u{1F60F}', '\u{1F610}', '\u{1F611}', '\u{1F612}', '\u{1F613}',
                '\u{1F614}', '\u{1F615}', '\u{1F616}', '\u{1F617}', '\u{1F618}', '\u{1F619}', '\u{1F61A}', '\u{1F61B}', '\u{1F61C}', '\u{1F61D}',
                '\u{1F61E}', '\u{1F61F}', '\u{1F620}', '\u{1F621}', '\u{1F622}', '\u{1F623}', '\u{1F624}', '\u{1F625}', '\u{1F626}', '\u{1F627}',
                '\u{1F628}', '\u{1F629}', '\u{1F62A}', '\u{1F62B}', '\u{1F62C}', '\u{1F62D}', '\u{1F62E}', '\u{1F62F}', '\u{1F630}', '\u{1F631}',
                '\u{1F632}', '\u{1F633}', '\u{1F634}', '\u{1F635}', '\u{1F636}', '\u{1F637}', '\u{1F638}', '\u{1F639}', '\u{1F63A}', '\u{1F63B}',
                '\u{1F63C}', '\u{1F63D}', '\u{1F63E}', '\u{1F63F}', '\u{1F640}'
            ];

            icons.forEach(function (icon) {
                var iconElement = $('<span class="icon">' + icon + '</span>');
                iconElement.css({
                    'font-size': '24px',
                    'cursor': 'pointer',
                    'margin': '5px'
                });
                iconElement.on('click', function () {
                    var commentText = $(this).closest('.comment').find('.commentText');
                    var currentText = commentText.val();
                    var newIcon = ' ' + icon;
                    commentText.val(currentText + newIcon);
                    modal.css('display', 'none');
                });
                iconList.append(iconElement);
            });
        });

        var commentText = $('#commentText');
        var submitButton = $('#submitButton');

        // Khi input được focus
        commentText.focus(function () {
            submitButton.show(); // Hiển thị nút submit
            $(this).addClass('active'); // Thêm class "active" cho input được focus
        });

        // Khi input mất focus
        commentText.blur(function () {
            // Nếu không có text trong input
            if ($(this).val().trim() === '') {
                submitButton.hide(); // Ẩn nút submit
                $(this).removeClass('active'); // Xóa class "active" cho input
            }
        });

        const shareContents = document.querySelectorAll('.share-content');

        shareContents.forEach(function (shareContent) {
            const socialNetwork = shareContent.nextElementSibling;

            shareContent.addEventListener('click', function () {
                socialNetwork.style.display = (socialNetwork.style.display === 'block') ? 'none' : 'block';
            });

            socialNetwork.addEventListener('click', function (e) {
                if (e.target.tagName === 'A') {
                    socialNetwork.style.display = 'none';
                }
            });
        });


        function pinIt() {
            var e = document.createElement('script');
            e.setAttribute('type', 'text/javascript');
            e.setAttribute('charset', 'UTF-8');
            e.setAttribute('src', 'https://assets.pinterest.com/js/pinmarklet.js?r=' + Math.random() * 99999999);
            document.body.appendChild(e);
        }

    });


</script>
</body>

</html>
