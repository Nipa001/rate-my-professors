@extends('layouts.default')

@section('content')
<div class="mid">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-4 area01 area">
                <a href="{{ route('provider.login') }}"><button class="btn-lg text-white" type="submit">Admin</button></a>
            </div>
            <div class="col-sm-4 area02">
                <a href="{{ route('teacher.login') }}"><button class="btn-lg text-white" type="submit">Faculty</button></a>
            </div>
            <div class="col-sm-4 area03">
                <a href="{{ route('login') }}"><button class="btn-lg text-white" type="submit">Students</button></a>
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

