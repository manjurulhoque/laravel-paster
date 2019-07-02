@extends('frontend.layouts.app')

@section('title', 'My Pastes')

@section('content')

    <main>
        <div class="container content">
            <div class="row " data-wow-delay="0.2s">
                <div class="col-md-9">
                    @include('frontend.includes._messages')
                    <div class="card">
                        <div class="card-header blue-grey"> My Pastes</div>
                        <ul class="list-group list-group-flush">
                            @forelse($pastes as $paste)
                                <li class="list-group-item">
                                    <div class="pull-left">
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
                                                    <a href="{{$paste->language->url}}">{{$paste->language->name}}</a>
                                                @else
                                                    {{$paste->syntax}}
                                                @endif
                                                | <i class="fa fa-eye blue-grey-text"></i> {{$paste->views}}
                                                | {{$paste->created_ago}}
                                            </small>
                                        </p>
                                    </div>
                                    <div class="pull-right">
                                        <a href="{{url('paste/'.$paste->slug.'/edit')}}" class="badge badge-info mr-2">
                                            <i class="fa fa-edit"></i> Edit</a>
                                        <a href="{{url('paste/'.$paste->slug.'/delete')}}" class="badge badge-danger" onclick="return confirm('Are you sure?')">
                                            <i class="fa fa-trash"></i> Delete
                                        </a>
                                    </div>
                                </li>
                            @empty
                                <li class="list-group-item">No results</li>
                            @endforelse
                        </ul>
                        <div class=" mx-auto mt-3"> {{$pastes->links()}} </div>
                    </div>
                </div>
                @include('frontend.pastes._recent-pastes')
            </div>

        </div>

    </main>

@endsection