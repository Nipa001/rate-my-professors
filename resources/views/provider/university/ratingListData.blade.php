@extends('provider.layouts.default')

@section('content')
<!-- Page header -->
<div class="page-header">

    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="{{route('provider.home')}}"><i class="icon-home2 position-left"></i> Home</a></li>
            <li><a href="{{route('provider.teacherRatingList')}}">Rating</a></li>
            <li class="active">List Data</li>
        </ul>
    </div>
</div>
<!-- /page header -->


<!-- Content area -->
<div class="content">

    <!-- Highlighting rows and columns -->
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">Rating List</h5>
            <div class="heading-elements">
                <ul class="icons-list" style="margin-top: 0px">
                    <li><a data-action="collapse"></a></li>
                    <li><a data-action="reload"></a></li>
                    <li><a data-action="close"></a></li>
                </ul>
            </div>
        </div>

        <table class="table table-bordered table-hover datatable-highlight data-list" id="ratingTable">
            <thead>
                <tr>
                    <th width="5%">SL.</th>
                    <th width="35%">Teacher Name</th>
                    <th width="20%">Student Name</th>
                    <th width="15%">Rating</th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($all_ratings))
                    @foreach ($all_ratings as $key => $varsity)
                    <tr>
                        <td>{{++$key}}</td>
                        <td>{{$varsity->teacher_name}}</td>
                        <td>{{$varsity->student_name}}</td>
                        <td>{{$varsity->rating}}</td>
                    </tr> 
                    @endforeach
                @else
                    <tr>
                        <td colspan="6">No Data Found!</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    <!-- /highlighting rows and columns -->

</div>
<!-- /content area -->
@endsection

@push('javascript')
<script type="text/javascript">
    $('#ratingTable').DataTable({
        dom: 'lBfrtip',
            "iDisplayLength": 10,
            "lengthMenu": [ 10, 25,30, 50 ],
            columnDefs: [
                {'orderable':false, "targets": 1 },
            ]
    });
</script>
@endpush
