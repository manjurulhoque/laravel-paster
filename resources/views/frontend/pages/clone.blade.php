@extends('frontend.layouts.app')

@section('title', 'Home')

@section('stylesheets')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
@endsection

@section('content')

    <div class="container content">
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        @include('frontend.includes._messages')
                        <form method="post" action="{{ route('paste.store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="content" class="font-weight-bold">New Paste</label>
                                <textarea name="contents" class="form-control" rows="15"
                                          id="content"
                                          autofocus>{{ $paste->content }}</textarea>
                            </div>
                            <h5>Paste Settings</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Syntax Highlighting:
                                            <small class="text-muted">(Optional)</small>
                                        </label>
                                        @php
                                            $selected = old('syntax');
                                        @endphp
                                        <select class="form-control select2" name="syntax">
                                            <option value="markup">Select language</option>
                                            <optgroup label="Popular Languages">
                                                @foreach($popular_syntaxes as $syntax)
                                                    <option value="{{$syntax->slug}}"
                                                            @if($selected == $syntax->slug) selected @endif>{{$syntax->name}}</option>
                                                @endforeach
                                            </optgroup>
                                            <optgroup label="All Languages">
                                                @foreach($syntaxes as $syntax)
                                                    <option value="{{$syntax->slug}}"
                                                            @if($selected == $syntax->slug) selected @endif>{{$syntax->name}}</option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Paste Expiration:
                                            <small class="text-muted">(Optional)</small>
                                        </label>
                                        @php
                                            $selected = old('expire');
                                        @endphp
                                        <select class="form-control" name="expire">
                                            <option value="N"
                                                    @if($selected == 'N') selected @endif>Never
                                            </option>
                                            <option value="SD"
                                                    @if($selected == 'SD') selected @endif>Self Destroy
                                            </option>
                                            <option value="10M"
                                                    @if($selected == '10M') selected @endif>10 Minutes
                                            </option>
                                            <option value="1H"
                                                    @if($selected == '1H') selected @endif>1 Hour
                                            </option>
                                            <option value="1D"
                                                    @if($selected == '1D') selected @endif>1 Day
                                            </option>
                                            <option value="1W"
                                                    @if($selected == '1W') selected @endif>1 Week
                                            </option>
                                            <option value="2W"
                                                    @if($selected == '2W') selected @endif>2 Weeks
                                            </option>
                                            <option value="1M"
                                                    @if($selected == '1M') selected @endif>1 Month
                                            </option>
                                            <option value="6M"
                                                    @if($selected == '6M') selected @endif>6 Months
                                            </option>
                                            <option value="1Y"
                                                    @if($selected == '1Y') selected @endif>1 Year
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Paste Status:
                                            <small class="text-muted">(Optional)</small>
                                        </label>
                                        @php
                                            $selected = old('status');
                                        @endphp
                                        <select class="form-control" name="status">
                                            <option value="1" @if($selected == 1) selected @endif>Public</option>
                                            <option value="2" @if($selected == 2) selected @endif>Unlisted</option>
                                            <option value="3" @if(!auth()->check()) disabled
                                                    @else  @if($selected == 3) selected @endif @endif>
                                                Private
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Paste Title :
                                            <small class="text-muted">(Optional)</small>
                                        </label>
                                        <input type="text" name="title" class="form-control"
                                               placeholder="Paste Title" value="{{old('title')}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="defaultUnchecked"
                                                   name="encrypt">
                                            <label class="custom-control-label" for="defaultUnchecked">Encrypt
                                                Paste</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success">Create New Paste</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        @if(!auth()->check())
                            <div class="alert alert-warning" role="alert">
                                <i class="fa fa-info-circle"></i>
                                You are currently not logged in, this means you can not edit or delete anything you
                                paste.
                                <a href="{{ route('register') }}">Sign Up</a> or
                                <a href="{{ route('login') }}">Login</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            @include('frontend.pastes._recent-pastes')
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>

    <script type="text/javascript">
        $(function () {
            $('.select2').select2({
                placeholder: "Select language",
                selectOnClose: true
            });
        })
    </script>
@endsection