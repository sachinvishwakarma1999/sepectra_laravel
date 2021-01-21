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
          <a class="btn btn-primary text-white" href="{{ route('add-color') }}"> <i class="fa fa-plus"></i> Add Color</a><br><br>
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
                    <th>Hex Code</th>
                    <th>Action</th>
                </tr>
              </thead>
              <tbody>
                  @foreach($colors as $key=>$color)
                    <tr>
                      <td>{{ ($key+1) }}</td>
                      <td>{{ $color->title }}</td>
                      <td>{{ $color->description }}</td>
                      <td>{{ $color->code }} <span style="background-color: {{ $color->code }};width: 20px;height: 20px;border-radius: 20px;display: block;margin-right: 10px;float: left;"></span> </td>
                      <td>
                          <a  onclick="return confirm('Are you sure, you want to delete it?')" href="{{ route('deletecolor',$color->id) }}" class="text-danger"><i class="bx bx-trash"></i></a>
                          <a href="{{ route('editcolor',$color->id) }}"><i class="bx bx-edit-alt"></i></a>
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
