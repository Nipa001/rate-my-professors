@extends('layouts.default')

@section('content')
<div class="main">
    <!-- search bar start  -->
    <form id="top_search_bar" class="form-inline" action="{{route('universityList')}}" method="get">
        <div class="row form_D">
            <div class="col-md-6">
                <h3 class="title text-white col-md-12 text-center mb-4">Enter your varsity to get started
                </h3>
                <input class="text_field" type="text" name="search_text" id="search_text" placeholder="Enter Your Varsity Name:">
                <button class="btn btn-danger rounded-pill" type="button" onclick="document.getElementById('top_search_bar').submit()"><i class="fas fa-search"></i></button><br>
            </div>
        </div>
    </form>
    <!-- search bar end  -->
    <!-- card start  -->
    <div class="container">
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @if (count($all_posts) > 0)
                @foreach ($all_posts as $post)
                    <div class="col-md-4">
                        <div class="card bg-info h-100">
                            <img src="{{ asset('uploads/post/'.$post->image) }}" class="card-img-top" alt="{{$post->image}}">
                            <div class="card-body">
                                <h5 class="card-title">{{$post->title}}</h5>
                                <p class="card-text">{{$post->details}}</p>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted">Last updated 3 mins ago</small>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    <!-- card end  -->
</div>
@endsection

@push('javascript')
<script type="text/javascript">
    $(document).ready(function(){

    })
</script>
@endpush

