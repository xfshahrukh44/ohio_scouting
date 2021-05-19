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
    <h1 class="m-0 text-dark"><i class="nav-icon fas fa-newspaper"></i> News</h1>
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
            <button class="btn btn-success" id="add_item" data-toggle="modal" data-target="#addNewsModal">
                <i class="fas fa-plus"></i>
            </button>
        </div>
        <!-- search bar -->
        <form action="{{route('search_news')}}" class="form-wrapper">
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
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Title</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Type</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Description</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Date</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Actions</th>
              </tr>
            </thead>
            <tbody>
              @if(count($news) > 0)
                @foreach($news as $single_news)
                  <tr role="row" class="odd">
                    <!-- image (fancybox) -->
                    <td class="{{'image'.$single_news->id}}" width="140">
                        <a class="fancybox" href="{{($single_news->image) ? (asset('img/news') . '/' . $single_news->image) : (asset('img/noimg.jpg'))}}">
                            <img src="{{($single_news->image) ? (asset('img/news') . '/' . $single_news->image) : (asset('img/noimg.jpg'))}}" width="60%" alt="">
                        </a>
                    </td>

                    <!-- title -->
                    <td class="{{'title'.$single_news->id}}">{{$single_news->title}}</td>

                    <!-- type -->
                    <td class="{{'type'.$single_news->id}}">{{$single_news->type}}</td>

                    <!-- description (with see more collapse) -->
                    <td class="{{'description'.$single_news->id}}" width="500">
                      <div class="content hideContent">
                        {{$single_news->description}}
                      </div>
                      <div class="show-more">
                        <a href="#">Show more</a>
                      </div></td>
                    </td>

                    <!-- date -->
                    <td class="{{'date'.$single_news->id}}">{{return_date_wo_time($single_news->date)}}</td>

                    <!-- actions -->
                    <td width="100">
                        <!-- Detail -->
                        <!-- <a href="#" class="detailButton" data-id="{{$single_news->id}}">
                          <i class="fas fa-eye green ml-1"></i>
                        </a> -->
                        <!-- Edit -->
                        <a href="#" class="editButton" data-id="{{$single_news->id}}">
                          <i class="fas fa-edit blue ml-1"></i>
                        </a>
                        <!-- Delete -->
                        <a href="#" class="deleteButton" data-id="{{$single_news->id}}">
                          <i class="fas fa-trash red ml-1"></i>
                        </a>
                    </td>
                  </tr>
                @endforeach
              @else
                <tr><td colspan="6"><h6 align="center">No news(s) found</h6></td></tr>
              @endif
            </tbody>
            <tfoot>

            </tfoot>
          </table>
        </div>
      <!-- /.card-body -->
      <div class="card-footer">
        @if(count($news) > 0)
        {{$news->appends(request()->except('page'))->links()}}
        @endif
      </div>
    </div>
  </div>
</div>

<!-- Create view -->
<div class="modal fade" id="addNewsModal" tabindex="-1" role="dialog" aria-labelledby="addNewsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addNewsModalLabel">Add New News</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{route('news.store')}}" enctype="multipart/form-data">
        @csrf
        @include('admin.news.news_master')
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Create</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit view -->
<div class="modal fade" id="editNewsModal" tabindex="-1" role="dialog" aria-labelledby="editNewsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editNewsModalLabel">Edit News</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="editForm" method="POST" action="{{route('news.update', 1)}}" enctype="multipart/form-data">
        <!-- hidden input -->
        @method('PUT')
        <input id="hidden" type="hidden" name="hidden">
        @csrf
        @include('admin.news.news_master')
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Detail view -->
<div class="modal fade" id="viewNewsModal" tabindex="-1" role="dialog" aria-labelledby="addNewsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">News Detail</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- TABS -->
            <ul class="nav nav-pills nav-fill" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                <a class="nav-link active bci" data-toggle="tab" href="#bci">Basic News Information</a>
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
              <!-- basic news info -->
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
                                <td class="">News Type</td>
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
<div class="modal fade" id="deleteNewsModal" tabindex="-1" role="dialog" aria-labelledby="deleteNewsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteNewsModalLabel">Delete News</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="deleteForm" method="POST" action="{{route('news.destroy', 1)}}">
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
    var news = "";

    // fetch news
    function fetch_news(id){
        $.ajax({
            url: '<?php echo(route("news.show", 0)); ?>',
            type: 'GET',
            data: {id: id},
            dataType: 'JSON',
            async: false,
            success: function (data) {
                news = data.news;
            }
        });
    }

    // create
    $('#add_news').on('click', function(){
        
    });

    // edit
    $('.editButton').on('click', function(){
        var id = $(this).data('id');
        fetch_news(id);
        $('#hidden').val(id);

        // image
        // un hide preview div
        $('#editForm .preview_wrapper').prop('hidden', false);
        // update preview image
        if(news.image){
          var src = `<?php echo(asset('img/news') . '/temp'); ?>`;
          src = src.replace('temp', news.image);
        }
        else{
          var src = `<?php echo(asset('img/noimg.jpg')); ?>`;
        }
        $('#editForm .preview_image').prop('src', src);

        // title
        $('#editForm .title').val(news.title ? news.title : '');

        // type
        // $('#editForm .type').val(news.type ? news.type : '');
        $('#editForm .type option[value="'+ news.type +'"]').prop('selected', true);

        // description
        $('#editForm .description').val(news.description ? news.description : '');

        // date
        $('#editForm .date').val(news.date ? news.date : '');
        
        $('#editNewsModal').modal('show');
    });

    // detail
    $('.detailButton').on('click', function(){
      $('.bci').trigger('click');
      var id = $(this).data('id');
      fetch_news(id);
      // var news = $(this).data('object');
      $('.name').html(news.name ? news.name : '');
      $('.contact_number').html(news.contact_number ? news.contact_number : '');
      $('.whatsapp_number').html(news.whatsapp_number);
      if(news.shop_keeper_picture){
          var shop_path = $(this).data('shopkeeper');
          $('.shop_keeper_picture').attr('src', shop_path);
      }
      else{
          var shop_path = '{{asset("img/logo.png")}}';
          $('.shop_keeper_picture').attr('src', shop_path);
      }
      $('.type').html(news.type ? news.type : '');
      $('.shop_name').html(news.shop_name ? news.shop_name : '');
      $('.shop_number').html(news.shop_number ? news.shop_number : '');
      $('.floor').html(news.floor ? news.floor : '');
      $('.area').html((news.market && news.market.area) ? news.market.area.name : '');
      $('.market').html(news.market ? news.market.name : '');
      if(news.shop_picture){
          var shop_path = $(this).data('shop');
          $('.shop_picture').attr('src', shop_path);
      }
      else{
          var shop_path = '{{asset("img/logo.png")}}';
          $('.shop_picture').attr('src', shop_path);
      }
      // image gallery work
      $('.gallery_wrapper').html('');
      if(news.news_images.length > 0){
          for(var i = 0; i < news.news_images.length; i++){
          $('.gallery_wrapper').append(`<div class="col-md-4 mb-3"><a target="_blank" href="{{asset('img/news_images')}}/`+news.news_images[i].location+`" class="col-md-12"><img class="col-md-12 shop_keeper_picture" src="{{asset('img/news_images')}}/`+news.news_images[i].location+`"></a><button class="btn btn_del_news_image" value="`+news.news_images[i].id+`" type="button"><i class="fas fa-trash red ml-1"></i></button></div>`);
          }
      }
      $('.status').html(news.status ? news.status : '');
      $('.visiting_days').html(news.visiting_days ? news.visiting_days : '');
      $('.cash_on_delivery').html(news.cash_on_delivery ? news.cash_on_delivery : '');
      $('.opening_balance').html(news.opening_balance ? ("Rs. " + news.opening_balance.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")) : '');
      $('.business_to_date').html(news.business_to_date ? ("Rs. " + news.business_to_date.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")) : '');
      $('.outstanding_balance').html(news.outstanding_balance ? ("Rs. " + news.outstanding_balance.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")) : '');
      // $('.special_discount').html(news.special_discount ? ("Rs. " + news.special_discount) : '');
      $('#viewNewsModal').modal('show');
    });

    // delete
    $('.deleteButton').on('click', function(){
      var id = $(this).data('id');
      $('#deleteForm').attr('action', "{{route('news.destroy', 1)}}");
      $('#deleteForm .hidden').val(id);
      $('#deleteNewsModalLabel').text('Delete News: ' + $('.name' + id).html() + "?");
      $('#deleteNewsModal').modal('show');
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