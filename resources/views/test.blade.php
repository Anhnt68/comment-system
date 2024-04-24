<!-- resources/views/comments/index.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comments</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <h1>Comments</h1>

    <div id="comments">
        @foreach ($comments as $comment)
            @include('comment', ['comment' => $comment])
        @endforeach
    </div>


    <form id="commentForm" method="post">
        @csrf
        <input type="text" name="content">
        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
        <input type="hidden" name="parent_id">
        <button type="submit">Submit</button>
    </form>

    <!-- Form reply -->
    <form class="reply-form" style="display: none;">
        @csrf
        <input type="hidden" name="parent_id" value="">
        <input type="text" name="content" placeholder="Enter your reply">
        <button type="submit">Reply</button>
    </form>

    <script>
        // $(document).ready(function() {
        //     $('.reply-btn').click(function() {
        //         var parentId = $(this).data('parent-id');
        //         $('.reply-form').hide(); // Ẩn tất cả các form reply trước đó
        //         $(this).siblings('.reply-form').find('input[name="parent_id"]').val(parentId);
        //         $(this).siblings('.reply-form').show();
        //     });

        //     // Gửi comment mới qua AJAX khi form được gửi
        //     $('#commentForm').on('submit', function(e) {
        //         e.preventDefault();
        //         var formData = $(this).serialize();
        //         $.ajax({
        //             type: 'POST',
        //             url: "{{ route('comment.store') }}",
        //             data: formData,
        //             success: function(response) {
        //                 console.log(response);
        //                 // Thêm comment mới vào danh sách hiển thị
        //                 $('#comments').append('<div>' + response.comment.content + '</div>');
        //                 // Xóa nội dung trong input
        //                 $('#commentForm input[name="content"]').val('');
        //             },
        //             error: function(xhr, status, error) {
        //                 console.error(xhr.responseText);
        //             }
        //         });
        //     });

        //     $('.reply-form').on('submit', function(e) {
        //         e.preventDefault();
        //         var formData = $(this).serialize();
        //         $.ajax({
        //             type: 'POST',
        //             url: "{{ route('comment.store') }}",
        //             data: formData,
        //             success: function(response) {
        //                 console.log(response);
        //                 if (response.success) {
        //                     // Thêm HTML của comment mới vào danh sách hiển thị
        //                     $('#comments').append(response.html);
        //                     // Xóa nội dung trong input
        //                     $('.reply-form input[name="content"]').val('');
        //                 } else {
        //                     console.error('Failed to create reply');
        //                 }
        //             },
        //             error: function(xhr, status, error) {
        //                 console.error(xhr.responseText);
        //             }
        //         });
        //         00
        //     });
        // });

        $(document).ready(function() {
            // Gửi comment mới qua AJAX khi form được gửi
            $('#commentForm').on('submit', function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    type: 'POST',
                    url: "{{ route('comment.store') }}",
                    data: formData,
                    success: function(response) {
                        console.log(response);
                        if (response.success) {
                            // Thêm comment mới vào cây phân cấp hiện tại
                            var newCommentHTML = '<div class="comment">' +
                                '<p>' + response.comment.content + '</p>' +
                                '<button class="reply-btn" data-parent-id="' + response.comment
                                .id + '">Reply</button>' +
                                '<form class="reply-form" style="display: none;">' +
                                '@csrf' +
                                '<input type="hidden" name="parent_id" value="' + response
                                .comment.id + '">' +
                                '<input type="text" name="content" placeholder="Enter your reply">' +
                                '<button type="submit">Submit</button>' +
                                '</form>' +
                                '<div class="replies"></div>' +
                                '</div>';

                            // Nếu là comment cấp 1, thêm vào #comments
                            if (response.comment.parent_id == null) {
                                $('#comments').append(newCommentHTML);
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
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });


            $('.reply-form').on('submit', function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                var $form = $(this);
                $.ajax({
                    type: 'POST',
                    url: "{{ route('comment.store') }}",
                    data: formData,
                    success: function(response) {
                        console.log(response);
                        if (response.success) {
                            // Thêm reply mới vào danh sách hiển thị
                            var newReplyHTML = '<div class="comment">' +
                                '<p>' + response.comment.content + '</p>' +
                                '<button class="reply-btn" data-parent-id="' + response.comment
                                .parent_id + '">Reply</button>' +
                                '<form class="reply-form" style="display: none;">' +
                                '@csrf' +
                                '<input type="hidden" name="parent_id" value="' + response
                                .comment.parent_id + '">' +
                                '<input type="text" name="content" placeholder="Enter your reply">' +
                                '<button type="submit">Submit</button>' +
                                '</form>' +
                                '<div class="replies"></div>' +
                                '</div>';
                            $form.siblings('.replies').append(newReplyHTML);
                            // Xóa nội dung trong input
                            $form.find('input[name="content"]').val('');
                        } else {
                            console.error('Failed to create reply');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });

            // Hiển thị form reply khi nhấp vào nút Reply
            $(document).on('click', '.reply-btn', function() {
                var parentId = $(this).data('parent-id');
                $(this).siblings('.reply-form').show().find('input[name="parent_id"]').val(parentId);
            });
        });
    </script>
</body>

</html>
