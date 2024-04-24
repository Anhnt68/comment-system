<div class="comment">
    <p>{{ $comment->content }}</p>
    <!-- Nút Reply -->
    <button class="reply-btn" data-parent-id="{{ $comment->id }}">Reply</button>
    <!-- Form reply ẩn -->
    <form class="reply-form" style="display: none;">
        @csrf
        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
        <input type="text" name="content" placeholder="Enter your reply">
        <button type="submit">Submit</button>
    </form>
    <!-- Hiển thị các reply -->
    <div class="replies">
        @if ($comment->replies)
            @foreach ($comment->replies as $reply)
                @include('comment', ['comment' => $reply])
            @endforeach
        @endif
    </div>
</div>
<style>
    .comment {
        /* margin-left: 20px;
        /* Khoảng cách lề bên trái để tạo ra hiệu ứng tòa tháp */
        border-left: 2px solid #ccc;
        /* Đường viền bên trái để tạo ra hiệu ứng tòa tháp */
        padding-left: 10px;
        /* Khoảng cách lề bên trái để tạo ra hiệu ứng tòa tháp */
    } */

    .comment:first-child {
        border-left: none;
        /* Bỏ đường viền bên trái cho comment đầu tiên */
    }

    .replies {
        margin-left: 20px;
        /* Khoảng cách lề bên trái để tạo ra hiệu ứng tòa tháp */
    }
</style>
