@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title','Users List')
{{-- vendor styles --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
@endsection
{{-- page styles --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-users.css')}}">
@endsection
@section('content')
<style>
  td,tr{
    padding:0px!important;
  }
</style>

<!-- users list start -->
<section class="users-list-wrapper">
  <div class="users-list-table">
    <div class="card">
      <div class="card-content">
        <div class="card-body">

          <div class="text-right">
            <a class="btn btn-primary text-white" href="{{ route('check-in') }}"> <i class="fa fa-plus"></i> Check In</a><br><br>
          </div>

          @if(Session::has('message'))
            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
          @endif
          @if(Session::has('error'))
            <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('error') }}</p>
          @endif
          <!-- datatable start -->
          <div class="table-responsive">
            <table id="users-list-datatable" class="table">
              <thead>
                <tr>
                    <th>S.No.</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Customer</th>
                    {{-- <th>Project Type</th> --}}
                    {{-- <th>Color</th>
                    <th>Service</th> --}}
                    <th>Action</th>
                </tr>
              </thead>
              <tbody>
                  @foreach($inventorys as $key=>$user)
                    <tr>
                      <td>{{ ($key+1) }}</td>
                      <td>{{ $user->title }}</td>
                      <td style="text-align: justify;padding: 26px!important;">{{ $user->description }}</td>
                      <td>{{ $user->customer != "" ? $user->customer->first_name : "" }}</td>
                      {{-- <td>{{ $user->project != "" ? $user->project->title : ""  }}</td> --}}
                      {{-- <td>{{ $user->color != "" ? $user->color->title : "" }}</td>
                      <td>{{ $user->service != "" ? $user->service->title : ""}}</td> --}}
                      <td>
                          {{-- <a style="padding: 7px 11px;" onclick="return confirm('Are you sure, you want to check out it?')" href="{{ route('deleteinventory',$user->id) }}" class="text-white btn btn-danger">Check Out</a> --}}
                          <a class="text-white btn btn-primary" style="padding: 7px 11px;" href="{{ route('editinventory',$user->id) }}">Edit</a>
                          <a class="text-white btn btn-success" style="padding: 7px 11px;" href="{{ route('viewinventory',$user->id) }}">View</a>
                      </td>
                    </tr>
                  @endforeach
              </tbody>
            </table>
          </div>
          <!-- datatable ends -->
        </div>
      </div>
    </div>
  </div>
</section>
<!-- users list ends -->

<!--- user create modal --->

@endsection

{{-- vendor scripts --}}
@section('vendor-scripts')
<script src="{{asset('vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/dataTables.bootstrap4.min.js')}}"></script>
@endsection

{{-- page scripts --}}
@section('page-scripts')
<script src="{{asset('js/scripts/pages/page-users.js')}}"></script>
@endsection
