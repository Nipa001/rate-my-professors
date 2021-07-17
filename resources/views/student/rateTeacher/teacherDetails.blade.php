@extends('layouts.default')

@push('styles')
<style>
    .card_sec {
        background-color: transparent;
        color: white;
        border: none;
        border-bottom: 1px solid black;
    }

    .dots {
        height: 4px;
        width: 4px;
        margin-bottom: 2px;
        background-color: white;
        border-radius: 50%;
        display: inline-block
    }

    .user-img {
        margin-top: 4px
    }

    .reply {
        margin-left: 12px
    }

    .reply small:hover {
        color: green;
        cursor: pointer
    }

    .rating {
        display: flex;
        background-color: transparent;
        box-shadow: none;
    }

    .rating li {
        list-style-type: none;
        padding: 5px;
        border: none;
    }

    .rating-item {
        /* border: 1px solid #fff; */
        cursor: pointer;
        font-size: 2em;
        color: yellow;
    }

    .rating-item::before {
        content: "\2605";
    }

    .rating-item.active~.rating-item::before {
        content: "\2606";
    }
</style>
@endpush

@section('content')
<div class="container mt-5" style="background-color: #80bbea; border-radius: 15px 15px 0px 0px; ">
    <div class="row">
        <div class="col-md-4 text-white">

            <ul class="rating">
                <li>
                    <h1 class="bg-danger badge-pill rounded text-center" style="height: 50px; width: 80px;"
                        id="point">@if (!empty($professorRating->rating))
                            {{@$professorRating->rating}}
                        @else
                            0
                        @endif</h1>
                </li>
                <li class="rating-item @if (@$professorRating->rating == 1) active @endif" data-rate="1"> </li>
                <li class="rating-item @if (@$professorRating->rating == 2) active @endif" data-rate="2"> </li>
                <li class="rating-item @if (@$professorRating->rating == 3) active @endif" data-rate="3"> </li>
                <li class="rating-item @if (@$professorRating->rating == 4) active @endif" data-rate="4"> </li>
                <li class="rating-item @if (@$professorRating->rating == 5) active @endif" data-rate="5"> </li>
            </ul>
        </div>
        <div class="col-md-8">
            <div class="text-center mt-5">
                <h1 class="text-white"><i class="fas fa-user-tie"> RATE YOUR PROFESSOR</i></h1>
            </div>
        </div>
    </div>
</div>
<div class="container" style="background-color: #80bbea;">
    <form action="" id="teacherRateComment">
        <div id="errorMsgDiv">
            <div id="newsletterMsg"></div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="comment"><strong>Coments</strong></label>
                    <input type="hidden" id="teacher_id" value="{{$teacher_id}}">
                    <textarea name="comment" class="form-control mb-5" id="comment" rows="3"></textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <button class="btn btn-success" type="submit" id="submitBtn">Submit</button>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="container mt-5" style="background-color: #80bbea; border-radius: 0px 0px 15px 15px; ">
    <div class="row">
        <div class="container mt-3">
            <div class="row d-flex justify-content-center" id="comment_portion">
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
                                <div class="action d-flex justify-content-between mt-2 align-items-center data-list">
                                    <div class="reply px-4">
                                        @if (Auth::id() == $comment->created_by)
                                        <input type="hidden" id="deleteComment" value="{{route('removeComment', [$comment->id])}}">
                                        <small id="removeCommentForm">Remove</small>
                  
                                        @endif
                                        <span class="dots"></span>
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
            </div>
        </div>
    </div>
</div>
@endsection

@push('javascript')
<script type="text/javascript">
    var teacher_id = $('#teacher_id').val();
    const container = document.querySelector('.rating')
    const items = container.querySelectorAll('.rating-item')
    container.onclick = e => {
        const elClass = e.target.classList;
        if (!elClass.contains('active')) {
            items.forEach(
                item => item.classList.remove('active')
            )
            // console.log(e.target.getAttribute("data-rate"))
            elClass.add('active')
        }
        let a = e.target.getAttribute("data-rate")
        console.log("a is ", a)
        document.getElementById('point').innerText = a
        let rating = a;
        $.ajax({
            url : "{{route('teacherRatingAction')}}",
            type: "POST",
            data: {"_token":"{{ csrf_token() }}", 'rating': rating, 'teacher_id':teacher_id},
            dataType: 'json',
            success:function(data){
                var status = parseInt(data.status);
                if(data.status ==1) {
                    $('#newsletterMsg').html('<div class="alert alert-success alert-dismissible fade show"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> <i class="fa fa-adjust alert-icon"></i> '+data.messege+'</div>');
                    $('#comment').val("");
                    LoadPageContent();
                } else if(status==0) {
                    $('#newsletterMsg').html('<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> <i class="fa fa-adjust alert-icon"></i> '+data.messege+'</div>');
                    $('#newsletterMsg').on('click', '#close_icon', function() {
                        $("#submitBtn").removeAttr("disabled").removeClass("disabled");
                        $("#submitBtn").val("Submit");
                        $selector.closest('form').find("textarea").val("");
                    })
                }
            }
        });
    }
    $(document).ready(function(){
        $('#teacherRateComment').on("submit", function(e) {
            e.preventDefault();
            let comment = $('#comment').val();
            $.ajax({
              url : "{{route('teacherCommentAction')}}",
              type: "POST",
              data: {"_token":"{{ csrf_token() }}", 'comment': comment, 'teacher_id':teacher_id},
              dataType: 'json',
              success:function(data){
                var status = parseInt(data.status);
                if(data.status ==1) {
                    $('#newsletterMsg').html('<div class="alert alert-success alert-dismissible fade show"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> <i class="fa fa-adjust alert-icon"></i> '+data.messege+'</div>');
				    $('#comment').val("");
                    LoadPageContent();
                } else if(status==0) {
                    $('#newsletterMsg').html('<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> <i class="fa fa-adjust alert-icon"></i> '+data.messege+'</div>');
                    $('#newsletterMsg').on('click', '#close_icon', function() {
                        $("#submitBtn").removeAttr("disabled").removeClass("disabled");
                        $("#submitBtn").val("Submit");
                        $selector.closest('form').find("textarea").val("");
                    })
                }
              }
            });
        });

        $('#removeCommentForm').on('click', function(e) {
            e.preventDefault();
            let deleteLinkUrl = $('#deleteComment').val();
            let dataType = "html";
            alert('Click Ok');
            $.ajax({
                url : deleteLinkUrl,
                type: "POST",
                data: {"_token": "{{ csrf_token() }}", '_method':'DELETE'}, 
                dataType: dataType,
                success:function(data){
                    var dataError = (dataType=="html") ? data.trim() : data.error;
                    if((typeof dataError!==typeof undefined) && (dataError)) {

                    } else {
                        LoadPageContent();
                    }
                }
            });
        })
    })

    function LoadPageContent() {
        $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: "{{route('teacherComments')}}",
            type: "GET",
            data: {teacher_id:teacher_id},
            dataType: "html",
            success: function (data) {
                if (parseInt(data) === 0) {
                    //location.replace('');
                } else {
                    $('#comment_portion').html(data);
                }
            }
        });
    }
</script>
@endpush

