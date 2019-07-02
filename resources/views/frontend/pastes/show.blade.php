@extends('frontend.layouts.app')

@section('title', $paste->title)

@section('stylesheets')

    <link rel="stylesheet" href="{{ asset('css/prism-okadia.css') }}">

@endsection

@section('content')

    <main>
        <div class="container content">
            <div class="row">
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-body">
                            @include('frontend.includes._messages')
                            <div class="media">
                                @if(isset($paste->user))
                                    <img class="mr-3 mb-3 rounded-circle img-fluid" src="{{$paste->user->avatar}}"
                                         alt="avatar" style="height: 60px">
                                @else
                                    <img class="mr-3 mb-3 rounded-circle img-fluid"
                                         src="{{ asset('images/guest.png') }}" alt="avatar"
                                         style="height: 60px">
                                @endif

                                <div class="media-body">
                                    <h5 class="mt-0">
                                        <i class="fa fa-paste blue-grey-text small"></i>
                                        @if(!empty($paste->expire_time))
                                            <i class="fa fa-clock-o text-warning small"></i>
                                        @endif
                                        {{$paste->title}}
                                    </h5>
                                    <p class="text-muted small">
                                        <i class="fa fa-user"></i>
                                        @if(isset($paste->user))
                                            <a href="{{$paste->user->url}}"> {{$paste->user->name}} </a>
                                        @else
                                            Guest
                                        @endif
                                        <i class="fa fa-eye ml-2"></i> {{$paste->views}}
                                        <i class="fa fa-calendar ml-2"> {{$paste->created_at->format('jS M, Y')}}</i>
                                        @if($paste->status == 2)
                                            <span class="badge badge-warning">Unlisted</span>
                                        @elseif($paste->status == 3)
                                            <span class="badge badge-danger">Private</span>
                                        @endif
                                    </p>
                                </div>
                                @if(auth()->check())
                                    @if($paste->user_id == auth()->user()->id)
                                        <a href="{{url('paste/'.$paste->slug.'/edit')}}" class="badge badge-info mr-2">
                                            <i class="fa fa-edit"></i> Edit</a>
                                        <a href="{{url('paste/'.$paste->slug.'/delete')}}"
                                           class="badge badge-danger" onclick="return confirm('Are you sure?')">
                                            <i class="fa fa-trash"></i> Delete
                                        </a>
                                    @endif
                                @endif
                            </div>
                            @if(auth()->check())
                                @if($paste->user_id == auth()->user()->id)
                                    <p class="text-muted text-center">
                                        <small>This is one of your paste</small>
                                    </p>
                                @endif
                            @endif
                            <div class="card">
                                <div class="card-header">
                                    <span class="badge badge-light">{{strtoupper($paste->syntax)}}</span>
                                    <small class="text-muted">{{$paste->content_size}} KB</small>
                                    <div class="pull-right">
                                        <a class="buttonsm" data-toggle="modal"
                                           data-target="#shareModal">share
                                        </a>
                                        <a href="{{ route('paste.raw', $paste->slug) }}"
                                           class="buttonsm">raw
                                        </a>
                                        <a href="{{ route('paste.download', $paste->slug) }}"
                                           class="buttonsm">download
                                        </a>
                                        <a href="{{ route('paste.clone', $paste->slug) }}"
                                           class="buttonsm">clone
                                        </a>
                                        <a class="buttonsm" data-toggle="modal"
                                           data-target="#embedModal">
                                            embed
                                        </a>
                                        @if(auth()->check())
                                            <a class="buttonsm" data-toggle="modal"
                                               data-target="#reportModal">report
                                            </a>
                                        @else
                                            <a class="buttonsm" href="{{route('login')}}">report</a>
                                        @endif
                                        <a href="{{ route('paste.print', $paste->slug) }}"
                                           class="buttonsm">print
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <pre class="line-numbers language-{{$paste->syntax}}" id="pre">
                                            <code class="language-{{$paste->syntax}}" id="paste_content">
                                             {{ html_entity_decode($paste->content) }}
                                          </code>
                                     </pre>
                                </div>
                            </div>

                            <div class="form-group mt-3 mb-3">
                                <small class="text-muted">To share this paste please copy this url and send to your
                                    friends
                                </small>

                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-md btn-blue-grey m-0 px-3" id="copy-to-clipboard"
                                                type="button" data-clipboard-target="#url">Copy
                                        </button>
                                    </div>
                                    <input type="text" class="form-control" value="{{$paste->url}}" readonly id="url">
                                </div>
                            </div>

                            <div class="card mt-3">
                                <div class="card-header"> Raw Paste Data</div>
                                <div class="card-body">
                                    <textarea class="form-control" rows="10"
                                              id="raw_content">{{ html_entity_decode($paste->content) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                @include('frontend.pastes._recent-pastes')
                @include('frontend.includes._modals')
            </div>
        </div>
    </main>

@endsection

@section('scripts')

    <script src="{{ asset('plugins/clipboardjs/clipboard.min.js') }}"></script>
    <script src="{{ asset('js/prism.js') }}"></script>
    <script src="{{ asset('js/prisma-custom.js') }}"></script>

    <script type="text/javascript">
        let clipboard = new ClipboardJS('#copy-to-clipboard');

        clipboard.on('success', function (e) {
            $(e.trigger).text("Copied!");
            e.clearSelection();
            setTimeout(function () {
                $(e.trigger).text("Copy");
            }, 5000);
        });

        clipboard.on('error', function (e) {
            $(e.trigger).text("Can't in Safari");
            setTimeout(function () {
                $(e.trigger).text("Copy");
            }, 2500);
        });

        // embed clipboard
        let embed_clipboard = new ClipboardJS('#embed-clipboard');

        embed_clipboard.on('success', function (e) {
            $(e.trigger).text("Copied!");
            e.clearSelection();
            setTimeout(function () {
                $(e.trigger).text("Copy");
            }, 5000);
        });

        embed_clipboard.on('error', function (e) {
            $(e.trigger).text("Can't in Safari");
            setTimeout(function () {
                $(e.trigger).text("Copy");
            }, 2500);
        });
    </script>

@endsection