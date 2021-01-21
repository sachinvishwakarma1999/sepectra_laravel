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
              <div class="row">
                  <div class="col-12 col-sm-6">
                      <div class="form-group">
                          <div class="controls">
                              <label>Name</label>
                              <input name="title" type="text" class="form-control" placeholder="Name"
                                  value="{{ $Inventory->title }}" readonly>
                          </div>
                      </div>
                      <div class="form-group">
                          <div class="controls">
                              <label>Description</label>
                              <textarea style="height:200px;" name="description" class="form-control" placeholder="Name" required
                                  data-validation-required-message="This title field is required" readonly>{{ $Inventory->description }}</textarea>
                          </div>
                      </div>
                  </div>

                  <!--- select customer --->
                  <div class="col-12 col-sm-6">
                    <div class="form-group">
                      <label>Customer</label>
                      <div class="row">
                        <div class="col-sm-12">
                            @foreach ($customers as $customer)
                                @if($customer->id == $Inventory->customer_id)
                                <input name="title" type="text" class="form-control" placeholder="Name" value="{{ $customer->first_name." ".$customer->last_name }}" readonly>
                                @endif
                            @endforeach
                        </div>
                      </div> 
                    </div>
                  </div>
                  <!--- add project  --->
                  <input type="hidden" value="{{ count($Inventory->project) }}" id="counter" />

                  @if(count($Inventory->project) > 0)
                  <div class="col-12 col-sm-12">
                    <div style="border-style: dashed;padding: 13px;" id="main_div">
                      @foreach ($Inventory->project as $keyproject=>$item)
                        <?php $keyproject1 = $keyproject+1; ?>
                        <div id="project_section_{{ $keyproject1 }}">
                          <div class="form-group">
                            <label>project</label>
                            <input type="text" name="project[]" value="{{ $item->name }}" class="form-control" placeholder="Enter project" required="" readonly>
                          </div>
                          <div class="form-group">
                            <label>Project Type</label>
                              @foreach ($projects as $project)
                                @if($item->type == $project->id)
                                <input type="text" name="project_type_id[]" value="{{ $project->title }}" class="form-control" placeholder="Enter project" required="" readonly>
                                @endif
                              @endforeach
                            </select>
                          </div>


                          <div class="form-group">
                            <label>Color</label>
                              @foreach ($colors as $color)
                                @if($color->id == $item->color_id)
                                <input type="text" name="color_id[]" value="{{ $color->title }}" class="form-control" placeholder="Enter project" required="" readonly>
                                @endif
                              @endforeach
                          </div>
                          <!--- select project type  --->
                          <div class="form-group">
                            <label>Service</label>
                              @foreach ($services as $service)
                                @if($service->id == $item->service_id)
                                <input type="text" name="service_id[]" value="{{ $service->title }}" class="form-control" placeholder="Enter project" required="" readonly>
                                @endif
                              @endforeach
                          </div>


                          <div style="border-style: dashed;margin-top: 25px;padding: 13px;" id="project_item_section_{{ $keyproject1 }}">
                            <input type="hidden" value="{{ count($item->items) }}" id="project_id_value_{{ $keyproject1 }}" />

                            @foreach ($item->items as $project_item_key=>$project_item)
                              <?php $keyprojectitems1 = $project_item_key + 1; ?>
                              <div id="project_{{ $keyproject1 }}_item_section_{{ $keyprojectitems1 }}">
                                <div class="form-group">
                                  <label>Item</label>
                                  <input type="text" name="Item{{ $keyproject1 }}[]" value="{{ $project_item->name }}" class="form-control" placeholder="Item" required="" readonly>
                                </div>
                                <div class="form-group">
                                  <label>Item Description</label>
                                  <textarea type="text" name="Item_Description{{ $keyproject1 }}[]" class="form-control" placeholder="Item Description" required="" readonly>{{ $project_item->description }}</textarea>
                                </div>
                              </div>
                            @endforeach

                          </div>

                        </div>
                      @endforeach
                    </div>
                  </div>
                  @endif

              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

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
