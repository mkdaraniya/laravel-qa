@can('accept',$model)
<span class=" mt-2 fa fa-check col-md-12 {{ $model->status }} " onclick="event.preventDefault(); document.getElementById('accept-answer-{{ $model->id }}').submit()">
</span>
<form id="accept-answer-{{ $model->id }}" action="{{ route('answers.accept', ['answer' => $model->id]) }}" method="post" style="display:none">
    @csrf
</form>
@else
@if($model->is_best)
<span title="The question owner accepted this answer is best" class=" mt-2 fa fa-check col-md-12 {{ $model->status }} " onclick="event.preventDefault(); document.getElementById('accept-answer-{{ $model->id }}').submit()">
</span>
@endif
@endcan