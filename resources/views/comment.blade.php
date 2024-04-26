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
    <span id="share-content"><i class="fas fa-share-square"></i></span>
    <div class="social-network" >
        <a href="https://www.facebook.com/sharer/sharer.php?u=http://comment-system.test/home" target="_blank"><i class="fab fa-facebook-square fs-3" title="Facebook"></i></a>
        <a href="https://twitter.com/intent/tweet?&url=http://comment-system.test/home" target="_blank"><i class="fab fa-twitter-square fs-3" title="Twitter"></i></a>
        <a href="https://t.me/share/url?url=http://comment-system.test/home" target="_blank"><i class="fab fa-telegram fs-3" title="Telegram"></i></a>
        <a href="https://www.linkedin.com/shareArticle?mini=true&title=Comment System&url=http%3A%2F%2Fcomment-system.test%2Fhome" target="_blank"><i class="fab fa-linkedin fs-3" title="Linkedin"></i></a>
        <a href="https://www.reddit.com/submit?url=http://comment-system.test/home" target="_blank"><i class="fab fa-reddit-square fs-3" title="Reddit"></i></a>
        <a href="https://www.quora.com/share?url=http://comment-system.test/home" target="_blank"><i class="fab fa-quora fs-3" title="Quora"></i></a>
        <a class="tumblr-share-button" href="https://www.tumblr.com/share?url=http://comment-system.test/home" target="_blank"><i class="fab fa-tumblr-square fs-3" title="Tumblr"></i></a>
        <a class="count_pinterest" href="javascript:pinIt();" ><i class="fab fa-pinterest-square fs-3" title="Pinterest"></i></a>
    </div>


    <form class="reply-form" style="display: none;">
        @csrf
        <input type="hidden"
               name="user_id"
               value="{{ auth()->user()->id }}">
        <input type="hidden"
               name="parent_id">
        <label for="commentName"
               class="form-label fw-bold">{{ auth()->user()->name }}</label>
        <input type="text"
               class="form-control commentText pb-2 mb-4 rounded-0 text-dark border-bottom border-dark outline-0 border-0"
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
    <div class="replies">
        @if ($comment->replies)
            @foreach ($comment->replies as $reply)
                @include('comment', ['comment' => $reply])
            @endforeach
        @endif
    </div>
    <!-- Form reply ẩn -->


</div>
<style>
    .social-network {
        display: none;
    }
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
{{--<script id="tumblr-js" async src="https://assets.tumblr.com/share-button.js"></script>--}}



