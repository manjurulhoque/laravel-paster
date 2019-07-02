@extends('frontend.layouts.app')

@section('title', 'Archives')

@section('content')

    <main>

        <div class="container content">
            <div class="row">
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header blue-grey"> Archive </div>
                        <div class="row m-2">
                            @foreach($syntaxes as $syntax)
                                <div class="col-md-4">
                                    <a class="" href="{{ route('archives.single', $syntax->slug) }}">{{$syntax->name}}</a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @include('frontend.pastes._recent-pastes')
            </div>
        </div>
    </main>

@endsection