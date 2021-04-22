@extends('admin.layouts.master')

@section('content_header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1 class="m-0 text-dark"><i class="nav-icon fas fa-cogs"></i> Configuration Settings</h1>
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
    <form action="{{route('setting.store')}}" method="post" class="row signup_wallet" style="background-color:white;" enctype="multipart/form-data">
        @csrf

        @foreach($settings as $setting)
            <!-- main_logo -->
            <div class="form-group col-md-12 mb-2">
                <label><small>{{$setting->key}}: </small></label>
                <input type="text" name="{{$setting->key}}" class="form-control form-control-sm col-md-12" value="{{$setting->value}}">
            </div>
        @endforeach

        <!-- submit button -->
        <div class="col-md-10"></div>
        <div class="form-group col-md-2 text-center">
            <button type="submit" class="btn btn-primary form-control-sm"><small>Save Changes</small></button>
        </div>
    </form>
    <hr>
</div>


<script>
$(document).ready(function(){
    // global vars
    
    // persistent active sidebar
    var element = $('li a[href*="'+ window.location.pathname +'"]');
    element.parent().addClass('menu-open');
});
</script>

@endsection