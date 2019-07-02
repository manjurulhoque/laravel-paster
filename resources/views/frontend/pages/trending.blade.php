@extends('frontend.layouts.app')

@section('title', 'Trending')

@section('content')

    <main>

        <div class="container content">
            <div class="row">
                <div class="col-md-9">
                    @include('frontend.includes._messages')

                    <div class="card p-1">

                        <ul class="nav nav-pills nav-fill" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="today-tab" data-toggle="tab" href="#today" role="tab"
                                   aria-controls="today"
                                   aria-selected="true">Today</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="week-tab" data-toggle="tab" href="#week" role="tab"
                                   aria-controls="week"
                                   aria-selected="false">This Week</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="month-tab" data-toggle="tab" href="#month" role="tab"
                                   aria-controls="month"
                                   aria-selected="false">This Month</a>
                            </li>
                        </ul>
                        <hr/>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="today" role="tabpanel"
                                 aria-labelledby="today-tab">
                                <ul class="list-group list-group-flush">
                                    @forelse($trending_today as $paste)
                                        <li class="list-group-item"><i
                                                    class="fa fa-paste blue-grey-text small"></i> @if(!empty($paste->password))
                                                <i class="fa fa-lock pink-text small"></i>@endif @if(!empty($paste->expire_time))
                                                <i class="fa fa-clock-o text-warning small"></i> @endif <a
                                                    href="{{$paste->url}}">{{$paste->title}}</a>
                                            <p>
                                                <small class="text-muted">@if(isset($paste->language)) {{$paste->language->name}} @else{{$paste->syntax}}@endif
                                                    | <i class="fa fa-eye blue-grey-text"></i> {{$paste->views}}
                                                    | {{$paste->created_ago}}</small>
                                            </p>
                                        </li>
                                    @empty
                                        <li class="list-group-item">No results</li>
                                    @endforelse
                                </ul>
                            </div>
                            <div class="tab-pane fade show" id="week" role="tabpanel" aria-labelledby="week-tab">
                                <ul class="list-group list-group-flush">
                                    @forelse($trending_week as $paste)
                                        <li class="list-group-item"><i
                                                    class="fa fa-paste blue-grey-text small"></i> @if(!empty($paste->password))
                                                <i class="fa fa-lock pink-text small"></i>@endif @if(!empty($paste->expire_time))
                                                <i class="fa fa-clock-o text-warning small"></i> @endif <a
                                                    href="{{$paste->url}}">{{$paste->title}}</a>
                                            <p>
                                                <small class="text-muted">@if(isset($paste->language)) {{$paste->language->name}} @else{{$paste->syntax}}@endif
                                                    | <i class="fa fa-eye blue-grey-text"></i> {{$paste->views}}
                                                    | {{$paste->created_ago}}</small>
                                            </p>
                                        </li>
                                    @empty
                                        <li class="list-group-item">No results</li>
                                    @endforelse
                                </ul>
                            </div>
                            <div class="tab-pane fade show" id="month" role="tabpanel" aria-labelledby="month-tab">
                                <ul class="list-group list-group-flush">
                                    @forelse($trending_month as $paste)
                                        <li class="list-group-item"><i
                                                    class="fa fa-paste blue-grey-text small"></i> @if(!empty($paste->password))
                                                <i class="fa fa-lock pink-text small"></i>@endif @if(!empty($paste->expire_time))
                                                <i class="fa fa-clock-o text-warning small"></i> @endif <a
                                                    href="{{$paste->url}}">{{$paste->title}}</a>
                                            <p>
                                                <small class="text-muted">@if(isset($paste->language)) {{$paste->language->name}} @else{{$paste->syntax}}@endif
                                                    | <i class="fa fa-eye blue-grey-text"></i> {{$paste->views}}
                                                    | {{$paste->created_ago}}</small>
                                            </p>
                                        </li>
                                    @empty
                                        <li class="list-group-item">No results</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @include('frontend.pastes._recent-pastes')
            </div>
        </div>
    </main>

@endsection