@extends('layouts.default')

@section('content')
<div class="container text-white">
    @if (count($universities) > 0)
        @foreach ($universities as $varsity)
        <a href="{{route('varsityProfessorList', [$varsity->id])}}">
            <div class="row p-sm-3 m-5 shadow  bg-light rounded justify-content-around sizing">
                <div class="col-6">
                    <h4>Quality</h4>
                    <div class="div d-flex ">
                        <div>
                            <h4 class="rating p-3">4.6</h4>
                            <h6>17 ratings</h6>
                        </div>
                        <div class="mx-4 pt-2 text-center">
                            <h3 class="fw-bold">
                                {{$varsity->varsity_name}}
                            </h3>
                        </div>
    
                    </div>
                </div>
                <div class="col-4 m">
                    <h6>{{$varsity->address}}</h6>
                </div>
            </div>
        </a>
        @endforeach
    @else
        
    @endif

</div>
@endsection

@push('javascript')
<script type="text/javascript">
    $(document).ready(function(){

    })
</script>
@endpush

