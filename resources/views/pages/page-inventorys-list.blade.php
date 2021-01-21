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
            <a class="btn btn-primary text-white" data-toggle="modal" data-target="#userCreateModal"> <i class="fa fa-plus"></i> Create Inventory</a><br><br>
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
                      <td>{{ $user->description }}</td>
                      <td>{{ $user->customer != "" ? $user->customer->first_name : "" }}</td>
                      {{-- <td>{{ $user->project != "" ? $user->project->title : ""  }}</td> --}}
                      {{-- <td>{{ $user->color != "" ? $user->color->title : "" }}</td>
                      <td>{{ $user->service != "" ? $user->service->title : ""}}</td> --}}
                      <td>
                          <a title="delete" onclick="return confirm('Are you sure, you want to delete it?')" href="{{ route('deleteinventory',$user->id) }}" class="text-danger"><i class="bx bx-trash"></i></a>
                          <a href="{{ route('viewinventory',$user->id) }}" title="view"><i class="bx bx-bullseye"></i></a>
                          <a href="{{ route('editinventory',$user->id) }}" title="edit"><i class="bx bx-edit-alt"></i></a>
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
<div class="modal" id="userCreateModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Create Inventory</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        {{-- <form method="post" action="{{ route('createinventory') }}">
          @csrf
          <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" class="form-control" placeholder="Enter title" required="">
          </div>
          <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control" placeholder="Enter Description" required=""></textarea>
          </div>
          <!--- select customer --->
          <div class="form-group">
            <label>Select Customer</label>
            <div class="row">
              <div class="col-sm-6">
                <select class="form-control" name="customer_id" required="" id="customer_dropdown">
                  @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->first_name." ".$customer->last_name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-sm-6">
                <a class="btn btn-primary form-control text-white" data-toggle="modal" data-target="#customerCreateModal">Add New Customer</a>
              </div>
            </div>
          </div>
          <!--- select project type  --->
          <div class="form-group">
            <label>Select Project Type</label>
            <select class="form-control" name="project_type_id" required="">
              @foreach ($projects as $project)
                <option value="{{ $project->id }}">{{ $project->title }}</option>
              @endforeach
            </select>
          </div>
          <!--- select color  --->
          <div class="form-group">
            <label>Select Color</label>
            <select class="form-control" name="color_id" required="">
              @foreach ($colors as $color)
                <option value="{{ $color->id }}">{{ $color->title }}</option>
              @endforeach
            </select>
          </div>
          <!--- select project type  --->
          <div class="form-group">
            <label>Select Service</label>
            <select class="form-control" name="service_id" required="">
              @foreach ($services as $service)
                <option value="{{ $service->id }}">{{ $service->title }}</option>
              @endforeach
            </select>
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form> --}}
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
          <!--- select customer --->
          <div class="form-group">
            <label>Select Customer</label>
            <div class="row">
              <div class="col-sm-9">
                <select class="form-control" name="customer_id" required="" id="customer_dropdown">
                  @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->first_name." ".$customer->last_name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-sm-3">
                <a class="btn btn-primary form-control text-white" data-toggle="modal" data-target="#customerCreateModal">Add New Customer</a>
              </div>
            </div>
          </div>
          <div  class="project_field_wrapper">
          </div>

          <input type="hidden" value="1" id="counter" />
          <!--- add project  --->
          <div style="border-style: dashed;padding: 13px;" id="main_div">
              <div id="project_section_1">
                  <div class="form-group">
                    <label>project</label>
                    <input type="text" name="project[]" class="form-control" placeholder="Enter project" required="">
                  </div>
                  <div class="form-group">
                    <label>Select Project Type</label>
                    <select class="form-control" name="project_type_id[]" required="">
                      @foreach ($projects as $project)
                        <option value="{{ $project->id }}">{{ $project->title }}</option>
                      @endforeach
                    </select>
                  </div>
                  <!--- select color  --->
                  <div class="form-group">
                    <label>Select Color</label>
                    <select class="form-control" name="color_id[]" required="">
                      @foreach ($colors as $color)
                        <option value="{{ $color->id }}">{{ $color->title }}</option>
                      @endforeach
                    </select>
                  </div>
                  <!--- select project type  --->
                  <div class="form-group">
                    <label>Select Service</label>
                    <select class="form-control" name="service_id[]" required="">
                      @foreach ($services as $service)
                        <option value="{{ $service->id }}">{{ $service->title }}</option>
                      @endforeach
                    </select>
                  </div>

                  <div style="border-style: dashed;margin-top: 25px;padding: 13px;" id="project_item_section_1">
                    <input type="hidden" value="1" id="project_id_value_1" />
                    <div id="project_1_item_section_1">
                      <div class="form-group">
                          <label>Item</label>
                          <input type="text" name="Item1[]" class="form-control" placeholder="Item" required="">
                      </div>
                      <div class="form-group">
                        <label>Item Description</label>
                        <textarea type="text" name="Item_Description1[]" class="form-control" placeholder="Item Description" required=""></textarea>
                        <a href="javascript:void(0);" project_id="1" item_id ="1"   class="add_item_section_button" title="Add field"><img width="27px" style="margin-top: 20px;" src="https://img.icons8.com/ios/452/add--v1.png"/></a>
                      </div>
                    </div>

                  </div>

                  <a href="javascript:void(0);"  class="add_project_section" title="Add Project"><img width="27px" style="margin-top: 20px;" src="https://img.icons8.com/ios/452/add--v1.png"/></a>
              </div>
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
<script src="{{asset('vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/dataTables.bootstrap4.min.js')}}"></script>
@endsection

{{-- page scripts --}}
@section('page-scripts')
<script src="{{asset('js/scripts/pages/page-users.js')}}"></script>

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
        counter ++;
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
