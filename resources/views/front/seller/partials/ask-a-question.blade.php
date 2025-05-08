<form id="messageForm" action="{{route('user.createQuestion')}}" method="post">
    @csrf
    <input type="hidden" name="sellerId" value="{{$seller->id}}">

    <div class="mb-4 p-4 d-flex gap-3">
        <div class="me-3">
            <img style="width: 100px" src="{{ asset('images/users') }}/{{ auth()->user()->image }}" alt="User Avatar"
                class="user-avatar">
            
        </div>
        <div class="flex-grow-1 ">
            <div class="mb-3">
                <label>Title</label>
                <input type="text" name="title" class="form-control">
            </div>
            
            <div>
                <textarea name="comment" class="form-control comment-input" rows="3"
                    placeholder="Write a comment..."></textarea>
            </div>
        </div>

    </div>

    <div class="mb-3 p-4">
        <div class="mt-3 text-end">
            <button type="submit" class="btn btn-primary">Post Comment</button>
        </div>
    </div>
</form>