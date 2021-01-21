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
<!-- users list start -->
<section class="users-list-wrapper">
  <div class="users-list-table">
    <div class="card">
      <div class="card-content">
        <div class="card-body">

          <div class="text-right">
          <a class="btn btn-primary text-white" href="{{ route('add-project') }}"> <i class="fa fa-plus"></i> Add Project</a><br><br>
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
                    <th>Name</th>
                    <th>Description</th>
                    <th>Type</th>
                    <th>Action</th>
                </tr>
              </thead>
              <tbody>
                  @foreach($projects as $key=>$project)
                    <tr>
                      <td>{{ ($key+1) }}</td>
                      <td>{{ $project->title }}</td>
                      <td>{{ $project->description }}</td>
                      <td>{{ $project->type }}</td>
                      <td>
                          <a  onclick="return confirm('Are you sure, you want to delete it?')" href="{{ route('deleteproject',$project->id) }}" class="text-danger"><i class="bx bx-trash"></i></a>
                          <a href="{{ route('editproject',$project->id) }}"><i class="bx bx-edit-alt"></i></a>
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
