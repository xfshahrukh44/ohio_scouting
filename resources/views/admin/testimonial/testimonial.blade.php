@extends('admin.layouts.master')

@section('content_header')
<div class="row mb-2">
  <div class="col-sm-12 col-md-12 col-lg-12">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <h1 class="m-0 text-dark"><i class="nav-icon fas fa-bullhorn"></i> Testimonials</h1>
  </div>
</div>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<!-- fancybox styles -->
<style>
  /* The switch - the box around the slider */
  .switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
  }

  /* Hide default HTML checkbox */
  .switch input {
    opacity: 0;
    width: 0;
    height: 0;
  }

  /* The slider */
  .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
  }

  .slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
  }

  input:checked + .slider {
    background-color: #2196F3;
  }

  input:focus + .slider {
    box-shadow: 0 0 1px #2196F3;
  }

  input:checked + .slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
  }
</style>

<!-- see more (description) -->
<style>
  div.text-container {
      margin: 0 auto;
      width: 75%;    
  }

  .hideContent {
      overflow: hidden;
      line-height: 1em;
      height: 2em;
  }

  .showContent {
      line-height: 1em;
      height: auto;
  }
  .showContent{
    height: auto;
  }

  h1 {
    font-size: 24px;        
  }
  p {
      padding: 10px 0;
  }
  
  .show-more {
      padding: 10px 0;
      text-align: center;
  }
</style>

@endsection

@section('content_body')
<!-- Index view -->
<div class="row">
  <div class="col-md-12 col-sm-12">
    <div class="card">
      <div class="card-header">
        <div class="card-tools">
            <button class="btn btn-success" id="add_item" data-toggle="modal" data-target="#addTestimonialModal">
                <i class="fas fa-plus"></i>
            </button>
        </div>
        <!-- search bar -->
        <form action="{{route('search_testimonials')}}" class="form-wrapper">
          <div class="row">
              <!-- search bar -->
              <div class="topnav col-md-4 col-sm-4">
                <input name="query" class="form-control" id="search_content" type="text" placeholder="Search..">
              </div>
              <!-- search button-->
              <button type="submit" class="btn btn-primary col-md-0 col-sm-0 justify-content-start" id="search_button">
                <i class="fas fa-search"></i>
              </button>
          </div>
        </form>
      </div>
      
      <!-- /.card-header -->
      <div class="card-body">
        <div class="col-md-12 col-sm-12" style="overflow-x:auto;">
          <table id="example1" class="table table-bordered table-striped dataTable dtr-inline " role="grid" aria-describedby="example1_info">
            <thead>
              <tr role="row">
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Image</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Name</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Designation</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Description</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Status</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Actions</th>
              </tr>
            </thead>
            <tbody>
              @if(count($testimonials) > 0)
                @foreach($testimonials as $testimonial)
                  <tr role="row" class="odd">
                    <!-- image (fancybox) -->
                    <td class="{{'image'.$testimonial->id}}" width="140">
                        <a class="fancybox" href="{{($testimonial->image) ? (asset('img/testimonials') . '/' . $testimonial->image) : (asset('img/noimg.jpg'))}}">
                            <img src="{{($testimonial->image) ? (asset('img/testimonials') . '/' . $testimonial->image) : (asset('img/noimg.jpg'))}}" width="60%" alt="">
                        </a>
                    </td>

                    <!-- name -->
                    <td class="{{'name'.$testimonial->id}}">{{$testimonial->name}}</td>

                    <!-- designation -->
                    <td class="{{'designation'.$testimonial->id}}">{{$testimonial->designation}}</td>

                    <!-- description (with see more collapse) -->
                    <td class="{{'description'.$testimonial->id}}">
                      <div class="content hideContent">
                        {{$testimonial->description}}
                      </div>
                      <div class="show-more">
                        <a href="#">Show more</a>
                      </div></td>
                    </td>

                    <!-- status -->
                    <td class="{{'status'.$testimonial->id}}">
                      <label class="switch">
                        @if($testimonial->status == "Active")
                          <input type="checkbox" data-id="{{$testimonial->id}}" class="input_status" checked>
                        @else
                          <input type="checkbox" data-id="{{$testimonial->id}}" class="input_status">
                        @endif
                        <span class="slider"></span>
                      </label>
                    </td>

                    <!-- actions -->
                    <td width="100">
                        <!-- Detail -->
                        <!-- <a href="#" class="detailButton" data-id="{{$testimonial->id}}">
                          <i class="fas fa-eye green ml-1"></i>
                        </a> -->
                        <!-- Edit -->
                        <a href="#" class="editButton" data-id="{{$testimonial->id}}">
                          <i class="fas fa-edit blue ml-1"></i>
                        </a>
                        <!-- Delete -->
                        <a href="#" class="deleteButton" data-id="{{$testimonial->id}}">
                          <i class="fas fa-trash red ml-1"></i>
                        </a>
                    </td>
                  </tr>
                @endforeach
              @else
                <tr><td colspan="6"><h6 align="center">No testimonial(s) found</h6></td></tr>
              @endif
            </tbody>
            <tfoot>

            </tfoot>
          </table>
        </div>
      <!-- /.card-body -->
      <div class="card-footer">
        @if(count($testimonials) > 0)
        {{$testimonials->appends(request()->except('page'))->links()}}
        @endif
      </div>
    </div>
  </div>
</div>

 <!-- Create view -->
<div class="modal fade" id="addTestimonialModal" tabindex="-1" role="dialog" aria-labelledby="addTestimonialModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addTestimonialModalLabel">Add New Testimonial</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{route('testimonial.store')}}" enctype="multipart/form-data">
        @csrf
        @include('admin.testimonial.testimonial_master')
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Create</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit view -->
<div class="modal fade" id="editTestimonialModal" tabindex="-1" role="dialog" aria-labelledby="editTestimonialModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editTestimonialModalLabel">Edit Testimonial</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="editForm" method="POST" action="{{route('testimonial.update', 1)}}" enctype="multipart/form-data">
        <!-- hidden input -->
        @method('PUT')
        <input id="hidden" type="hidden" name="hidden">
        @csrf
        @include('admin.testimonial.testimonial_master')
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Detail view -->
<div class="modal fade" id="viewTestimonialModal" tabindex="-1" role="dialog" aria-labelledby="addTestimonialModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Testimonial Detail</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- TABS -->
            <ul class="nav nav-pills nav-fill" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                <a class="nav-link active bci" data-toggle="tab" href="#bci">Basic Testimonial Information</a>
              </li>
              <li class="nav-item" role="presentation" >
                <a class="nav-link" data-toggle="tab" href="#si">Shop Information</a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link" data-toggle="tab" href="#pi">Payment Information</a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link" data-toggle="tab" href="#ig">Image Gallery</a>
              </li>
            </ul>

            <!-- TAB CONTENT -->
            <div class="tab-content" id="myTabContent">
              <!-- basic testimonial info -->
              <div class="tab-pane fade show active" id="bci">
                <div class="card-body">
                  <div class="col-md-12 col-sm-12">
                    <img class="shop_keeper_picture" src="{{asset('img/logo.png')}}" width="150">
                    <hr style="color:gray;">
                    <table class="table table-bordered table-striped">
                        <tbody id="table_row_wrapper">
                            <tr role="row" class="odd">
                                <td class="">Name</td>
                                <td class="name"></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="">Contact #</td>
                                <td class="contact_number"></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="">Whatsapp #</td>
                                <td class="whatsapp_number"></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="">Testimonial Type</td>
                                <td class="type"></td>
                            </tr>
                        </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <!-- Shop info -->
              <div class="tab-pane fade" id="si">
                <div class="card-body">
                  <div class="col-md-12 col-sm-12">
                    <img class="shop_picture" src="{{asset('img/logo.png')}}" width="150">
                    <hr style="color:gray;">
                    <table class="table table-bordered table-striped">
                        <tbody id="table_row_wrapper">
                            <tr role="row" class="odd">
                                <td class="">Shop Name</td>
                                <td class="shop_name"></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="">Shop #</td>
                                <td class="shop_number"></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="">Floor #</td>
                                <td class="floor"></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="">Area</td>
                                <td class="area"></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="">Market</td>
                                <td class="market"></td>
                            </tr>
                        </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <!-- Payment info -->
              <div class="tab-pane fade" id="pi">
                <div class="card-body">
                  <div class="col-md-12 col-sm-12">
                    <hr style="color:gray;">
                    <table class="table table-bordered table-striped">
                        <tbody id="table_row_wrapper">
                            <tr role="row" class="odd">
                                <td class="">Status</td>
                                <td class="status"></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="">Visting Days</td>
                                <td class="visiting_days"></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="">Cash on Delivery</td>
                                <td class="cash_on_delivery"></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="">Opening Balance</td>
                                <td class="opening_balance"></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="">Business to Date</td>
                                <td class="business_to_date"></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="">Outstanding Balance</td>
                                <td class="outstanding_balance"></td>
                            </tr>
                            <tr role="row" class="odd" hidden>
                                <td class="">Special Discount</td>
                                <td class="special_discount"></td>
                            </tr>
                        </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <!-- Image Gallery -->
              <div class="tab-pane fade" id="ig">
                <div class="card-body row overflow-auto col-md-12 p-3 gallery_wrapper" style="height:28rem;">
                    <a target="_blank" href="{{asset('img/logo.png')}}" class="col-md-4 mb-3">
                      <img class="col-md-12 shop_keeper_picture" src="{{asset('img/logo.png')}}">
                    </a>
                    <a target="_blank" href="{{asset('img/logo.png')}}" class="col-md-4 mb-3">
                      <img class="col-md-12 shop_keeper_picture" src="{{asset('img/logo.png')}}">
                    </a>
                    <a target="_blank" href="{{asset('img/logo.png')}}" class="col-md-4 mb-3">
                      <img class="col-md-12 shop_keeper_picture" src="{{asset('img/logo.png')}}">
                    </a>
                    <a target="_blank" href="{{asset('img/logo.png')}}" class="col-md-4 mb-3">
                      <img class="col-md-12 shop_keeper_picture" src="{{asset('img/logo.png')}}">
                    </a>
                  <!-- </div> -->
                </div>
              </div>

            </div>

            <div class="card-footer">
                <button class="btn btn-primary" data-dismiss="modal" style="float: right;">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete view -->
<div class="modal fade" id="deleteTestimonialModal" tabindex="-1" role="dialog" aria-labelledby="deleteTestimonialModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteTestimonialModalLabel">Delete Testimonial</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="deleteForm" method="POST" action="{{route('testimonial.destroy', 1)}}">
        <!-- hidden input -->
        @method('DELETE')
        @csrf
        <input class="hidden" type="hidden" name="hidden">
        <div class="modal-footer">
          <button class="btn btn-primary" data-dismiss="modal">No</button>
          <button type="submit" class="btn btn-danger" id="deleteButton">Yes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
$(document).ready(function(){
    // $('#area_id').select2();
    // $('#market_id').select2();
    // datatable
    // $('#example1').DataTable();
    // $('#example1').dataTable({
    //   "bPaginate": false,
    //   "bLengthChange": false,
    //   "bFilter": true,
    //   "bInfo": false,
    //   "searching":false
    // });

    // get url params
    $.urlParam = function(name){
        var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
        if (results==null) {
            return null;
        }
        return decodeURI(results[1]) || 0;
    }
  
    // persistent active sidebar
    var element = $('li a[href*="'+ window.location.pathname +'"]');
    element.parent().addClass('menu-open');

    // fancybox init
    $(".fancybox").fancybox({
        helpers: {
            title : {
                type : 'float'
            }
        }
    });

    // global vars
    var testimonial = "";

    // fetch testimonial
    function fetch_testimonial(id){
        $.ajax({
            url: '<?php echo(route("testimonial.show", 0)); ?>',
            type: 'GET',
            data: {id: id},
            dataType: 'JSON',
            async: false,
            success: function (data) {
                testimonial = data.testimonial;
            }
        });
    }

    // toggle_status
    function toggle_status(id){
      $.ajax({
          url: '<?php echo(route('toggle_testimonial_status')); ?>',
          type: 'GET',
          data: {
            id: id
          },
          dataType: 'JSON',
          async: false,
          success: function (data) {
            
          }
      });
    }

    // create
    $('#add_testimonial').on('click', function(){
        
    });

    // edit
    $('.editButton').on('click', function(){
        var id = $(this).data('id');
        fetch_testimonial(id);
        $('#hidden').val(id);

        $('#editForm .name').val(testimonial.name ? testimonial.name : '');
        $('#editForm .designation').val(testimonial.designation ? testimonial.designation : '');
        $('#editForm .description').val(testimonial.description ? testimonial.description : '');

        // status
        if(testimonial.status == "Active"){
          $('#editForm .status').prop('checked', true);
        }
        else{
          $('#editForm .status').prop('checked', false);
        }

        // image
        // un hide preview div
        $('#editForm .preview_wrapper').prop('hidden', false);
        // update preview image
        if(testimonial.image){
          var src = `<?php echo(asset('img/testimonials') . '/temp'); ?>`;
          src = src.replace('temp', testimonial.image);
        }
        else{
          var src = `<?php echo(asset('img/noimg.jpg')); ?>`;
        }
        $('#editForm .preview_image').prop('src', src);
        
        $('#editTestimonialModal').modal('show');
    });

    // detail
    $('.detailButton').on('click', function(){
      $('.bci').trigger('click');
      var id = $(this).data('id');
      fetch_testimonial(id);
      // var testimonial = $(this).data('object');
      $('.name').html(testimonial.name ? testimonial.name : '');
      $('.contact_number').html(testimonial.contact_number ? testimonial.contact_number : '');
      $('.whatsapp_number').html(testimonial.whatsapp_number);
      if(testimonial.shop_keeper_picture){
          var shop_path = $(this).data('shopkeeper');
          $('.shop_keeper_picture').attr('src', shop_path);
      }
      else{
          var shop_path = '{{asset("img/logo.png")}}';
          $('.shop_keeper_picture').attr('src', shop_path);
      }
      $('.type').html(testimonial.type ? testimonial.type : '');
      $('.shop_name').html(testimonial.shop_name ? testimonial.shop_name : '');
      $('.shop_number').html(testimonial.shop_number ? testimonial.shop_number : '');
      $('.floor').html(testimonial.floor ? testimonial.floor : '');
      $('.area').html((testimonial.market && testimonial.market.area) ? testimonial.market.area.name : '');
      $('.market').html(testimonial.market ? testimonial.market.name : '');
      if(testimonial.shop_picture){
          var shop_path = $(this).data('shop');
          $('.shop_picture').attr('src', shop_path);
      }
      else{
          var shop_path = '{{asset("img/logo.png")}}';
          $('.shop_picture').attr('src', shop_path);
      }
      // image gallery work
      $('.gallery_wrapper').html('');
      if(testimonial.testimonial_images.length > 0){
          for(var i = 0; i < testimonial.testimonial_images.length; i++){
          $('.gallery_wrapper').append(`<div class="col-md-4 mb-3"><a target="_blank" href="{{asset('img/testimonial_images')}}/`+testimonial.testimonial_images[i].location+`" class="col-md-12"><img class="col-md-12 shop_keeper_picture" src="{{asset('img/testimonial_images')}}/`+testimonial.testimonial_images[i].location+`"></a><button class="btn btn_del_testimonial_image" value="`+testimonial.testimonial_images[i].id+`" type="button"><i class="fas fa-trash red ml-1"></i></button></div>`);
          }
      }
      $('.status').html(testimonial.status ? testimonial.status : '');
      $('.visiting_days').html(testimonial.visiting_days ? testimonial.visiting_days : '');
      $('.cash_on_delivery').html(testimonial.cash_on_delivery ? testimonial.cash_on_delivery : '');
      $('.opening_balance').html(testimonial.opening_balance ? ("Rs. " + testimonial.opening_balance.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")) : '');
      $('.business_to_date').html(testimonial.business_to_date ? ("Rs. " + testimonial.business_to_date.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")) : '');
      $('.outstanding_balance').html(testimonial.outstanding_balance ? ("Rs. " + testimonial.outstanding_balance.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")) : '');
      // $('.special_discount').html(testimonial.special_discount ? ("Rs. " + testimonial.special_discount) : '');
      $('#viewTestimonialModal').modal('show');
    });

    // delete
    $('.deleteButton').on('click', function(){
      var id = $(this).data('id');
      $('#deleteForm').attr('action', "{{route('testimonial.destroy', 1)}}");
      $('#deleteForm .hidden').val(id);
      $('#deleteTestimonialModalLabel').text('Delete Testimonial: ' + $('.name' + id).html() + "?");
      $('#deleteTestimonialModal').modal('show');
    });

    // on show-more click (see more collapse)
    $(".show-more a").on("click", function() {
      var $this = $(this); 
      var $content = $this.parent().prev("div.content");
      var linkText = $this.text().toUpperCase();    
      
      if(linkText === "SHOW MORE"){
          linkText = "Show less";
          $content.switchClass("hideContent", "showContent", 100);
      } else {
          linkText = "Show more";
          $content.switchClass("showContent", "hideContent", 100);
      };

      $this.text(linkText);
    });

    // on image click (preview)
    $('#editForm .image').on('change', function(){
      // console.log($(this)[0]);
      // console.log($(this).parent().find('img'));
      var input = ($(this))[0];
      var preview_target = $(this).parent().find('img');

      if (input.files && input.files[0]) {
          var reader = new FileReader();
  
          reader.onload = function (e) {
              preview_target
                      .attr('src', e.target.result);
          };
  
          reader.readAsDataURL(input.files[0]);
      }
    });

    // on .input_status click
    $('.input_status').on('click', function(){
      var id = $(this).data('id');
      toggle_status(id);
    });
});
</script>
@endsection('content_body')