
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

<div class="users-list-filter px-1">
    <form method="post" action="{{ route('createinventory') }}">

      <div class="row border rounded py-2 mb-2">

        <div class="col-12 col-sm-6 col-lg-3">
          <label>Project</label>
            <fieldset class="form-group">
              <select class="form-control" id='sel_project' name='sel_project'>
                  <option value='0'>-- Select Project  --</option>

                      @foreach ($allprojects as $allproject)
                          <option value="{{ $allproject->id }}">{{ $allproject->name }}</option>
                      @endforeach
              </select>
            </fieldset>
          </div>

        <div class="col-12 col-sm-6 col-lg-3">
          <label>Item</label>
          <fieldset class="form-group">
                 <select class="form-control" id='sel_item' name='sel_item'>
                   <option value='0'>-- Select Item --</option>
                 </select>
          </fieldset>
        </div>

        <div class="col-12 col-sm-6 col-lg-2">
            <label>$ Price</label>
            <fieldset class="form-group">
            <input type="number" name="" class="form-control" placeholder="Enter" required="">
            </fieldset>
        </div>

        <div class="col-12 col-sm-6 col-lg-2">
          <label># Total Linear FT</label>
          <fieldset class="form-group">
          <input type="number" name="" class="form-control" placeholder="Enter" required="">
          </fieldset>
        </div>

        <div class="col-12 col-sm-6 col-lg-2 d-flex align-items-center">
          <button type="reset" class="btn btn-primary btn-block glow users-list-clear mb-0">Check Out</button>
        </div>
      </div>
    </form>
  </div>

  {{-- <div class="card">
    <div class="card-content">
      <div class="card-body">



      </div>
    </div>
  </div> --}}

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
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script type='text/javascript'>

$(document).ready(function(){

  // on Project  Change
  $('#sel_project').change(function(){

     // project id

     var id = $(this).val();


     // Empty the dropdown
     $('#sel_item').find('option').not(':first').remove();

     // AJAX request
     $.ajax({
       url: 'getitemsproject/'+id,
       type: 'get',
       dataType: 'json',

       success: function(response){


          var len = 0;
          if(response != null){
            len = response.length;
          }



         if(len >= 0){
           //Read data and create <option>
           for(var i=0; i<=len; i++){

             var id = response[i].id;
             var title = response[i].name;

             var option = "<option value='"+id+"'>"+title+"</option>";

             $("#sel_item").append(option);
           }
         }

       }
    });
  });

});

</script>
