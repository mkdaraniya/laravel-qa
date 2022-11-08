<div class="media">
    @include('shared._vote',[
    'model' => $answer
    ])
    <div class="media-body">
        {!! $answer->body_html !!}

        <div class="row">
            <div class="col-4">
                <div class="ml-auto">
                    @can('update', $answer)
                    <a href="{{ route('questions.answers.edit',[ 'question' => $question->id, 'answer' => $answer->id]) }}" class="btn btn-sm btn-outline-info">Edit</a>
                    @endcan

                    @can('delete', $answer)
                    <form action="{{route('questions.answers.destroy',[$question->id, $answer->id])}}" method="post" class="form-delete">
                        {{ method_field('DELETE')}}
                        @csrf
                        <button class="btn btn-sm btn-outline-danger" type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                    @endcan
                </div>
            </div>

            <div class="col-4">
                @include('shared._auther',[
                'model' => $answer,
                'label' => 'answered'
                ])
            </div>
        </div>

    </div>
</div>