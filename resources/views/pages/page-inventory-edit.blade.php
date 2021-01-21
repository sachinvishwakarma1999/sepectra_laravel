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
                  <i class="bx bx-user mr-25"></i><span class="d-none d-sm-block">Detail</span>
              </a>
          </li>
        </ul>
        @if(Session::has('message'))
            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
        @endif
        <div class="tab-content">
          <div class="tab-pane active fade show" id="account" aria-labelledby="account-tab" role="tabpanel">
            <!-- users edit media object ends -->
            <!-- users edit account form start -->
            <form novalidate method="post" action="{{ route('updateinventory') }}">
                @csrf
                <input type="hidden" value="{{ $Inventory->id }}" name="id" />
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <div class="controls">
                                <label>Name</label>
                                <input name="title" type="text" class="form-control" placeholder="Name"
                                    value="{{ $Inventory->title }}" required
                                    data-validation-required-message="This title field is required">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="controls">
                                <label>Description</label>
                                <textarea style="height:200px;" name="description" class="form-control" placeholder="Name" required
                                    data-validation-required-message="This title field is required">{{ $Inventory->description }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!--- select customer --->
                    <div class="col-12 col-sm-6">
                      <div class="form-group">
                        <label>Select Customer</label>
                        <div class="row">
                          <div class="col-sm-8">
                            <select class="form-control" name="customer_id" required="" id="customer_dropdown">
                              @foreach ($customers as $customer)
                                <option <?php if($customer->id == $Inventory->customer_id) echo 'selected'; ?> value="{{ $customer->id }}">{{ $customer->first_name." ".$customer->last_name }}</option>
                              @endforeach
                            </select>
                          </div>
                          <div class="col-sm-4">
                            <a class="btn btn-primary form-control text-white"  data-toggle="modal" data-target="#customerCreateModal">Add New Customer</a>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!--- add project  --->
                    <input type="hidden" value="{{ count($Inventory->project) }}" id="counter" />

                    <div class="col-12 col-sm-12">
                      <div style="border-style: dashed;padding: 13px;" id="main_div">
                        @foreach ($Inventory->project as $keyproject=>$item)
                          <?php $keyproject1 = $keyproject+1; ?>
                          <div id="project_section_{{ $keyproject1 }}">
                            <div class="form-group">
                              <label>project</label>
                              <input type="text" name="project[]" value="{{ $item->name }}" class="form-control" placeholder="Enter project" required="">
                            </div>
                            <div class="form-group">
                              <label>Select Project Type</label>
                              <select class="form-control" name="project_type_id[]" required="">
                                @foreach ($projects as $project)
                                  <option <?php if($item->type == $project->id) echo 'selected'; ?> value="{{ $project->id }}">{{ $project->title }}</option>
                                @endforeach
                              </select>
                            </div>


                            <div class="form-group">
                              <label>Select Color</label>
                              <select class="form-control" name="color_id[]" required="">
                                @foreach ($colors as $color)
                                  <option <?php if($color->id == $item->color_id) echo 'selected'; ?> value="{{ $color->id }}">{{ $color->title }}</option>
                                @endforeach
                              </select>
                            </div>
                            <!--- select project type  --->
                            <div class="form-group">
                              <label>Select Service</label>
                              <select class="form-control" name="service_id[]" required="">
                                @foreach ($services as $service)
                                  <option <?php if($service->id == $item->service_id) echo 'selected'; ?> value="{{ $service->id }}">{{ $service->title }}</option>
                                @endforeach
                              </select>
                            </div>


                            <div style="border-style: dashed;margin-top: 25px;padding: 13px;" id="project_item_section_{{ $keyproject1 }}">
                              <input type="hidden" value="{{ count($item->items) }}" id="project_id_value_{{ $keyproject1 }}" />

                              @foreach ($item->items as $project_item_key=>$project_item)
                                <?php $keyprojectitems1 = $project_item_key + 1; ?>
                                <div id="project_{{ $keyproject1 }}_item_section_{{ $keyprojectitems1 }}">
                                  <div class="form-group">
                                    <label>Item</label>
                                    <input type="text" name="Item{{ $keyproject1 }}[]" value="{{ $project_item->name }}" class="form-control" placeholder="Item" required="">
                                  </div>
                                  <div class="form-group">
                                    <label>Item Description</label>
                                    <textarea type="text" name="Item_Description{{ $keyproject1 }}[]" class="form-control" placeholder="Item Description" required="">{{ $project_item->description }}</textarea>

                                    @if($keyprojectitems1 == 1)
                                    <a href="javascript:void(0);" project_id="{{ $keyproject1 }}" item_id ="{{ $keyprojectitems1 }}"   class="add_item_section_button" title="Add field"><img width="27px" style="margin-top: 20px;" src="https://img.icons8.com/ios/452/add--v1.png"/></a>
                                    @else
                                    <a href="javascript:void(0);" project_id="{{ $keyproject1 }}" item_id ="{{ $keyprojectitems1 }}"   class="remove_item_section_button" title="Add field"><img width="27px" style="margin-top: 20px;" src="https://cdn.iconscout.com/icon/premium/png-512-thumb/remove-434-1082788.png"/></a>
                                    @endif

                                  </div>
                                </div>
                              @endforeach

                            </div>

                            @if($keyproject1 == 1)
                            <a href="javascript:void(0);"  class="add_project_section" title="Add Project"><img width="27px" style="margin-top: 20px;" src="https://img.icons8.com/ios/452/add--v1.png"/></a>
                            @else
                            <a href="javascript:void(0);"  class="remove_project_section" title="Remove Project"><img width="27px" style="margin-top: 20px;" src="https://cdn.iconscout.com/icon/premium/png-512-thumb/remove-434-1082788.png"/></a>
                            @endif

                          </div>
                        @endforeach
                      </div>
                    </div>


                    <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                        <button type="submit" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Save
                            changes</button>
                        <button type="reset" class="btn btn-light">Cancel</button>
                    </div>
                </div>
            </form>
            <!-- users edit account form ends -->
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- users edit ends -->
<div class="modal" id="customerCreateModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Create Customer</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <form method="post" id="addcustomerform" action="{{ route('createemployeeajax') }}">
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
  $('#addcustomerform').submit(function(e){
      e.preventDefault();
      var form = $(this);
      $.ajax({
          url:'{{ route('createemployeeajax') }}',
          type:'POST',
          data:form.serialize(),
          success:function(msg){
              console.log(msg)
              $('#customerCreateModal').modal('hide');
              $('#customer_dropdown').append('<option selected value="'+msg.id+'">'+msg.first_name+' '+msg.last_name+'</option>');
          }
      });
      return false;
  });

$(document).ready(function(){

  $(document).on('click', '.add_project_section', function(e){
      let counter = $('#counter').val();
      counter++;
      $('#main_div').append('<div id="project_section_'+counter+'"><div class="form-group"><label>project</label><input type="text" name="project[]" class="form-control" placeholder="Enter project" required=""></div><div class="form-group"><label>Select Project Type</label><select class="form-control" name="project_type_id[]" required="">@foreach ($projects as $project)<option value="{{ $project->id }}">{{ $project->title }}</option>@endforeach</select></div><div class="form-group"><label>Select Color</label> <select class="form-control" name="color_id[]" required="">@foreach ($colors as $color)<option value="{{ $color->id }}">{{ $color->title }}</option>@endforeach</select></div><div class="form-group"><label>Select Service</label><select class="form-control" name="service_id[]" required="">@foreach ($services as $service)<option value="{{ $service->id }}">{{ $service->title }}</option>@endforeach</select></div><div style="border-style: dashed;margin-top: 25px;padding: 13px;" id="project_item_section_'+counter+'"><input type="hidden" value="1" id="project_id_value_'+counter+'" /><div id="project_'+counter+'_item_section_1 "><div class="form-group"><label>Item</label><input type="text" name="Item'+counter+'[]" class="form-control" placeholder="Item" required=""></div><div class="form-group"><label>Item Description</label><textarea type="text" name="Item_Description'+counter+'[]" class="form-control" placeholder="Item Description" required=""></textarea><a href="javascript:void(0);" project_id="'+counter+'" item_id ="1"   class="add_item_section_button" title="Add field"><img width="27px" style="margin-top: 20px;" src="https://img.icons8.com/ios/452/add--v1.png"/></a></div></div></div><a href="javascript:void(0);"  class="remove_project_section" title="Remove Project"><img width="27px" style="margin-top: 20px;" src="https://cdn.iconscout.com/icon/premium/png-512-thumb/remove-434-1082788.png"/></a></div>');

      $('#counter').val(counter);
  });

  $(document).on('click', '.remove_project_section', function(e){
    let counter = $('#counter').val();

    let id = "project_section_"+counter;
      $('#project_section_'+counter).remove();
      counter--;
      $('#counter').val(counter);
  });

  $(document).on('click', '.add_item_section_button', function(e){
      let project_id = $(this).attr('project_id');
      let id = "project_item_section_"+project_id;
      // let item_id = $(this).attr('item_id');
      let item_id = $('#project_id_value_'+project_id).val();
      item_id++;
      $('#project_item_section_'+project_id).append('<div id="project_'+project_id+'_item_section_'+item_id+'"><div class="form-group"><label>Item</label><input type="text" name="Item'+project_id+'[]" class="form-control" placeholder="Item" required=""></div><div class="form-group"><label>Item Description</label><textarea type="text" name="Item_Description'+project_id+'[]" class="form-control" placeholder="Item Description" required=""></textarea><a href="javascript:void(0);" project_id="'+project_id+'" item_id ="'+item_id+'"   class="remove_item_section_button" title="Add field"><img width="27px" style="margin-top: 20px;" src="https://cdn.iconscout.com/icon/premium/png-512-thumb/remove-434-1082788.png"/></a></div></div>');
      let project_id_value =  $('#project_id_value_'+project_id).val();
      project_id_value++;
      $('#project_id_value_'+project_id).val(project_id_value);
  });

  $(document).on('click', '.remove_item_section_button', function(e){
    let project_id = $(this).attr('project_id');
    let item_id = $('#project_id_value_'+project_id).val();

    let id = "project_"+project_id+"_item_section_"+item_id;
      $('#'+id).remove();

      let project_id_value =  $('#project_id_value_'+project_id).val();
      project_id_value--;
      $('#project_id_value_'+project_id).val(project_id_value);
  });


});

</script>

@endsection
