@if (count($teacherComments) > 0)
    @foreach ($teacherComments as $comment)
        <div class="col-md-12">
            <div class="card card_sec p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="user d-flex flex-row align-items-center"> 
                        <img src="https://i.imgur.com/hczKIze.jpg" width="30" class="user-img rounded-circle mr-2"> <span><small class="font-weight-bold text-primary">{{ $comment->name }}</small> <small class="font-weight-bold">{{$comment->comment}}</small></span> 
                    </div> 
                    <small>{{Helper::getRemainingHours($comment->created_at)}} ago</small>
                </div>
                <div class="action d-flex justify-content-between mt-2 align-items-center">
                    <div class="reply px-4"> <small>Remove</small> <span class="dots"></span>
                        <small>Reply</small> <span class="dots"></span> <small>Translate</small>
                    </div>
                    <div class="icons align-items-center"> <i class="fa fa-star text-warning"></i> <i class="fa fa-check-circle-o check-icon"></i> </div>
                </div>
            </div>
        </div>
    @endforeach
@else 
    <div class="col-md-12">
        <div class="card card_sec p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="user d-flex flex-row align-items-center"> 
                    <small class="font-weight-bold text-primary">There have no Comments</small>
                </div>
            </div>
        </div>
    </div>
@endif