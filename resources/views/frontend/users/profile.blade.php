@extends('frontend.layouts.app')

@section('title', 'Profile')

@section('content')

    <main>
        <div class="container content">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="card">
                        @include('frontend.includes._messages')
                        <h5 class="card-header blue-grey">
                            <strong>Profile</strong>
                        </h5>

                        <div class="card-body  pt-0">
                            <form class="p-3" method="post" enctype="multipart/form-data"
                                  action="{{ route('my.profile.update') }}">
                                @csrf
                                <label>Username</label>
                                <input type="text" id="defaultContactFormName" class="form-control mb-4"
                                       value="{{$user->name}}" disabled>
                                <label>E-Mail address</label>
                                <input type="email" id="defaultContactFormEmail" class="form-control mb-4"
                                       value="{{$user->email}}" disabled>
                                <label>Avatar</label>
                                <br/>
                                <img src="{{$user->avatar}}" id="avatar"
                                     class="rounded-circle z-depth-1-half avatar-pic mb-4" height="80" width="80">
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="avatar" id="inputGroupFile01"
                                               onchange="loadFile(this,'avatar')"
                                               aria-describedby="inputGroupFileAddon01">
                                        <label class="custom-file-label"
                                               for="inputGroupFile01">Choose file
                                        </label>
                                    </div>
                                </div>
                                <label>About Me</label>
                                <textarea name="about"
                                          class="form-control mb-4">{{ old('about', $user->about )}}</textarea>

                                <label>Current Password</label>
                                <input type="password" name="current_password" class="form-control mb-4">
                                <label>Password</label>
                                <input type="password" name="new_password" class="form-control mb-4">
                                <label>Confirm Password</label>
                                <input type="password" name="confirm_new_password" class="form-control mb-4">

                                <button class="btn btn-blue-grey darken-5 btn-block"
                                        type="submit">Update
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection