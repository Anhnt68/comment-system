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
    <meta property="og:image" content="https://store-images.s-microsoft.com/image/apps.39241.13695268441854138.b66d38c1-5399-4eb1-919c-81ca75db686f.2c431d86-0de1-4c9a-a4ca-53cc8332ef13?h=464">
    <title>Comments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
<div class="container mt-5">
    <h1>Comments</h1>
    <div id="comments">
        @foreach ($comments as $comment)
            @include('comment', ['comment' => $comment])
        @endforeach
    </div>
    <form id="commentForm"
          action="{{ route('comment.store') }}"
          method="post">
        @csrf
        <input type="hidden"
               name="user_id"
               value="{{ auth()->user()->id }}">
        <input type="hidden"
               name="parent_id">
        <label for="commentName"
               class="form-label fw-bold commentName m-0 fs-5">{{ auth()->user()->name }}</label>
        <textarea
            class="form-control commentText"
            name="content"
            id="commentText"
            rows="3"
            placeholder="Enter your reply"></textarea>
        <button type="submit"
                class="btn btn-primary my-2">
            Submit
        </button>
        <p id="iconButton" class="btn btn-secondary my-2">Select Icon</p>
    </form>
    <div id="iconModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="iconList" class="icon-list"></div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<script>
    $(document).ready(function () {
        $('#iconButton').on('click', function() {
            var modal = $('#iconModal');
            modal.css('display', 'block');
            var iconList = $('#iconList');
            iconList.html('');
            var icons = ['&#128151', '&#128525', '&#128516', '&#128151', '&#128151'];
            icons.forEach(function(icon) {
                var iconElement = $('<div class="icon">' + icon + '</div>');
                iconElement.on('click', function() {
                    var commentText = $('#commentText');
                    var currentText = commentText.val();
                    var newIcon = ' ' + icon;
                    commentText.val(currentText + newIcon);
                    modal.css('display', 'none');
                });
                iconList.append(iconElement);
            });
        });


        // Function to close the modal when the user clicks outside of it
        var modal = document.getElementById('iconModal');
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // Function to close the modal when the user clicks on the close button
        var closeBtn = document.querySelector('.close');
        closeBtn.onclick = function() {
            modal.style.display = "none";
        };



        // Gửi comment mới qua AJAX khi form được gửi
        $('#commentForm').on('submit', function (e) {
            e.preventDefault();
            var formData = $(this).serialize();
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
                        var newCommentHTML =
                            '<div class="replies"></div>' +
                            '</div>' +
                            '<div class="comment">' +
                            '<div class="box-content">' +
                            '<label for="commentName" class="form-label fw-bold m-0 fs-5">' + response.user + '</label>' +
                            '<p class="m-0">' + minutesDifference + 'minute ago</p>' +
                            '<p>' + response.comment.content + '</p>' +
                            '<button class="reply-btn btn btn-outline-primary" data-parent-id="' + response.comment.id + '">Reply</button>' +
                            '</div>' +
                            '<form class="reply-form" style="display: none;">' +
                            '@csrf' +
                            '<label for="commentName" class="form-label fw-bold fs-5">' + response.user + '</label>' +
                            '<input type="hidden" name="parent_id" value="' + response.comment.id + '">' +
                            '<input type="hidden" name="user_id" value="' + response.user + '">' +
                            '<textarea class="form-control commentText" name="content" id="commentText" rows="3" placeholder="Enter your reply"></textarea>' +
                            '<button type="submit" class="btn btn-primary my-2">Submit</button>' +
                            '<p id="iconButton" class="btn btn-secondary my-2">Select Icon</p>'+
                            '</form>';


                        // Nếu là comment cấp 1, thêm vào #comments
                        if (response.comment.parent_id == null) {
                            $('#comments').append(newCommentHTML);
                            $('.commentText').val('');
                        }
                        // Nếu là comment con, tìm comment cha và thêm vào phần replies của cha
                        else {
                            var parentComment = $('#comments').find(
                                '.comment[data-comment-id="' + response.comment
                                    .parent_id + '"]');
                            if (parentComment.length > 0) {
                                parentComment.find('.replies').append(newCommentHTML);
                            } else {
                                $('#comments').append(newCommentHTML);
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


        $('.reply-form').on('submit', function (e) {
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
                            '<div class="replies"></div>' +
                            '</div>' +
                            '<div class="comment">' +
                            '<div class="box-content">' +

                            '<label for="commentName" class="form-label fw-bold commentName m-0 fs-5">' + response.user + '</label>' +
                            '<p class="m-0">' + minutesDifference + 'minute ago</p>' +
                            '<p>' + response.comment.content + '</p>' +
                            '<button class="reply-btn btn btn-outline-primary" data-parent-id="' + response.comment.id + '">Reply</button>' +
                            '</div>' +
                            '<form class="reply-form" style="display: none;">' +
                            '@csrf' +
                            '<label for="commentName" class="form-label fw-bold fs-5">' + response.user + '</label>' +
                            '<input type="hidden" name="parent_id" value="' + response.comment.id + '">' +
                            '<input type="hidden" name="user_id" value="' + response.user + '">' +
                            '<textarea class="form-control commentText" name="content" id="commentText1" rows="3" placeholder="Enter your reply"></textarea>'
                            '</form>'
                        ;
                        $form.siblings('.replies').append(newReplyHTML);
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

    });
</script>
</body>

</html>
