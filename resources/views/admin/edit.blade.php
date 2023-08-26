@extends('adminLayout')
@section('content')
<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row pt-2 pb-2">
            @include('includes.bredcum',['title'=>'Edit Profile'])
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">User Update</div>
                        <hr>
                        <form method="POST" action="{{ route( 'user.update', $userdata->id ) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group row">
                                <label for="input-21" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                    <input type="text" value="{{ $userdata->name }}" name="name" class="form-control"
                                        id="input-21" placeholder="Enter Your Name">
                                    @error('name')
                                    <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input-23" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="text" value="{{ $userdata->email }}" class="form-control" id="input-23"
                                        name="email" placeholder="Enter Your Mobile Number">
                                    @error('email')
                                    <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input-23" class="col-sm-2 col-form-label">Mobile</label>
                                <div class="col-sm-10">
                                    <input type="text" value="{{ $userdata->phone }}" class="form-control is-invalid"
                                        id="validationServer03" name="phone" placeholder="Enter Your Mobile Number">
                                    @error('phone')
                                    <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input-23" class="col-sm-2 col-form-label">User Role</label>
                                <div class="col-sm-10">
                                    <select name="role_id" id="" class="form-control">
                                        @foreach($userRole as $role)
                                        <option {{ $role->serial == $userdata->role_id ? 'selected' : '' }}
                                            value="{{ $role->serial }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('role_id')
                                    <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input-24" class="col-sm-2 col-form-label">Old Password</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="input-24" name="old_password"
                                        placeholder="Enter Old Password">
                                    @error('old_password')
                                    <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input-24" class="col-sm-2 col-form-label">Password</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="input-24" name="password"
                                        placeholder="Enter Password">
                                    @error('password')
                                    <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input-25" class="col-sm-2 col-form-label">Confirm Password</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="input-25"
                                        name="password_confirmation" placeholder="Confirm Password">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input-25" class="col-sm-2 col-form-label">Upload Image</label>
                                <div class="col-sm-10">
                                    @if($userdata->image)
                                    <img src="/{{ $userdata->image }}" class="rounded" height="55px" alt="">
                                    @endif
                                    <input type="file" class="form-control" id="input-25" name="image">
                                    @error('image')
                                    <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-white px-5"><i class="icon-lock"></i>
                                        Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!--start overlay-->
        <div class="overlay"></div>
        <!--end overlay-->

    </div>
    <!-- End container-fluid-->

</div>
@endsection