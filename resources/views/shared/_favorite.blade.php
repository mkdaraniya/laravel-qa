
    <span class="favorite mt-2 favorited fa fa-star col-md-12 vote-down" onclick="event.preventDefault(); document.getElementById('favorite-question-{{ $model->id }}').submit()"></span>
    <span class=" favorites-count  {{Auth::guard() ? 'off' : ($model->is_favorited ? 'favorited' : '') }}">{{$model->favorites_count}}</span>
    <form id="favorite-{{$name}}-{{ $model->id }}" action="/{{$firstURISegment}}/{{ $model->id }}/favorites" method="post" style="display:none">
        @csrf
        @if($model->is_favorited)
        @method('DELETE')
        @endif
    </form>