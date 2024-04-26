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
<div class="container mt-5">
    <h1>Comments</h1>
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
               class="form-label fw-bold commentName mb-2 fs-5">{{ auth()->user()->name }}</label>
        <input type="text"
               class="form-control commentText pb-2 mb-2 rounded-0 text-dark border-bottom border-dark outline-0 border-0"
               name="content"
               placeholder="Enter your reply">
        <div class="d-flex justify-content-between align-items-center my-2">
            <p id="iconButton" class="m-0"><i class="far fa-laugh"></i></p>
            <button type="submit"
                    class="btn btn-primary">
                Submit
            </button>
        </div>
    </form>

    <div id="iconModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="iconList" class="icon-list"></div>
        </div>
    </div>
    <div id="comments">
        @foreach ($comments as $comment)
            @include('comment', ['comment' => $comment])
        @endforeach
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
<script>
    $(document).ready(function () {
        $('#iconButton').on('click', function () {
            var modal = $('#iconModal');
            modal.css('display', 'block');
            var iconList = $('#iconList');
            iconList.html('');
            var icons = [
                '\u{1F600}', // 😄 - Smiling Face with Open Mouth and Smiling Eyes
                '\u{1F601}', // 😁 - Grinning Face with Smiling Eyes
                '\u{1F602}', // 😂 - Face with Tears of Joy
                '\u{1F603}', // 😃 - Smiling Face with Open Mouth
                '\u{1F604}', // 😄 - Smiling Face with Open Mouth and Smiling Eyes
                '\u{1F605}', // 😅 - Smiling Face with Open Mouth and Cold Sweat
                '\u{1F606}', // 😆 - Smiling Face with Open Mouth and Closed Eyes
                '\u{1F607}', // 😇 - Smiling Face with Halo
                '\u{1F608}', // 😈 - Smiling Face with Horns
                '\u{1F609}', // 😉 - Winking Face
                '\u{1F60A}', // 😊 - Smiling Face with Smiling Eyes
                '\u{1F60B}', // 😋 - Face Savoring Food
                '\u{1F60C}', // 😌 - Relieved Face
                '\u{1F60D}', // 😍 - Smiling Face with Heart-Eyes
                '\u{1F60E}', // 😎 - Smiling Face with Sunglasses
                '\u{1F60F}', // 😏 - Smirking Face
                '\u{1F610}', // 😐 - Neutral Face
                '\u{1F611}', // 😑 - Expressionless Face
                '\u{1F612}', // 😒 - Unamused Face
                '\u{1F613}', // 😓 - Face with Cold Sweat
                '\u{1F614}', // 😔 - Pensive Face
                '\u{1F615}', // 😕 - Confused Face
                '\u{1F616}', // 😖 - Confounded Face
                '\u{1F617}', // 😗 - Kissing Face
                '\u{1F618}', // 😘 - Face Throwing a Kiss
                '\u{1F619}', // 😙 - Kissing Face with Smiling Eyes
                '\u{1F61A}', // 😚 - Kissing Face with Closed Eyes
                '\u{1F61B}', // 😛 - Face with Stuck-Out Tongue
                '\u{1F61C}', // 😜 - Face with Stuck-Out Tongue and Winking Eye
                '\u{1F61D}', // 😝 - Face with Stuck-Out Tongue and Tightly-Closed Eyes
                '\u{1F61E}', // 😞 - Disappointed Face
                '\u{1F61F}', // 😟 - Worried Face
                '\u{1F620}', // 😠 - Angry Face
                '\u{1F621}', // 😡 - Pouting Face
                '\u{1F622}', // 😢 - Crying Face
                '\u{1F623}', // 😣 - Persevering Face
                '\u{1F624}', // 😤 - Face with Steam from Nose
                '\u{1F625}', // 😥 - Sad but Relieved Face
                '\u{1F626}', // 😦 - Frowning Face with Open Mouth
                '\u{1F627}', // 😧 - Anguished Face
                '\u{1F628}', // 😨 - Fearful Face
                '\u{1F629}', // 😩 - Weary Face
                '\u{1F62A}', // 😪 - Sleepy Face
                '\u{1F62B}', // 😫 - Tired Face
                '\u{1F62C}', // 😬 - Grimacing Face
                '\u{1F62D}', // 😭 - Loudly Crying Face
                '\u{1F62E}', // 😮 - Face with Open Mouth
                '\u{1F62F}', // 😯 - Hushed Face
                '\u{1F630}', // 😰 - Face with Open Mouth and Cold Sweat
                '\u{1F631}', // 😱 - Face Screaming in Fear
                '\u{1F632}', // 😲 - Astonished Face
                '\u{1F633}', // 😳 - Flushed Face
                '\u{1F634}', // 😴 - Sleeping Face
                '\u{1F635}', // 😵 - Dizzy Face
                '\u{1F636}', // 😶 - Face Without Mouth
                '\u{1F637}', // 😷 - Face with Medical Mask
                '\u{1F638}', // 😸 - Grinning Cat Face with Smiling Eyes
                '\u{1F639}', // 😹 - Cat Face with Tears of Joy
                '\u{1F63A}', // 😺 - Smiling Cat Face with Open Mouth
                '\u{1F63B}', // 😻 - Smiling Cat Face with Heart-Eyes
                '\u{1F63C}', // 😼 - Cat Face with Wry Smile
                '\u{1F63D}', // 😽 - Kissing Cat Face with Closed Eyes
                '\u{1F63E}', // 😾 - Pouting Cat Face
                '\u{1F63F}', // 😿 - Crying Cat Face
                '\u{1F640}'  // 🙀 - Weary Cat Face
            ];


            icons.forEach(function (icon) {
                var iconElement = $('<span class="icon">' + icon + '</span>'); // Thay div thành span
                iconElement.css({
                    'display': 'inline-block',
                    'font-size': '20px', // Kích thước 200x200
                    'cursor': 'pointer', // Con trỏ chỉ vào biểu tượng sẽ hiện icon
                    'margin': '5px' // Khoảng cách giữa các biểu tượng
                });
                iconElement.on('click', function () {
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
        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // Function to close the modal when the user clicks on the close button
        var closeBtn = document.querySelector('.close');
        closeBtn.onclick = function () {
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

                            '<div class="comment">' +
                            '<label for="commentName" class="form-label fw-bold mb-2 fs-5">' + response.user + '</label>' +
                            '<p class="m-0">' + minutesDifference + 'minute ago</p>' +
                            '<p>' + response.comment.content + '</p>' +
                            '<button class="reply-btn btn btn-outline-primary" data-parent-id="' + response.comment.id + '">Reply</button>' +

                            '<form class="reply-form" style="display: none;">' +
                            '@csrf' +
                            '<label for="commentName" class="form-label fw-bold fs-5">' + response.user + '</label>' +
                            '<input type="hidden" name="parent_id" value="' + response.comment.id + '">' +
                            '<input type="hidden" name="user_id" value="' + response.comment.user_id + '">' +
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
                            $('#comments').append(newCommentHTML);
                            $('.commentText').val('');
                        } else {
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
                            '<div class="comment">' +
                            '<label for="commentName" class="form-label fw-bold mb-2 fs-5">' + response.user + '</label>' +
                            '<p class="m-0">' + minutesDifference + 'minute ago</p>' +
                            '<p>' + response.comment.content + '</p>' +
                            '<button class="reply-btn btn btn-outline-primary" data-parent-id="' + response.comment.id + '">Reply</button>' +

                            '<form class="reply-form" style="display: none;">' +
                            '@csrf' +
                            '<label for="commentName" class="form-label fw-bold fs-5">' + response.user + '</label>' +
                            '<input type="hidden" name="parent_id" value="' + response.comment.id + '">' +
                            '<input type="hidden" name="user_id" value="' + response.comment.user_id + '">' +
                            '<input type="text" class="form-control commentText pb-2 mb-2 rounded-0 text-dark border-bottom border-dark outline-0 border-0" name="content" placeholder="Enter your reply">' +
                            '<div class="d-flex justify-content-between align-items-center my-2">' +
                            '<p id="iconButton" class="m-0"><i class="far fa-laugh"></i></p>' +
                            '<button type="submit" class="btn btn-primary">Submit</button>' +
                            '</div>' +
                            '</form>' +
                            '<div class="replies"></div>' +
                            '</div>';
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


        const shareContent = document.getElementById('share-content');
        const socialNetwork = document.querySelector('.social-network');

        shareContent.addEventListener('click', function () {
            socialNetwork.style.display = (socialNetwork.style.display === 'block') ? 'none' : 'block';
        });

        socialNetwork.addEventListener('click', function (e) {
            if (e.target.tagName === 'A') {
                socialNetwork.style.display = 'none';
            }
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
