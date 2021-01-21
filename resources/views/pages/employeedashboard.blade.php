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

@if(Session::has('message'))
  <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
@endif
@if(Session::has('error'))
  <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('error') }}</p>
@endif

<div class="row">
  <div class="col-xl-4 col-md-6 col-12 dashboard-greetings">
    <a href="{{ route('check-in') }}">
      <div class="card">
        <div class="card-header">
        </div>
        <div class="card-content">
          <div class="card-body" style="text-align:center;">
            <h3 class="greeting-text">Check In</h3>
          </div>
        </div>
      </div>
    </a>
  </div>
  <div class="col-xl-4 col-md-6 col-12 dashboard-greetings">
  <a data-toggle="modal" data-target="#exampleModal" href="{{ route('check-out') }}">
      <div class="card">
        <div class="card-header">
        </div>
        <div class="card-content">
          <div class="card-body" style="text-align:center;">
            <h3 class="greeting-text">Check Out</h3>
          </div>
        </div>
      </div>
    </a>
  </div>
  <div class="col-xl-4 col-md-6 col-12 dashboard-greetings">
    <a href="{{ route('inventory-list') }}">
      <div class="card">
        <div class="card-header">
        </div>
        <div class="card-content">
          <div class="card-body" style="text-align:center;">
            <h3 class="greeting-text">Dashboard</h3>
          </div>
        </div>
      </div>
    </a>
  </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Check Out</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="users-list-filter px-1">
           @if(session('message'))
              {{session('message')}}
            @endif
              <form method="post" action="{{ route('storecheckout') }}" enctype="multipart/form-data">
                @csrf
                <div class="row border rounded py-2 mb-2">

                  <div class="col-12 col-sm-12 col-lg-12">
                    <label>Customer</label>
                      <fieldset class="form-group">
                        <select class="form-control" id='sel_project' name="customer_id">
                            <option value='0'>-- Select Customer  --</option>
                              @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->first_name." ".$customer->last_name }}</option>
                              @endforeach
                        </select>
                      </fieldset>
                    </div>

                  <div class="col-12 col-sm-12 col-lg-12">
                    <label>Item</label>
                    <fieldset class="form-group">
                          <select class="form-control" id='sel_item' name="item_id">
                            @foreach($projectitems as $projectitem)
                          <option value="{{$projectitem->id}}">{{$projectitem->name}}</option>
                            @endforeach
                          </select>
                    </fieldset>
                  </div>

                  <div class="col-12 col-sm-12 col-lg-12">
                    <label>Photo</label>

                        <div class="file-field">
                          <div class="btn btn-primary btn-sm float-left">
                            <span>Choose Photo</span>
                            <input type="file"  name="check_out_image" >
                          </div>

                        </div>

                   </div>

                  <div class="col-12 col-sm-12 col-lg-12 mt-2">
                    <select class="form-control" id='' name="invoice_id">
                      @foreach($invoicenames as $invoicename)
                    <option value="{{$invoicename->id}}">{{$invoicename->name}}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="col-12 col-sm-12 col-lg-12 mt-2">
                    <label>Notes</label>
                    <fieldset class="form-group">
                    <textarea type="text" name="notes" class="form-control" placeholder="Enter notes" ></textarea>
                    </fieldset>
                 </div>

                  <div class="col-12 col-sm-12 col-lg-12">
                    <label>Signature Photo</label>
                        <div class="file-field">
                          <div class="btn btn-primary btn-sm float-left">
                            <span>Choose Photo</span>
                            <input type="file" name="check_out_signature" >
                          </div>
                        </div>
                   </div>






                  <div class="col-12 col-sm-12 col-lg-12 d-flex align-items-center mt-2">
                    <button type="submit" class="btn btn-primary">Check Out</button>
                  </div>
                </div>
              </form>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
      </div>
    </div>
  </div>
</div>
<!-- users list start -->
{{-- <section class="users-list-wrapper">
  <div class="users-list-table">
    <div class="card">
      <div class="card-content">
        <div class="card-body">

          <div class="text-right">
            <a class="btn btn-primary text-white" data-toggle="modal" data-target="#userCreateModal"> <i class="fa fa-plus"></i> Check In</a><br><br>
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
                    <th>Type</th>
                    <th>Weight</th>
                    <th>Unit</th>
                    <th>Action</th>
                </tr>
              </thead>
              <tbody>
                  @foreach($inventorys as $key=>$user)
                    <tr>
                      <td>{{ ($key+1) }}</td>
                      <td>{{ $user->title }}</td>
                      <td>{{ $user->description }}</td>
                      <td>{{ $user->type }}</td>
                      <td>{{ $user->weight }}</td>
                      <td>{{ $user->weight_unit }}</td>
                      <td>
                          <a style="padding: 7px 11px;" onclick="return confirm('Are you sure, you want to check out it?')" href="{{ route('deleteinventory',$user->id) }}" class="text-white btn btn-danger">Check Out</a>
                          <a class="text-white btn btn-primary" style="padding: 7px 11px;" href="{{ route('editinventory',$user->id) }}">Edit</a>
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
</section> --}}
<!-- users list ends -->

<!--- user create modal --->
{{-- <div class="modal" id="userCreateModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Create Inventory</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <form method="post" action="{{ route('createinventory') }}">
          @csrf
          <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" class="form-control" placeholder="Enter title" required="">
          </div>
          <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control" placeholder="Enter Description" required=""></textarea>
          </div>
          <div class="form-group">
            <label>Type</label>
            <select class="form-control" name="type" required="">
              <option value="Hardest Aluminum: 2024-T351">Hardest Aluminum: 2024-T351</option>
              <option value="Most Flexible Aluminum">Most Flexible Aluminum</option>
              <option value="Sheet Aluminum">Sheet Aluminum</option>
              <option value="Clad Aluminum">Clad Aluminum</option>
              <option value="Bare Aluminum">Bare Aluminum</option>
              <option value="Aluminum Manufacturing Alloys">Aluminum Manufacturing Alloys</option>
            </select>
          </div>
          <div class="form-group">
            <label>Weight</label>
            <input type="number" name="weight" class="form-control" placeholder="Enter weight" required="">
          </div>
          <div class="form-group">
            <label>Select Unit</label>
            <select class="form-control" name="weight_unit" required="">
              <option value="gigatonne">gigatonne</option>
              <option value="megatonne">megatonne</option>
              <option value="tonne">tonne</option>
              <option value="kg">kg</option>
              <option value="g">g</option>
              <option value="mg">mg</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div> --}}
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
<script>


  </script>
