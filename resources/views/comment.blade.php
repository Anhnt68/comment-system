<?php
$current_time = time();
$created_at_timestamp = strtotime($comment->created_at);
$difference_seconds = $current_time - $created_at_timestamp;
$difference_minutes = floor($difference_seconds / 60);
$difference_hours = floor($difference_minutes / 60);
$difference_days = floor($difference_hours / 24);
?>





<div class="comment">
    <label for="commentName"
           class="form-label fw-bold commentName m-0 fs-5">{{$comment->user->name}}</label>
    <?php
    if ($difference_days >= 1) {
        echo "<p class='m-0'>{$difference_days} day" . ($difference_days > 1 ? "s" : "") . " ago</p>";
    } elseif ($difference_hours >= 1) {
        echo "<p class='m-0'>{$difference_hours} hour" . ($difference_hours > 1 ? "s" : "") . " ago</p>";
    } else {
        echo "<p class='m-0'>{$difference_minutes} minute" . ($difference_minutes > 1 ? "s" : "") . " ago</p>";
    }
    ?>
    <p class=''>{{ $comment->content }}</p>
    <button class="reply-btn btn btn-outline-primary" data-parent-id="{{ $comment->id }}">Reply</button>
    <a href="https://www.facebook.com/sharer/sharer.php?u=http://comment-system.test/home" target="_blank"><i class="fab fa-facebook-square fs-3"></i></a>
    <a href="https://twitter.com/intent/tweet?&url=http://comment-system.test/home" target="_blank"><i class="fab fa-twitter-square fs-3"></i></a>
    <a href="https://t.me/share/url?url=http://comment-system.test/home" target="_blank"><i class="fab fa-telegram fs-3"></i></a>
    <div class="replies">
        @if ($comment->replies)
            @foreach ($comment->replies as $reply)
                @include('comment', ['comment' => $reply])
            @endforeach
        @endif
    </div>
    <!-- Form reply ẩn -->
    <form class="reply-form" style="display: none;">
        @csrf
        <input type="hidden"
               name="user_id"
               value="{{ auth()->user()->id }}">
        <input type="hidden"
               name="parent_id">
        <label for="commentName"
               class="form-label fw-bold">{{ auth()->user()->name }}</label>
        <textarea
            class="form-control commentText"
            name="content"
            rows="3"
            placeholder="Enter your reply"></textarea>
        <button type="submit"
                class="btn btn-primary my-2">
            Submit
        </button>
    </form>

</div>
<style>
    .comment {
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

.reply-btn{
    margin-bottom: 10px;
}

</style>
