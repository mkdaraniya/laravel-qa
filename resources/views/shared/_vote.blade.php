
@if($model instanceof App\Models\Question)
    @php 
        $name = 'question';
        $firstURISegment = 'questions';
    @endphp
@elseif($model instanceof App\Models\Answer)
@php 
        $name = 'answer';
        $firstURISegment = 'answers';
    @endphp
@endif

@php
$formId = $name."-".$model->id;
$formAction = "/{$firstURISegment}/$model->id/vote";
@endphp
<div class="col-xs-1 vote-controls" style="display:table-cell; font-size: 30px; color:#606060; text-align: center;float:left;width:7%;">
    <span title="this {{ $name }} is useful" 
    class="fa fa-caret-up col-md-12 vote-up {{ Auth::guest() ? 'off' : '' }} " 
    onclick="event.preventDefault(); document.getElementById('up-vote-{{ $formId }}').submit()"></span>

    <form id="up-vote-{{ $name }}-{{ $model->id }}" action="{{ $formAction }}" method="post" style="display:none">
        @csrf
        <input type="hidden" name="vote" value="1" />
    </form>
    <span class="col-md-12 votes-count">{{ $model->votes_count }}</span>
    <!-- Number goes here -->
    <span class="fa fa-caret-down col-md-12 vote-down {{ Auth::guest() ? 'off' : '' }} " onclick="event.preventDefault(); document.getElementById('down-vote-{{$name}}-{{ $model->id }}').submit()"></span>
    <form id="down-vote-{{ $formId }}" action="{{ $formAction }}" method="post" style="display:none">
        @csrf
        <input type="hidden" name="vote" value="-1" />
    </form>

    @if($model instanceof App\Models\Question)


        @include('shared._favorite',[
            'model' => $model    
        ])
    @elseif($model instanceof App\Models\Answer)
    
    @include('shared._accept',[
            'model' => $model    
        ])
    @endif
</div>