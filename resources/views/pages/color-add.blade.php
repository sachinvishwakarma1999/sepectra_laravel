@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title','Users Edit')
{{-- vendor styles --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/plugins/forms/validation/form-validation.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/forms/select/select2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/pickadate/pickadate.css')}}">
@endsection

{{-- page styles --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-users.css')}}">
@endsection

@section('content')
<!-- users edit start -->
<section class="users-edit">
  <div class="card">
    <div class="card-content">
      <div class="card-body">
        <ul class="nav nav-tabs mb-2" role="tablist">
          <li class="nav-item">
              <a class="nav-link d-flex align-items-center active" id="account-tab" data-toggle="tab"
                  href="#account" aria-controls="account" role="tab" aria-selected="true">
                  <i class="bx bx-plus mr-25"></i><span class="d-none d-sm-block">Add Color</span>
              </a>
          </li>
        </ul>
        @if(Session::has('message'))
            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
        @endif
        <div class="tab-content">
          <div class="tab-pane active fade show" id="account" aria-labelledby="account-tab" role="tabpanel">
            <form method="post" action="{{ route('storecolor') }}">
              @csrf
              <div class="form-group">
                <label>Name</label>
                <input type="text" name="title" class="form-control" placeholder="Enter Name" required="">
              </div>
              <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control" placeholder="Enter Description" required=""></textarea>
              </div>
              <div class="form-group">
                <div class="row">
                    <div class="col-sm-12">
                      <label>Code</label>
                    </div>
                    <div class="col-sm-9">
                      <input type="text" id="color_field" value="#ff0800" name="code" class="form-control" placeholder="Enter Code" required="" readonly/>
                    </div>
                    <div class="col-sm-3">
                      <input style="height: 100%;border-radius: 20px;" type="color" value="#ff0800" id="color">
                    </div>
                </div>


              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            <!-- users edit account form ends -->
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- users edit ends -->
@endsection

{{-- vendor scripts --}}
@section('vendor-scripts')
<script src="{{asset('vendors/js/forms/select/select2.full.min.js')}}"></script>
<script src="{{asset('vendors/js/forms/validation/jqBootstrapValidation.js')}}"></script>
<script src="{{asset('vendors/js/pickers/pickadate/picker.js')}}"></script>
<script src="{{asset('vendors/js/pickers/pickadate/picker.date.js')}}"></script>
@endsection

{{-- page scripts --}}
@section('page-scripts')
<script src="{{asset('js/scripts/pages/page-users.js')}}"></script>
<script src="{{asset('js/scripts/navs/navs.js')}}"></script>

<script>
  var backRGB = document.getElementById("color").value;
  document.getElementById("color").onchange = function() {
    backRGB = this.value;
    $('#color_field').val(backRGB);
    console.log(backRGB);
  }
</script>
@endsection
