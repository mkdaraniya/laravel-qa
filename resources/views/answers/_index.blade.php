@if($answersCount > 0 )

<div class="row mt-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h2>{{ $answersCount . " ". str_plural('Answer', $answersCount) }}</h2>
                </div>

                @include('layouts._messages')

                @foreach ($answers as $answer)
                
                    @include('answers._answer')

                @endforeach
            </div>
        </div>
    </div>
</div>
@else

<div class="alert alert-warning">
                        <strong>Sorry</strong>There are not question available.
                    </div>

@endif

