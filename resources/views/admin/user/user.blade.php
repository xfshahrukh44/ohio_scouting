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
        <h1 class="m-0 text-dark"><i class="nav-icon fas fa-users"></i> Users</h1>
    </div>
</div>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

@endsection

@section('content_body')
<!-- Index view -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
              <div class="card-tools">
                <button class="btn btn-success" id="add_item" data-toggle="modal" data-target="#addUserModal">
                    <i class="fas fa-plus"></i>
                </button>
             </div>
             <!-- search bar -->
             <form action="{{route('search_users')}}" class="form-wrapper">
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
        <!-- status buttons -->
        <div class="col-md-12 row p-2 m-0">
            <!-- All -->
            <div class="form-group ml-1">
                <form action="{{route('user.index')}}">
                    @csrf
                    <button class="btn btn-primary form-control" type="submit" name="type" value="All">All ({{count_by_type("All")}})</button>
                </form>
            </div>
            <!-- Realtor -->
            <div class="form-group ml-1">
                <form action="{{route('index_realtors')}}">
                    @csrf
                    <button class="btn btn-primary form-control" type="submit" name="type" value="Realtor">Realtors ({{count_by_type("Realtor")}})</button>
                </form>
            </div>
            <!-- Cleaner -->
            <div class="form-group ml-1">
                <form action="{{route('index_cleaners')}}">
                    @csrf
                    <button class="btn btn-primary form-control" type="submit" name="type" value="Cleaner">Cleaners ({{count_by_type("Cleaner")}})</button>
                </form>
            </div>
        </div>
         <!-- /.card-header -->
         <div class="card-body">
            <div class="col-md-12" style="overflow-x:auto;">
                <table id="example1" class="table table-bordered table-striped dataTable dtr-inline" role="grid" aria-describedby="example1_info">
                    <thead>
                        <tr role="row">
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Full Name: activate to sort column ascending">Full Name</th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Email Address: activate to sort column ascending">Email Address</th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Baskets: activate to sort column ascending">Type</th>
                            <th class="sorting" tabindex="1" aria-controls="example1" rowspan="1" colspan="1" aria-label="Registration Date: activate to sort column ascending">Registration Date</th>
                            <th class="sorting" tabindex="1" aria-controls="example1" rowspan="1" colspan="1" aria-label="Actions: activate to sort column ascending">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @if(count($users) > 0)
                        @foreach($users as $user)
                        <tr role="row" class="odd">
                            <!-- name -->
                            <td class="{{'name'.$user->id}}">{{$user->name}}</td>

                            <!-- email -->
                            @if($user->email == null)
                                <td class="{{'email'.$user->id}}">---</td>
                            @else
                                <td class="{{'email'.$user->id}}">{{$user->email}}</td>
                            @endif

                            <!-- staff's type -->
                            <td class="{{'type'.$user->id}}">{{$user->type}}</td>

                            <!-- registration date -->
                            @if($user->created_at == null)
                            <td class="{{'created_at'.$user->id}}">---</td>
                            @else
                            <td class="{{'created_at'.$user->id}}">{{return_date($user->created_at)}}</td>
                            @endif

                            <!-- actions -->
                            <td>
                                <!-- View Profile -->
                                <a href="#" class="viewProfileButton" data-id="{{$user->id}}" data-route="{{route('user.show',$user->id)}}">
                                    <i class="fas fa-user green ml-1"></i>
                                </a>
                                <!-- Edit -->
                                <a href="#" class="editButton" data-id="{{$user->id}}">
                                    <i class="fas fa-edit blue ml-1"></i>
                                </a>
                                <!-- Delete -->
                                <a href="#" class="deleteButton" data-id="{{$user->id}}">
                                    <i class="fas fa-trash red ml-1"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        @else
                            <tr><td colspan="5"><h6 align="center">No record(s) found</h6></td></tr>
                        @endif
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
         @if(count($users) > 0)
         {{$users->appends(request()->except('page'))->links()}}
         @endif
     </div>
 </div>
</div>
</div>

<!-- Profile view -->
<div class="modal fade" id="viewUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Profile</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="card-body" style="overflow-x:auto;">
                <img class="profile" src="{{asset('dist/img/avatar.png')}}" width="150" style="position: relative; left:33%;">
                <hr style="color:gray;">
                <table class="table table-bordered table-striped">
                    <tbody id="table_row_wrapper">
                        <tr role="row" class="odd">
                            <td class="">Full Name</td>
                            <td class="fullname"></td>
                        </tr>
                        <tr role="row" class="odd">
                            <td class="">Email Address</td>
                            <td class="emailAddress"></td>
                        </tr>
                        <tr role="row" class="odd">
                            <td class="">Type</td>
                            <td class="type"></td>
                        </tr>
                        <tr role="row" class="odd">
                            <td class="">Registration Date</td>
                            <td class="registrationDate"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary" data-dismiss="modal" style="float: right;">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Create view -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{route('user.store')}}">
                @include('admin.user.user_master')
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="createButton">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit view -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form id="editForm" method="POST" action="{{route('user.update', 1)}}">
            <!-- hidden input -->
            @method('PUT')
            <input id="hidden" type="hidden" name="hidden">
            @include('admin.user.user_master')
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="updateButton">Update</button>
            </div>
        </form>
    </div>
</div>
</div>

<!-- Delete view -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="deleteUserModalLabel">Delete User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form id="deleteForm" method="POST" action="{{route('user.destroy', 1)}}">
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
        //*** datatables ***//
        // $('#example1').dataTable({
        //     "bPaginate": false,
        //     "bLengthChange": false,
        //     "bFilter": true,
        //     "bInfo": false,
        //     "searching":false
        // });

        // persistent active sidebar
        var element = $('li a[href*="'+ window.location.pathname +'"]');
        element.parent().addClass('menu-open');

        //*** View Profile ***//
        $('.viewProfileButton').on('click', function(){
            var id = $(this).data('id');
            var url = $(this).data('route');
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                success: function(response){
                    $('#viewUserModal').modal('show');
                    $('.fullname').html(response.user.name);
                    if(response['profile_picture'] == null){
                        $("#viewUserModal .profile").attr("src","{{asset('dist/img/avatar.png')}}");
                    }
                    else{
                        $('#viewUserModal .profile').attr("src",response['profile_picture']);
                    }
                    if(response.user.email == null){
                        $('#viewUserModal .emailAddress').html('---');
                    }
                    else{
                        $('#viewUserModal .emailAddress').html(response.user.email);
                    }
                    if(response.user.type == null){
                        $('#viewUserModal .type').html('---');
                    }
                    else{
                        $('#viewUserModal .type').html(response.user.type);
                    }
                    if(response.user.created_at == null){
                        $('#viewUserModal .registrationDate').html('---');
                    }
                    else{
                        $('#viewUserModal .registrationDate').html($('.created_at' + id).html());
                    }
                }
            });
        });
        // create
        $('#add_item').on('click', function(){
        });
        //*** edit ***//
        $('.editButton').on('click', function(){
            var id = $(this).data('id');
            $('#editForm').attr('action', "{{route('user.update', 1)}}");
            $('#hidden').val(id);
            $('#editForm .name').val($('.name' + id).html());
            $('#editForm .email').val($('.email' + id).html());
            $('#editForm .type').val($('.type' + id).html());
            $('#editUserModal').modal('show');
        });
        // delete
        $('.deleteButton').on('click', function(){
            var id = $(this).data('id');
            $('#deleteForm').attr('action', "{{route('user.destroy', 1)}}");
            $('#deleteForm .hidden').val(id);
            $('#deleteUserModalLabel').text('Delete User: ' + $('.name' + id).html() + "?");
            $('#deleteUserModal').modal('show');
        });
    });
</script>
@endsection('content_body')