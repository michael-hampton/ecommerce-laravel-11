@extends('layouts.app')
@section('content')
    <div class="container mt-4">
        <div class="row">
            @include('front.user.account-nav', ['current' => 'messages'])

            <div class="col-lg-9 my-lg-0 my-1">
                <div class="comment-section">
                    <!-- New Comment Form -->
                    <div class="mb-4">
                        @if($orderItem)
                            <h2>Report issue with order #{{$orderItem->id}} To {{$orderItem->seller->name}}</h2>
                        @endif
                        <form method="post" action="{{route('user.createQuestion')}}" enctype="multipart/form-data">
                            @csrf
                            @if($orderItemId)
                                <select class="form-control mb-4" name="title">
                                    <option value="">Select Issue Type</option>
                                    <option value="Item is damaged">Item is damaged</option>
                                </select>
                            @endif
                            <div class="d-flex gap-3">
                                <img src="https://randomuser.me/api/portraits/women/4.jpg" alt="User Avatar"
                                     class="user-avatar">
                                <div class="flex-grow-1">
                                            <textarea name="comment" class="form-control comment-input" rows="3"
                                                      placeholder="Write a comment..."></textarea>
                                    <input type="hidden" name="orderItemId" value="{{$orderItemId}}">
                                    <input type="file" class="form-control" name="images[]" multiple/>
                                    <div class="mt-3 text-end">
                                        <button type="submit" class="btn btn-primary text-white">Post Comment</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>

                    <!-- Comments List -->
                    <div class="comments-list">
                        @foreach($posts as $post)
                            <div class="comment-box">
                                <div class="d-flex gap-3">
                                    <img src="https://randomuser.me/api/portraits/men/34.jpg" alt="User Avatar"
                                         class="user-avatar">
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <a href="{{route('seller.details', ['id' => $post->seller_id])}}"><h6
                                                    class="mb-0">{{$post->user->name}}</h6></a>
                                            <span class="comment-time">{{$post->created_at->diffForHumans()}}</span>
                                        </div>
                                        <h4 class="text-muted">{{$post->title}}</h4>
                                        <p class="mb-2">{{$post->message}}</p>
                                        @if(!empty($post->images))
                                            <div class="d-flex justify-content-between">
                                                @foreach(explode(',', $post->images) as $image)
                                                    <img style="width: 100px"
                                                         src="{{asset('images/messages')}}/{{$image}}">
                                                @endforeach
                                            </div>
                                        @endif

                                        <div class="comment-actions">
                                            {{--                                <a href="#"><i class="bi bi-heart"></i> Like</a>--}}
                                            {{--                                <a href="#"><i class="bi bi-reply"></i> Reply</a>--}}
                                            <a href="{{route('user.askQuestionDetails', ['questionId' => $post->id])}}"><i
                                                    class="bi bi-share"></i> Read More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach


                    </div>
                </div>
            </div>
        </div>
@endsection





