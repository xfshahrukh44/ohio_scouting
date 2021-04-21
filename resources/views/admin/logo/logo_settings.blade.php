@extends('admin.layouts.master')

@section('content_header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1 class="m-0 text-dark">Logo Management</h1>
</div>
<!-- /.col -->
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
      <!-- <li class="breadcrumb-item"><a href="#">Admin</a></li>
      <li class="breadcrumb-item active">Zones</li> -->
  </ol>
</div>
<!-- /.col -->
</div>

@endsection

@section('content_body')

<div class="container col-md-12">
    <!-- wallet -->
    <form action="{{route('logo.store')}}" method="post" class="row signup_wallet" style="background-color:white;" enctype="multipart/form-data">
        @csrf

        <!-- main_logo -->
        <div class="form-group col-md-12 mb-5">
            <label for="">Main Logo</label>
            <div class="thumbnail col-md-2">
                <img src="{{($main_logo && $main_logo->image) ? (asset('img/logos') . '/' . $main_logo->image) : (asset('img/noimg.jpg'))}}" class="original_main_logo" alt="" width="60%">
            </div>
            <input type="file" name="main_logo" placeholder="Upload Main Logo" class="form-control image_input">
        </div>

        <!-- footer_logo -->
        <div class="form-group col-md-12 mb-5">
            <label for="">Footer Logo</label>
            <div class="thumbnail col-md-2">
                <img src="{{($footer_logo && $footer_logo->image) ? (asset('img/logos') . '/' . $footer_logo->image) : (asset('img/noimg.jpg'))}}" class="original_footer_logo" alt="" width="60%">
            </div>
            <input type="file" name="footer_logo" placeholder="Upload Footer Logo" class="form-control image_input">
        </div>

        <!-- favicon_logo -->
        <div class="form-group col-md-12 mb-5">
            <label for="">Favicon Logo</label>
            <div class="thumbnail col-md-2">
                <img src="{{($favicon_logo && $favicon_logo->image) ? (asset('img/logos') . '/' . $favicon_logo->image) : (asset('img/noimg.jpg'))}}" class="original_favicon_logo" alt="" width="60%">
            </div>
            <input type="file" name="favicon_logo" placeholder="Upload Favicon Logo" class="form-control image_input">
        </div>

        <!-- submit button -->
        <div class="col-md-10"></div>
        <div class="form-group col-md-2 text-center">
            <button type="submit" class="btn btn-primary form-control">Save</button>
        </div>
    </form>
    <hr>
</div>


<script>
$(document).ready(function(){
    // global vars
    
    // persistent active sidebar
    var element = $('li a[href*="'+ window.location.pathname +'"]');
    element.parent().parent().parent().addClass('menu-open');
    element.addClass('active');

    // on image_input click
    $('.image_input').on('change', function(){
        // console.log($(this)[0]);
        // console.log($(this).parent().find('img'));
        var input = ($(this))[0];
        var preview_target = $(this).parent().find('img');

        if (input.files && input.files[0]) {
            console.log('asd');
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

@endsection