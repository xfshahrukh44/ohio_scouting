@extends('admin.layouts.master')

@section('content_header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1 class="m-0 text-dark"><i class="nav-icon fas fa-text-width"></i> Banners</h1>
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
            <button class="btn btn-success" id="add_item" data-toggle="modal" data-target="#addBannerModal">
                <i class="fas fa-plus"></i>
            </button>
        </div>
        <!-- search bar -->
        <form action="{{route('search_banners')}}" class="form-wrapper">
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
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Page</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Title</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Subtitle</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Description</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Status</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Actions</th>
              </tr>
            </thead>
            <tbody>
              @if(count($banners) > 0)
                @foreach($banners as $banner)
                  <tr role="row" class="odd">
                    <!-- page -->
                    <td class="{{'page'.$banner->id}}">{{$banner->page}}</td>
                    
                    <!-- title -->
                    <td class="{{'title'.$banner->id}}">{{$banner->title}}</td>

                    <!-- subtitle -->
                    <td class="{{'subtitle'.$banner->id}}">{{$banner->subtitle}}</td>

                    <!-- description (with see more collapse) -->
                    <td class="{{'description'.$banner->id}}" width="500">
                      <div class="content hideContent">
                        {{$banner->description}}
                      </div>
                      <div class="show-more">
                        <a href="#">Show more</a>
                      </div></td>
                    </td>

                    <!-- status -->
                    <td class="{{'status'.$banner->id}}">{{$banner->status}}</td>

                    <!-- actions -->
                    <td width="100">
                        <!-- Detail -->
                        <!-- <a href="#" class="detailButton" data-id="{{$banner->id}}">
                          <i class="fas fa-eye green ml-1"></i>
                        </a> -->
                        <!-- Edit -->
                        <a href="#" class="editButton" data-id="{{$banner->id}}">
                          <i class="fas fa-edit blue ml-1"></i>
                        </a>
                        <!-- Delete -->
                        <a href="#" class="deleteButton" data-id="{{$banner->id}}">
                          <i class="fas fa-trash red ml-1"></i>
                        </a>
                    </td>
                  </tr>
                @endforeach
              @else
                <tr><td colspan="6"><h6 align="center">No banner(s) found</h6></td></tr>
              @endif
            </tbody>
            <tfoot>

            </tfoot>
          </table>
        </div>
      <!-- /.card-body -->
      <div class="card-footer">
        @if(count($banners) > 0)
        {{$banners->appends(request()->except('page'))->links()}}
        @endif
      </div>
    </div>
  </div>
</div>

 <!-- Create view -->
<div class="modal fade" id="addBannerModal" tabindex="-1" role="dialog" aria-labelledby="addBannerModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addBannerModalLabel">Add New Banner</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{route('banner.store')}}" enctype="multipart/form-data">
        @csrf
        @include('admin.banner.banner_master')
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Create</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit view -->
<div class="modal fade" id="editBannerModal" tabindex="-1" role="dialog" aria-labelledby="editBannerModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editBannerModalLabel">Edit Banner</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="editForm" method="POST" action="{{route('banner.update', 1)}}" enctype="multipart/form-data">
        <!-- hidden input -->
        @method('PUT')
        <input id="hidden" type="hidden" name="hidden">
        @csrf
        @include('admin.banner.banner_master')
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Detail view -->
<div class="modal fade" id="viewBannerModal" tabindex="-1" role="dialog" aria-labelledby="addBannerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Banner Detail</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- TABS -->
            <ul class="nav nav-pills nav-fill" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                <a class="nav-link active bci" data-toggle="tab" href="#bci">Basic Banner Information</a>
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
              <!-- basic banner info -->
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
                                <td class="">Banner Type</td>
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
<div class="modal fade" id="deleteBannerModal" tabindex="-1" role="dialog" aria-labelledby="deleteBannerModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteBannerModalLabel">Delete Banner</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="deleteForm" method="POST" action="{{route('banner.destroy', 1)}}">
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
    var banner = "";

    // fetch banner
    function fetch_banner(id){
        $.ajax({
            url: '<?php echo(route("banner.show", 0)); ?>',
            type: 'GET',
            data: {id: id},
            dataType: 'JSON',
            async: false,
            success: function (data) {
                banner = data.banner;
            }
        });
    }

    // create
    $('#add_banner').on('click', function(){
        
    });

    // edit
    $('.editButton').on('click', function(){
        var id = $(this).data('id');
        fetch_banner(id);
        $('#hidden').val(id);

        $('#editForm .page').val(banner.page ? banner.page : '');
        $('#editForm .title').val(banner.title ? banner.title : '');
        $('#editForm .subtitle').val(banner.subtitle ? banner.subtitle : '');
        $('#editForm .description').val(banner.description ? banner.description : '');

        // status
        if(banner.status == "Active"){
          $('#editForm .status').prop('checked', true);
        }
        else{
          $('#editForm .status').prop('checked', false);
        }
        
        $('#editBannerModal').modal('show');
    });

    // detail
    $('.detailButton').on('click', function(){
      $('.bci').trigger('click');
      var id = $(this).data('id');
      fetch_banner(id);
      // var banner = $(this).data('object');
      $('.name').html(banner.name ? banner.name : '');
      $('.contact_number').html(banner.contact_number ? banner.contact_number : '');
      $('.whatsapp_number').html(banner.whatsapp_number);
      if(banner.shop_keeper_picture){
          var shop_path = $(this).data('shopkeeper');
          $('.shop_keeper_picture').attr('src', shop_path);
      }
      else{
          var shop_path = '{{asset("img/logo.png")}}';
          $('.shop_keeper_picture').attr('src', shop_path);
      }
      $('.type').html(banner.type ? banner.type : '');
      $('.shop_name').html(banner.shop_name ? banner.shop_name : '');
      $('.shop_number').html(banner.shop_number ? banner.shop_number : '');
      $('.floor').html(banner.floor ? banner.floor : '');
      $('.area').html((banner.market && banner.market.area) ? banner.market.area.name : '');
      $('.market').html(banner.market ? banner.market.name : '');
      if(banner.shop_picture){
          var shop_path = $(this).data('shop');
          $('.shop_picture').attr('src', shop_path);
      }
      else{
          var shop_path = '{{asset("img/logo.png")}}';
          $('.shop_picture').attr('src', shop_path);
      }
      // image gallery work
      $('.gallery_wrapper').html('');
      if(banner.banner_images.length > 0){
          for(var i = 0; i < banner.banner_images.length; i++){
          $('.gallery_wrapper').append(`<div class="col-md-4 mb-3"><a target="_blank" href="{{asset('img/banner_images')}}/`+banner.banner_images[i].location+`" class="col-md-12"><img class="col-md-12 shop_keeper_picture" src="{{asset('img/banner_images')}}/`+banner.banner_images[i].location+`"></a><button class="btn btn_del_banner_image" value="`+banner.banner_images[i].id+`" type="button"><i class="fas fa-trash red ml-1"></i></button></div>`);
          }
      }
      $('.status').html(banner.status ? banner.status : '');
      $('.visiting_days').html(banner.visiting_days ? banner.visiting_days : '');
      $('.cash_on_delivery').html(banner.cash_on_delivery ? banner.cash_on_delivery : '');
      $('.opening_balance').html(banner.opening_balance ? ("Rs. " + banner.opening_balance.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")) : '');
      $('.business_to_date').html(banner.business_to_date ? ("Rs. " + banner.business_to_date.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")) : '');
      $('.outstanding_balance').html(banner.outstanding_balance ? ("Rs. " + banner.outstanding_balance.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")) : '');
      // $('.special_discount').html(banner.special_discount ? ("Rs. " + banner.special_discount) : '');
      $('#viewBannerModal').modal('show');
    });

    // delete
    $('.deleteButton').on('click', function(){
      var id = $(this).data('id');
      $('#deleteForm').attr('action', "{{route('banner.destroy', 1)}}");
      $('#deleteForm .hidden').val(id);
      $('#deleteBannerModalLabel').text('Delete Banner: ' + $('.page' + id).html() + "?");
      $('#deleteBannerModal').modal('show');
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
});
</script>
@endsection('content_body')