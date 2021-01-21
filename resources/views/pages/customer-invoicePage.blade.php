
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


<form method="POST" action="{{ route('store_invoice') }}">
  @csrf
      <div class="row border rounded py-2 mb-2">
        <div class="col-12 col-sm-6 col-lg-2">
          <label>Customer Name</label>
          <fieldset class="form-group">
            <select name="name" required class="form-control">
               @foreach($customer->QueryResponse->Customer as $key=>$customerr)
              <option value="{{ $customerr->Id }}">{{ $customerr->DisplayName }}</option>
              @endforeach
            </select>
           {{-- <input type="text" name="name" class="form-control" placeholder="Enter Name" required > --}}
           <input type="hidden" name="code" value="<?php echo $_GET['code'];?>">
           <input type="hidden" name="realmId" value="<?php echo $_GET['realmId'];?>">
          </fieldset>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
          <label>Project</label>
            <fieldset class="form-group">
              <select class="form-control" id='sel_project' name='project_id' required>
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
                 <select class="form-control" id='sel_item' name='item_id' required>
                   <option value='0'>-- Select Item --</option>
                 </select>
          </fieldset>
        </div>

        <div class="col-12 col-sm-6 col-lg-2">
            <label>$ Price</label>
            <fieldset class="form-group">
            <input type="number" name="price" class="form-control" placeholder="Enter price" required >
            </fieldset>
        </div>
        <input type="hidden" name="tooken" value="{{$token}}">

        <div class="col-12 col-sm-6 col-lg-2">
          <label># Total Linear FT</label>
          <fieldset class="form-group">
          <input type="text" name="Total_Linear_FT" class="form-control" placeholder="Enter"required >
          </fieldset>
        </div>

        <div class="col-12 col-sm-6 col-lg-2 d-flex align-items-center">
          <button type="submit" class="btn btn-primary btn-block glow users-list-clear mb-0">Generate</button>
        </div>
      </div>
    </form>
  </div>
  <div class="users-list-table">
    <div class="card">
      <div class="card-content">
        <div class="card-body">

          {{-- <div class="text-right">
            <a class="btn btn-primary text-white" data-toggle="modal" data-target="#userCreateModal"> <i class="fa fa-plus"></i> Create Customer</a><br><br>
          </div> --}}

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
                    <th>Invoice No</th>
                    <th>Customer Name</th>
                    <th>TOTAL LINEAR FT</th>
                    <th>Price</th>

                    <th>Create Date</th>
                    <th>edit</th>
                    <th>Invoice PDF</th>
                </tr>
              </thead>
              <tbody>
               <?php  $i=1;?>
                @foreach ($invoicelist->QueryResponse->Invoice as $item)
                <tr>
                  <td><?php echo $i;?></td>
                  <td> {{$item->Id}} </td>
                  <td>
                    {{ $item->CustomerRef->name }}
                    {{-- @foreach ($item->CustomerRef as $CustomFieldn)
                    {{$CustomFieldn}}
                    @endforeach --}}
                </td>
                  <td> @foreach ($item->Line as $itemn)

                  @endforeach
                  {{$itemn->DetailType}}
                </td>
                  <td>
                    @foreach ($item->Line as $itemn)

                    @endforeach
                    {{$itemn->Amount}}
                  </td>

                  <td>
                    @foreach ($item->MetaData as $itemnn)


                   @endforeach
                   {{$itemnn}}



                </td>
                  <td>
                    <a  onclick="return confirm('Are you sure, you want to delete it?')" href="{{ route('generate_pdf') }}?t={{$token}}&id={{$item->Id}}&st={{$item->SyncToken}}" class="text-danger"><i class="bx bx-trash"></i></a>
                    <a data-toggle="modal" data-target="#exampleModal{{$item->Id}}" href="#"><i class="bx bx-edit-alt"></i></a>
                  </td>
                  <td><form action="{{ route('generate_pdf') }}" method="post"> @csrf
                     <input type="hidden" name="tooken" value="{{$token}}">
                    <input type="hidden" name="id" value="{{$item->Id}}">
                    <input type="hidden" name="SyncToken" value="{{$item->SyncToken}}">
                    <button type="submit"> <i class='bx bxs-file-pdf'></i></button></form></td>
                </tr>
                <!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="exampleModal{{$item->Id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Invoice</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{route('generate_pdf')}}" method="POST">
          @csrf
       Invoice Name<input type="text" name="name" value=""class="form-control" required>
       Invoice Price<input type="text" name="price" value=" {{$itemn->Amount}}" class="form-control" required>
       <input type="hidden" name="updatetooken" value="{{$token}}">
       <input type="hidden" name="updateid" value="{{$item->Id}}">
       <input type="hidden" name="updateid" value="{{$item->Id}}">
       <input type="hidden" name="updateSyncToken" value="{{$item->SyncToken}}">
       <input type="hidden" name="realmId" value="<?php echo $_GET['realmId'];?>">
       <br>
       <br>
       <button type="submit"name="update" class="btn btn-primary">Update</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
                <?php  $i++;?>
                @endforeach


              </tbody>
            </table>
          </div>
          <!-- datatable ends -->
        </div>
      </div>
    </div>
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
<script src="{{asset('vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/dataTables.bootstrap4.min.js')}}"></script>
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
