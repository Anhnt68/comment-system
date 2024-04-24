@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>Comment</h1>
        <div id="commentSection" class="row d-flex align-items-center mb-2">
            <div class="col-md-12">
                @if(isset($data))
                    @foreach($data as $content)
                        <!-- Kiểm tra parent_id không rỗng -->
                        <!-- Hiển thị comment cha -->
                        <div class="comment-reply ml-4">
                            <div class="row d-flex">
                                @if($content->parent_id == null)

                                    <div class="col-md-1">
                                        <img
                                            src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSXPodEp1Zyixlyx1Rrq6JJlPm0hgg1pFeLNrxgt2bkYw&s"
                                            alt="" style="width: 100px;height: 100px;">
                                    </div>
                                @endif


                                <div class="col-md-11">
                                    <!-- Nội dung comment cha -->
                                    <div class="row" id="commentReplySection{{ $content->id }}" data-parent-id="{{ $content->id }}">
                                        @if($content->parent_id == null)
                                            <div class="col-md-12">
                                                <label for="commentName"
                                                       class="form-label fw-bold">{{$content->user->name}}</label>
                                                    <?php
                                                    $current_time = time();
                                                    $created_at_timestamp = strtotime($content->created_at);
                                                    $difference_seconds = $current_time - $created_at_timestamp;
                                                    $difference_minutes = floor($difference_seconds / 60);
                                                    $difference_hours = floor($difference_minutes / 60);
                                                    $difference_days = floor($difference_hours / 24);
                                                    if ($difference_days >= 1) {
                                                        echo "<p>{$difference_days} day" . ($difference_days > 1 ? "s" : "") . " ago</p>";
                                                    } elseif ($difference_hours >= 1) {
                                                        echo "<p>{$difference_hours} hour" . ($difference_hours > 1 ? "s" : "") . " ago</p>";
                                                    } else {
                                                        echo "<p>{$difference_minutes} minute" . ($difference_minutes > 1 ? "s" : "") . " ago</p>";
                                                    }
                                                    ?>
                                                <p>{{$content->content}}</p>
                                                <button class="btn btn-outline-primary replyBtn"
                                                        data-user-id="{{$content->user_id}}">reply
                                                </button>
                                            </div>
                                        @endif
                                        @foreach($data as $child)
                                            @if($child->parent_id != null && $child->parent_id == $content->id)
                                                <div class="comment-reply ml-4" >
                                                    <div class="row d-flex">
                                                        <div class="col-md-1">
                                                            <img
                                                                src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSXPodEp1Zyixlyx1Rrq6JJlPm0hgg1pFeLNrxgt2bkYw&s"
                                                                alt="" style="width: 100px;height: 100px;">
                                                        </div>
                                                        <div class="col-md-11">
                                                            <!-- Nội dung comment con -->
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <label for="commentName"
                                                                           class="form-label fw-bold">{{$child->user->name}}</label>
                                                                        <?php
                                                                        $current_time = time();
                                                                        $created_at_timestamp = strtotime($child->created_at);
                                                                        $difference_seconds = $current_time - $created_at_timestamp;
                                                                        $difference_minutes = floor($difference_seconds / 60);
                                                                        $difference_hours = floor($difference_minutes / 60);
                                                                        $difference_days = floor($difference_hours / 24);
                                                                        if ($difference_days >= 1) {
                                                                            echo "<p>{$difference_days} day" . ($difference_days > 1 ? "s" : "") . " ago</p>";
                                                                        } elseif ($difference_hours >= 1) {
                                                                            echo "<p>{$difference_hours} hour" . ($difference_hours > 1 ? "s" : "") . " ago</p>";
                                                                        } else {
                                                                            echo "<p>{$difference_minutes} minute" . ($difference_minutes > 1 ? "s" : "") . " ago</p>";
                                                                        }
                                                                        ?>
                                                                    <p>{{$child->content}}</p>
                                                                    <!-- Nút reply -->
                                                                    <button class="btn btn-outline-primary replyBtn"
                                                                            data-user-id="{{$child->user_id}}">reply
                                                                    </button>
                                                                </div>
                                                                @foreach($data as $child1)
                                                                    @if($child1->parent_id != null && $child1->parent_id == $child->id)
                                                                        <div class="comment-reply ml-4">
                                                                            <div class="row d-flex">
                                                                                <div class="col-md-1">
                                                                                    <img
                                                                                        src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSXPodEp1Zyixlyx1Rrq6JJlPm0hgg1pFeLNrxgt2bkYw&s"
                                                                                        alt=""
                                                                                        style="width: 100px;height: 100px;">
                                                                                </div>
                                                                                <div class="col-md-11">
                                                                                    <!-- Nội dung comment con -->
                                                                                    <div class="row">
                                                                                        <div class="col-md-12">
                                                                                            <label for="commentName"
                                                                                                   class="form-label fw-bold">{{$child1->user->name}}</label>
                                                                                            <p>{{$child1->content}}</p>
                                                                                            <!-- Nút reply -->
                                                                                            <button
                                                                                                class="btn btn-outline-primary replyBtn"
                                                                                                data-user-id="{{$child1->user_id}}">
                                                                                                reply
                                                                                            </button>
                                                                                        </div>
                                                                                    </div>
                                                                                    <!-- Form trả lời cho comment con -->
                                                                                    <div class="replyForm"
                                                                                         style="display: none;">
                                                                                        <form id="commentForm"
                                                                                              action="{{ route('comment.store') }}"
                                                                                              method="post">
                                                                                            @csrf
                                                                                            <input type="hidden"
                                                                                                   name="user_id"
                                                                                                   value="{{ auth()->user()->id }}">
                                                                                            <input type="hidden"
                                                                                                   name="parent_id"
                                                                                                   value="{{ $child1->id }}">
                                                                                            <label for="commentName"
                                                                                                   class="form-label fw-bold">{{ auth()->user()->name }}</label>
                                                                                            <textarea
                                                                                                class="form-control"
                                                                                                id="commentText"
                                                                                                name="content"
                                                                                                rows="3"
                                                                                                placeholder="Enter your reply"></textarea>
                                                                                            <button type="submit"
                                                                                                    class="btn btn-primary my-2">
                                                                                                Submit
                                                                                            </button>
                                                                                        </form>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                            <!-- Form trả lời cho comment con -->
                                                            <div class="replyForm" style="display: none;">
                                                                <form id="commentForm"
                                                                      action="{{ route('comment.store') }}"
                                                                      method="post">

                                                                    @csrf
                                                                    <input type="hidden" name="user_id"
                                                                           value="{{ auth()->user()->id }}">
                                                                    <input type="hidden" name="parent_id"
                                                                           value="{{ $child->id }}">
                                                                    <label for="commentName"
                                                                           class="form-label fw-bold">{{ auth()->user()->name }}</label>
                                                                    <textarea class="form-control" id="commentText"
                                                                              name="content"
                                                                              rows="3"
                                                                              placeholder="Enter your reply"></textarea>
                                                                    <button type="submit" class="btn btn-primary my-2">
                                                                        Submit
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <!-- Form trả lời cho comment cha -->
                                    <div class="replyForm" style="display: none;">
                                        <form id="commentForm" action="{{ route('comment.store') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                            <input type="hidden" name="parent_id" value="{{ $content->id }}">
                                            <label for="commentName"
                                                   class="form-label  fw-bold">{{ auth()->user()->name }}</label>
                                            <textarea class="form-control" name="content" id="commentText" rows="3"
                                                      placeholder="Enter your reply"></textarea>
                                            <button type="submit" class="btn btn-primary my-2">Submit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Kiểm tra và hiển thị comment con -->
                    @endforeach

                @endif
            </div>
        </div>

        <div class="row d-flex">
            <div class="col-md-1">
                <img
                    src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSXPodEp1Zyixlyx1Rrq6JJlPm0hgg1pFeLNrxgt2bkYw&s"
                    alt="" style="width: 100px;height: 100px;">
            </div>
            <div class="col-md-11">
                <form id="commentForm" action="{{ route('comment.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    <input type="hidden" name="parent_id" value="0">

                    <label for="commentName"
                           class="form-label fw-bold">{{auth()->user()->name}}</label>
                    <textarea class="form-control" name="content" id="commentText1"
                              rows="3"
                              placeholder="Enter your comment"></textarea>
                    <button type="submit" class="btn btn-primary my-2">Submit</button>
                </form>
            </div>
        </div>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.replyBtn').click(function () {
                $(this).closest('.row').next('.replyForm').toggle();
            });

            $('form#commentForm').on('submit', function (e) {
                e.preventDefault();
                var formData = $(this).serialize();
                var parentId = $(this).find('input[name="parent_id"]').val();
                $.ajax({
                    type: "POST",
                    url: "{{ route('comment.store') }}",
                    data: formData,
                    success: function (response) {
                        if (response.success) {
                            var comment = response.comment;
                            var newCommentHtml = `
                        <div class="row d-flex">
                            <div class="col-md-1">
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSXPodEp1Zyixlyx1Rrq6JJlPm0hgg1pFeLNrxgt2bkYw&s" alt="" style="width: 100px;height: 100px;">
                            </div>
                            <div class="col-md-11">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="commentName" class="form-label fw-bold">{{ auth()->user()->name }}</label>
                                        <p>${comment.content}</p>
                                        <button type="submit" class="btn btn-outline-primary">reply</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        `
                            if (response.comment.parent_id == 0) {
                                $('#commentSection').append(newCommentHtml);
                                $('#commentText1').val('');
                            } else {
                                console.log($('#commentText').val());
                                $('#commentText').val('');
                                $('[data-parent-id="' + parentId + '"]').after(newCommentHtml);
                            }
                        } else {
                            alert('Failed to create comment');
                        }
                    },
                    error: function () {
                        alert('Failed to create comment');
                    }
                });
            });
        });
    </script>
@endsection
