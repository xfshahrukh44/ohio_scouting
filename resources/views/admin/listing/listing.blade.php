@extends('admin.layouts.master')

@section('content_header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1 class="m-0 text-dark"><i class="nav-icon fab fa-listing-hunt"></i> Listings</h1>
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

@endsection

@section('content_body')
<!-- Index view -->
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="card-tools">
            <button class="btn btn-success" id="add_item" data-toggle="modal" data-target="#addListingModal">
                <i class="fas fa-plus"></i>
            </button>
        </div>
        <!-- search bar -->
        <form action="{{route('search_listings')}}" class="form-wrapper">
          <div class="row">
              <!-- search bar -->
              <div class="topnav col-md-4">
                <input name="query" class="form-control" id="search_content" type="text" placeholder="Search..">
              </div>
              <!-- search button-->
              <button type="submit" class="btn btn-primary col-md-0 justify-content-start" id="search_button">
                <i class="fas fa-search"></i>
              </button>
          </div>
        </form>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <div class="col-md-12" style="overflow-x:auto;">
          <table id="example1" class="table table-bordered table-striped dataTable dtr-inline" role="grid" aria-describedby="example1_info">
            <thead>
              <tr role="row">
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Image</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Title</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">City</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Location</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Type</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Price</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Area</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Status</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Purpose</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Actions</th>
              </tr>
            </thead>
            <tbody>
              @if(count($listings) > 0)
                @foreach($listings as $listing)
                  <tr role="row" class="odd">
                    <!-- image (fancybox) -->
                    <td class="{{'image'.$listing->id}}" width="140">
                        <a class="fancybox" href="{{($listing->image) ? (asset('img/listings') . '/' . $listing->image) : (asset('img/noimg.jpg'))}}">
                            <img src="{{($listing->image) ? (asset('img/listings') . '/' . $listing->image) : (asset('img/noimg.jpg'))}}" width="60%" alt="">
                        </a>
                    </td>
                    <td class="{{'title'.$listing->id}}">{{$listing->title}}</td>
                    <td class="{{'city'.$listing->id}}">{{$listing->city}}</td>
                    <td class="{{'location'.$listing->id}}">{{$listing->location}}</td>
                    <td class="{{'type'.$listing->id}}">{{$listing->type}}</td>
                    <td class="{{'price'.$listing->id}}">{{$listing->price}}</td>
                    <td class="{{'area'.$listing->id}}">{{$listing->area}}</td>
                    <td class="{{'status'.$listing->id}}">{{$listing->status}}</td>
                    <td class="{{'purpose'.$listing->id}}">{{$listing->purpose}}</td>
                    <td>
                        <!-- Detail -->
                        <a href="#" class="detailButton" data-id="{{$listing->id}}">
                            <i class="fas fa-eye green ml-1"></i>
                        </a>
                        <!-- Edit -->
                        <a href="#" class="editButton" data-id="{{$listing->id}}">
                            <i class="fas fa-edit blue ml-1"></i>
                        </a>
                        <!-- Delete -->
                        <a href="#" class="deleteButton" data-id="{{$listing->id}}">
                            <i class="fas fa-trash red ml-1"></i>
                        </a>
                    </td>
                  </tr>
                @endforeach
              @else
                <tr><td colspan="10"><h6 align="center">No listing(s) found</h6></td></tr>
              @endif
            </tbody>
            <tfoot>

            </tfoot>
          </table>
        </div>
      <!-- /.card-body -->
      <div class="card-footer">
        @if(count($listings) > 0)
        {{$listings->appends(request()->except('page'))->links()}}
        @endif
      </div>
    </div>
  </div>
</div>

 <!-- Create view -->
<div class="modal fade" id="addListingModal" tabindex="-1" role="dialog" aria-labelledby="addListingModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addListingModalLabel">Add New Listing</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{route('listing.store')}}" enctype="multipart/form-data">
        @include('admin.listing.listing_master')
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" id="createButton">Create</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit view -->
<div class="modal fade" id="editListingModal" tabindex="-1" role="dialog" aria-labelledby="editListingModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editListingModalLabel">Edit Listing</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="editForm" method="POST" action="{{route('listing.update', 1)}}" enctype="multipart/form-data">
        <!-- hidden input -->
        @method('PUT')
        <input id="hidden" type="hidden" name="hidden">
        @include('admin.listing.listing_master')
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" id="createButton">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Detail view -->
<div class="modal fade" id="viewListingModal" tabindex="-1" role="dialog" aria-labelledby="addListingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Listing Detail</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- tables -->
            <div class="card-body row row overflow-auto col-md-12" style="height:36rem;">
                <!-- main info -->
                <div class="col-md-12" style="text-align: center;">
                    <!-- listing_image -->
                    <img class="image" src="{{asset('img/logo.png')}}" width="200">
                    <!-- title -->
                    <h3 class="title"></h3>
                    <hr style="color:gray;">
                </div>
                <!-- section 1 -->
                <div class="col-md-4">
                    <table class="table table-bordered table-striped">
                        <tbody id="table_row_wrapper">
                            <tr role="row" class="odd">
                                <td class="">City</td>
                                <td class="city"></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="">Type</td>
                                <td class="type"></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="">Location</td>
                                <td class="location"></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="">Area</td>
                                <td class="area"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- section 2 -->
                <div class="col-md-4">
                    <table class="table table-bordered table-striped">
                        <tbody id="table_row_wrapper">
                            <tr role="row" class="odd">
                                <td class="">Bathrooms</td>
                                <td class="bathrooms"></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="">Attach Bathrooms</td>
                                <td class="attach_bathrooms"></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="">Bedrooms</td>
                                <td class="bedrooms"></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="">Price</td>
                                <td class="price"></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="">Purpose</td>
                                <td class="purpose"></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="">Status</td>
                                <td class="status"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- section 3 -->
                <div class="col-md-4">
                    <table class="table table-bordered table-striped">
                        <tbody id="table_row_wrapper">
                            <tr role="row" class="odd">
                                <td class="">Description</td>
                                <td class="description"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
              <div class="gallery_wrapper col-md-12 row p-4">
              </div>
            </div>


            <div class="card-footer">
                <button class="btn btn-primary" data-dismiss="modal" style="float: right;">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete view -->
<div class="modal fade" id="deleteListingModal" tabindex="-1" role="dialog" aria-labelledby="deleteListingModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteListingModalLabel">Delete Listing</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="deleteForm" method="POST" action="{{route('listing.destroy', 1)}}">
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

    // global vars
    var listing = "";

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

    // fetch listing
    function fetch_listing(id){
        // fetch listing
        $.ajax({
            url: "<?php echo(route('listing.show', 1)); ?>",
            type: 'GET',
            async: false,
            data: {id: id},
            dataType: 'JSON',
            success: function (data) {
                listing = data.listing;
            }
        });
    }

    // delete_listing_image
    function delete_listing_image(listing_image_id, image_container){
        var temp_route = "php echo(route('listing_image.destroy', ':id'));";
        temp_route = temp_route.replace(':id', listing_image_id);
        $.ajax({
            url: temp_route,
            type: 'DELETE',
            data: {
            "_token": "{{ csrf_token() }}",
            listing_image_id: listing_image_id
            },
            dataType: 'JSON',
            async: false,
            success: function (data) {
            image_container.remove();
            }
        });
    }
  
    // create
    $('#add_listing').on('click', function(){
    });
    // edit
    $('.editButton').on('click', function(){
        var id = $(this).data('id');
        fetch_listing(id);
        $('#hidden').val(id);

        // image
        // un hide preview div
        $('#editForm .preview_wrapper').prop('hidden', false);
        // update preview image
        if(listing.image){
            var src = `<?php echo(asset('img/listings') . '/temp'); ?>`;
            src = src.replace('temp', listing.image);
        }
        else{
            var src = `<?php echo(asset('img/noimg.jpg')); ?>`;
        }
        $('#editForm .preview_image').prop('src', src);

        $('#editForm .title').val(listing.title);
        $('#editForm .city').val(listing.city);
        $('#editForm .type option[value="'+ (listing.type ? listing.type : '') +'"]').prop('selected', true);

        $('#editForm .location').val(listing.location);
        $('#editForm .area').val(listing.area);
        $('#editForm .bathrooms').val(listing.bathrooms);
        $('#editForm .attach_bathrooms').val(listing.attach_bathrooms);
        $('#editForm .bedrooms').val(listing.bedrooms);
        $('#editForm .price').val(listing.price);
        $('#editForm .purpose option[value="'+ (listing.purpose ? listing.purpose : '') +'"]').prop('selected', true);
        $('#editForm .status option[value="'+ (listing.status ? listing.status : '') +'"]').prop('selected', true);
        
        $('#editForm .description').val(listing.description);
        
        $('#editListingModal').modal('show');
    });
    // detail
    $('.detailButton').on('click', function(){
        var id = $(this).data('id');
        fetch_listing(id);

        // image
        if(listing.image){
            var src = `<?php echo(asset('img/listings/temp')); ?>`;
            src = src.replace('temp', listing.image);
        }
        else{
            var src = `<?php echo(asset('img/noimg.jpg')); ?>`;
        }
        $('#viewListingModal .image').prop('src', src);
        // title
        $('#viewListingModal .title').html(listing.title);
        // city
        $('#viewListingModal .city').html(listing.city);
        // type
        $('#viewListingModal .type').html(listing.type);
        // location
        $('#viewListingModal .location').html(listing.location);
        // area
        $('#viewListingModal .area').html(listing.area + ' Sq. Yd.');
        // title
        $('#viewListingModal .title').html(listing.title);
        // bathrooms
        $('#viewListingModal .bathrooms').html(listing.bathrooms);
        // attach_bathrooms
        $('#viewListingModal .attach_bathrooms').html(listing.attach_bathrooms);
        // bedrooms
        $('#viewListingModal .bedrooms').html(listing.bedrooms);
        // price
        $('#viewListingModal .price').html(listing.price);
        // purpose
        $('#viewListingModal .purpose').html(listing.purpose);
        // status
        $('#viewListingModal .status').html(listing.status);
        // description
        $('#viewListingModal .description').html(listing.description);

        // image gallery work
        $('.gallery_wrapper').html('');
        // if(listing.listing_images.length > 0){
        //     for(var i = 0; i < listing.listing_images.length; i++){
        //         $('.gallery_wrapper').append(`<div class="col-md-4 mb-3"><a target="_blank" href="{{asset('img/listing_images')}}/`+listing.listing_images[i].location+`" class="col-md-12"><img class="col-md-12 shop_keeper_picture" src="{{asset('img/listing_images')}}/`+listing.listing_images[i].location+`"></a><button class="btn btn_del_listing_image" value="`+listing.listing_images[i].id+`" type="button"><i class="fas fa-trash red ml-1"></i></button></div>`);
        //     }
        // }
        $('#viewListingModal').modal('show');
    });
    // delete
    $('.deleteButton').on('click', function(){
        var id = $(this).data('id');
        $('#deleteForm').attr('action', "{{route('listing.destroy', 1)}}");
        $('#deleteForm .hidden').val(id);
        $('#deleteListingModalLabel').text('Delete Listing: ' + $('.name' + id).html() + "?");
        $('#deleteListingModal').modal('show');
    });

    // on btn_del_listing_image click
    $('#viewListingModal').on('click', '.btn_del_listing_image', function(){
        var listing_image_id = $(this).val();
        var image_container = $(this).parent();
        delete_listing_image(listing_image_id, image_container);
    });
    // on .input_is_published click
    $('.input_is_published').on('click', function(){
        var id = $(this).data('id');
        toggle_is_published(id);
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