@extends('layouts.default')

@section('content')
<div class="container-fluid">
    <div class="varsity">
        <div class="row p-5">
            <div class="col-md-12">
                <div class="var_det text-white">
                    <h1 class="title text-success">
                        {{$university_info->varsity_name}}</h1>
                    <h2 class="website border-bottom"><a href="https://daffodilvarsity.edu.bd/"
                            target="__blank">webiste <sup><i class="fas fa-braille"></i></sup></a></h2>
                    <a href="rating.html"><button class="btn btn-primary rate_btn mt-3" type="button"><i
                                class="fas fa-star-half-alt"> Rate
                                This
                                Campus</i></button></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col right-brackdown">
                <div class="Professors">
                    <div class="row">
                        <div class="col-md-6 text-white">
                            <h2 class="tp_h2_left text-warning">Top Professors</h2>
                            <a href="#" class="btn btn-primary vap_a_right">VIEW ALL
                                PROFESSORS</a>
                        </div>
                        <div class="Professorslist mt-5">
                            <ul>
                                @if (count($varsities_professors) > 0)
                                    @foreach($varsities_professors as $key => $professor)
                                    <li class="border-0 text-white Tpro_name"><a class="btn btn-info" href="{{route('rateTeacher', ['teacher_id'=>$professor->id])}}">{{$professor->name}}</a> <p class="rateR">{{$professor->rating}}</p>
                                    </li>
                                    @endforeach
                                @else
                                    <li>No Teacher Found!</li>
                                @endif
                            </ul>
                        </div>
                        <div class="col-md-6">

                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <h1 class="text-warning var_stack_up">How This Varsity Stacks Up</h1>
                <p class="rate_oqr text-white"> 4.7
                <h4 class="text-white oqr_S">
                    OVERALL QUALITY RATING

                </h4>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('javascript')
<script type="text/javascript">
    $(document).ready(function(){

    })
</script>
@endpush

