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
{{-- <div class="users-list-filter px-1">
<form>
<div class="row border rounded py-2 mb-2">
<div class="col-12 col-sm-6 col-lg-3">
<label for="users-list-verified">Verified</label>
<fieldset class="form-group">
<select class="form-control" id="users-list-verified">
<option value="">Any</option>
<option value="Yes">Yes</option>
<option value="No">No</option>
</select>
</fieldset>
</div>
<div class="col-12 col-sm-6 col-lg-3">
<label for="users-list-role">Role</label>
<fieldset class="form-group">
<select class="form-control" id="users-list-role">
<option value="">Any</option>
<option value="User">User</option>
<option value="Staff">Staff</option>
</select>
</fieldset>
</div>
<div class="col-12 col-sm-6 col-lg-3">
<label for="users-list-status">Status</label>
<fieldset class="form-group">
<select class="form-control" id="users-list-status">
<option value="">Any</option>
<option value="Active">Active</option>
<option value="Close">Close</option>
<option value="Banned">Banned</option>
</select>
</fieldset>
</div>
<div class="col-12 col-sm-6 col-lg-3 d-flex align-items-center">
<button type="reset" class="btn btn-primary btn-block glow users-list-clear mb-0">Clear</button>
</div>
</div>
</form>
</div> --}}
<div class="users-list-table">
<div class="card">
<div class="card-content">
<div class="card-body">

<div class="text-right">
<a class="btn btn-primary text-white" data-toggle="modal" data-target="#userCreateModal"> <i class="fa fa-plus"></i> Create Customer</a><br><br>
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
<th>first name</th>
<th>last name</th>
<th>email</th>
<th>phone</th>
<th>company name</th>
<th>address</th>
<th>edit</th>
</tr>
</thead>
<tbody><?php
// print_r($customers->QueryResponse->Customer);
// die;
?>
@foreach($customers->QueryResponse->Customer as $key=>$customerr)
<tr>
<td>{{ ($key+1) }}</td>
<td>{{ $customerr->DisplayName }}</td>
<td><?php if(!empty($customerr->MiddleName))
{
echo $customerr->MiddleName;
}
?></td>
<td>

<?php if(!empty($customerr->PrimaryEmailAddr))
{
foreach($customerr->PrimaryEmailAddr as $email)
{
echo $email;
}

}
?>
</td>
<td>
<?php if(!empty($customerr->PrimaryPhone))
{
foreach($customerr->PrimaryPhone as $mobile)
{
echo $mobile;
}

}
?></td>
<td><?php if(!empty($customerr->CompanyName))
{
echo $customerr->CompanyName;
}
?> </td>
<td>
<?php if(!empty($customerr->BillAddr))
{
foreach($customerr->BillAddr as $adderss)
{
echo $adderss;
}

}
?>
</td>
<td>
@if(Auth::check() && Auth::user()->role == 'admin')
<a onclick="return confirm('Are you sure, you want to delete it?')" href="{{ route('deletecustomer',$customerr->Id) }}" class="text-danger"><i class="bx bx-trash"></i></a>
<a data-toggle="modal" data-target="#userupdateModal{{$customerr->Id}}" href="#"><i class="bx bx-edit-alt"></i></a>
@endif </td>


<!--- user create modal --->
<div class="modal" id="userupdateModal{{$customerr->Id}}">
  <div class="modal-dialog">
  <div class="modal-content">
  <!-- Modal Header -->
  <div class="modal-header">
  <h4 class="modal-title">Update Customer</h4>
  <button type="button" class="close" data-dismiss="modal">&times;</button>
  </div>
  <!-- Modal body -->
  <div class="modal-body">
  <form method="post" action="{{ route('updatecustomer') }}">
  @csrf
  <div class="form-group">
    <input type="hidden" name="id" value="{{$customerr->Id}}">
  <label>First Name</label>
  <input type="text" name="first_name" class="form-control" value="{{ $customerr->DisplayName }}" required>
  </div>
  <div class="form-group">
  <label>Last Name</label>
  <input type="text" name="last_name" class="form-control" value="<?php if(!empty($customerr->MiddleName))
  {
  echo $customerr->MiddleName;
  }
  ?>" required>
  </div>
  <div class="form-group">
  <label>Email address</label>
  <input type="email" name="email" class="form-control" placeholder="Enter email" required value="<?php if(!empty($customerr->PrimaryEmailAddr))
  {
  foreach($customerr->PrimaryEmailAddr as $email)
  {
  echo $email;
  }

  }
  ?>">
  </div>
  <div class="form-group">
  <label>Phone</label>
  <input type="text" name="phone" class="form-control" value="<?php if(!empty($customerr->PrimaryPhone))
  {
  foreach($customerr->PrimaryPhone as $mobile)
  {
  echo $mobile;
  }

  }
  ?>" required="">
  </div>
  <div class="form-group">
  <label>Company Name</label>
  <input type="text" name="company_name" class="form-control" value="<?php if(!empty($customerr->CompanyName))
  {
  echo $customerr->CompanyName;
  }
  ?>" required="">
  </div>
  <div class="form-group">
  <label>Address</label>
  <textarea name="address" class="form-control" placeholder="Enter Address" value="<?php if(!empty($customerr->BillAddr))
    {
    foreach($customerr->BillAddr as $adderss)
    {
    echo $adderss;
    }

    }
    ?>"><?php if(!empty($customerr->BillAddr))
{
foreach($customerr->BillAddr as $adderss)
{
echo $adderss;
}

}
?></textarea>
  </div>
  <button type="submit" class="btn btn-primary">Update</button>
  </form>
  </div>
  <!-- Modal footer -->
  <div class="modal-footer">
  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
  </div>
  </div>
  </div>
  </div>

{{--






<td>
@if(Auth::check() && Auth::user()->role == 'admin')
<a onclick="return confirm('Are you sure, you want to delete it?')" href="{{ route('deletecustomer',$customerr->Id) }}" class="text-danger"><i class="bx bx-trash"></i></a>
<a href="{{ route('editcustomer',$customerr->Id) }}"><i class="bx bx-edit-alt"></i></a>
@endif
edit
</td> --}}
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
<div class="modal" id="userCreateModal">
<div class="modal-dialog">
<div class="modal-content">
<!-- Modal Header -->
<div class="modal-header">
<h4 class="modal-title">Create Customer</h4>
<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<!-- Modal body -->
<div class="modal-body">
<form method="post" action="{{ route('createemployee') }}">
@csrf
<div class="form-group">
<label>First Name</label>
<input type="text" name="first_name" class="form-control" placeholder="Enter first name" required="">
</div>
<div class="form-group">
<label>Last Name</label>
<input type="text" name="last_name" class="form-control" placeholder="Enter last name" required="">
</div>
<div class="form-group">
<label>Email address</label>
<input type="email" name="email" class="form-control" placeholder="Enter email" required="">
</div>
<div class="form-group">
<label>Phone</label>
<input type="text" name="phone" class="form-control" placeholder="Enter phone" required="">
</div>
<div class="form-group">
<label>Company Name</label>
<input type="text" name="company_name" class="form-control" placeholder="Enter company name" required="">
</div>
<div class="form-group">
<label>Address</label>
<textarea name="address" class="form-control" placeholder="Enter Address"></textarea>
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
</div>


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
