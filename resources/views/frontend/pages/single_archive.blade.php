@extends('frontend.layouts.app')

@section('title', 'Archive')

@section('content')

    <main>
        <div class="container content">
            <div class="row">
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header blue-grey"> Archive - {{$syntax->name}} </div>
                        <ul class="list-group list-group-flush">
                            @forelse($pastes as $paste)
                                <li class="list-group-item">
                                    <i class="fa fa-paste blue-grey-text small"></i>
                                    @if(!empty($paste->password))
                                        <i class="fa fa-lock pink-text small"></i>
                                    @endif
                                    @if(!empty($paste->expire_time))
                                        <i class="fa fa-clock-o text-warning small"></i>
                                    @endif
                                    <a href="{{$paste->url}}">{{$paste->title}}</a>
                                    <p>
                                        <small class="text-muted">
                                            @if(isset($paste->language))
                                                {{$paste->language->name}}
                                            @else
                                                {{$paste->syntax}}
                                            @endif
                                            | <i class="fa fa-eye blue-grey-text"></i> {{$paste->views}}
                                            | {{$paste->created_ago}}
                                        </small>
                                    </p>
                                </li>
                            @empty
                                <li class="list-group-item text-center">No results</li>
                            @endforelse
                        </ul>
                        @if(auth()->check())
                            <div class=" mx-auto mt-3"> {{$pastes->links()}} </div>@else
                            <div class="alert alert-warning" role="alert">
                                <i class="fa fa-info-circle"></i> You are currently not logged in}}
                                , this means you can only see limited pastes.
                                <a href="{{url('register')}}">Sign Up</a> or
                                <a href="{{url('login')}}">Login</a></div>
                        @endif
                    </div>
                </div>
                @include('frontend.pastes._recent-pastes')
            </div>
        </div>
    </main>

@endsection