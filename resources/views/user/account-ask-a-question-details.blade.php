@extends('layouts.app')
@section('content')
    <style>
        .comment-section {
            max-width: 800px;
            margin: 2rem auto;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 15px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        }

        .comment-box {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            transition: transform 0.2s;
            border: 1px solid #e9ecef;
        }

        .comment-box:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        .comment-input {
            border-radius: 20px;
            padding: 15px 20px;
            border: 2px solid #e9ecef;
            transition: all 0.3s;
        }

        .comment-input:focus {
            box-shadow: none;
            border-color: #86b7fe;
        }

        .btn-comment {
            border-radius: 20px;
            padding: 8px 25px;
            background: #0d6efd;
            border: none;
            transition: all 0.3s;
        }

        .btn-comment:hover {
            background: #0b5ed7;
            transform: translateY(-1px);
        }

        .comment-actions {
            font-size: 0.9rem;
        }

        .comment-actions a {
            color: #6c757d;
            text-decoration: none;
            margin-right: 15px;
            transition: color 0.2s;
        }

        .comment-actions a:hover {
            color: #0d6efd;
        }

        .comment-time {
            color: #adb5bd;
            font-size: 0.85rem;
        }

        .reply-section {
            margin-left: 60px;
            border-left: 2px solid #e9ecef;
            padding-left: 20px;
        }
    </style>

    <section class="my-account container">
        <h2 class="page-title">Ask a Question</h2>
        <div class="row">
            <div class="col-lg-2">
                @include('user.account-nav')
            </div>
            <div class="col-lg-9">
                <div class="container">
                    <div class="comment-section">
                        <!-- New Comment Form -->
                        <form method="post" action="{{route('user.postReply')}}">
                            @csrf
                            <input type="hidden" name="postId" value="{{$post->id}}">
                            <div class="mb-4">
                                <div class="d-flex gap-3">
                                    <img src="https://randomuser.me/api/portraits/women/4.jpg" alt="User Avatar" class="user-avatar">
                                    <div class="flex-grow-1">
                                        <textarea name="message" class="form-control comment-input" rows="3" placeholder="Write a comment..."></textarea>
                                        <div class="mt-4 text-end">
                                            <button type="submit" class="btn btn-comment text-white">Post Reply</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- Comments List -->
                        <div class="comments-list">
                            <!-- Comment 1 -->
                            <div class="comment-box">
                                <div class="d-flex gap-3">
                                    <img src="https://randomuser.me/api/portraits/men/34.jpg" alt="User Avatar" class="user-avatar">
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="mb-0">{{$post->user->name}}</h6>
                                            <span class="comment-time">{{$post->created_at->diffForHumans()}}</span>
                                        </div>
                                        <p class="mb-2">{{$post->message}}</p>
                                        {{--                            <div class="comment-actions">--}}
                                        {{--                                <a href="#"><i class="bi bi-heart"></i> Like</a>--}}
                                        {{--                                <a href="#"><i class="bi bi-reply"></i> Reply</a>--}}
                                        {{--                                <a href="#"><i class="bi bi-share"></i> Share</a>--}}
                                        {{--                            </div>--}}
                                    </div>
                                </div>

                                <!-- Reply Section -->
                                <div class="reply-section mt-3">
                                    @foreach($post->comments as $comment)
                                        <div class="comment-box">
                                            <div class="d-flex gap-3">
                                                <img src="https://randomuser.me/api/portraits/women/64.jpg" alt="User Avatar" class="user-avatar">
                                                <div class="flex-grow-1">
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <h6 class="mb-0">{{$comment->user->name}}</h6>
                                                        <span class="comment-time">{{$comment->created_at->diffForHumans()}}</span>
                                                    </div>
                                                    <p class="mb-2">{{$comment->message}}
                                                    </p>
                                                    {{--                                                <div class="comment-actions">--}}
                                                    {{--                                                    <a href="#"><i class="bi bi-heart"></i> Like</a>--}}
                                                    {{--                                                    <a href="#"><i class="bi bi-reply"></i> Reply</a>--}}
                                                    {{--                                                </div>--}}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
