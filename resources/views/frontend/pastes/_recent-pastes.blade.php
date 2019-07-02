<div class="col-md-3">
    @if(auth()->check())
        @if(!empty($my_recent_pastes))
            <div class="card mb-2 mt-2">
                <div class="card-header blue-grey"> My Recent Pastes</div>
                <ul class="list-group list-group-flush">
                    @forelse($my_recent_pastes as $paste)
                        <li class="list-group-item">
                            <i class="fa fa-paste blue-grey-text small"></i>
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
                                    | <i class="fa fa-eye blue-grey-text"></i> {{$paste->views}} | {{$paste->created_ago}}
                                </small>
                            </p>
                        </li>
                    @empty
                        <li class="list-group-item text-center">No results</li>
                    @endforelse
                </ul>
            </div>
        @endif
    @endif

    <div class="card paste_list">
        <div class="card-header blue-grey"> Recent Pastes </div>
        <ul class="list-group list-group-flush">
            @forelse($recent_pastes as $paste)
                <li class="list-group-item">
                    <i class="fa fa-paste blue-grey-text small"></i>
                    @if(!empty($paste->expire_time))
                        <i class="fa fa-clock-o text-warning small"></i>
                    @endif
                    <a href="{{$paste->url}}">{{$paste->title}}</a>
                    <p>
                        <small class="text-muted">
                            @if(isset($paste->language))
                                <a href="{{ $paste->language->url }}">{{$paste->language->name}}</a>
                            @else
                                {{$paste->syntax}}
                            @endif
                            | <i class="fa fa-eye blue-grey-text"></i> {{$paste->views}} | {{$paste->created_ago}}
                        </small>
                    </p>
                </li>
            @empty
                <li class="list-group-item text-center">No results</li>
            @endforelse
        </ul>
    </div>
</div>
