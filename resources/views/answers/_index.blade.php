<div class="row mt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h2>{{ $answersCount . " ". str_plural('Answer', $answersCount) }}</h2>
                    </div>

                    @include('layouts._messages')

                    @foreach ($answers as $answer)
                        <div class="media">
                        <div class="col-xs-1 vote-controls" style="display:table-cell; font-size: 30px; color:#606060; text-align: center;float:left;width:7%;">
                            <span title="this question is useful" class="fa fa-caret-up col-md-12 vote-up"></span>
                            <span class="col-md-12 votes-count">12</span>
                            <!-- Number goes here -->
                            <span class="fa fa-caret-down col-md-12 vote-down" ></span>
                            <span class=" mt-2 fa fa-check col-md-12 {{ $answer->status }} " ></span>
                            <span class=" favorites-count" >123</span>
                        </div>
                            <div class="media-body">
                                {!! $answer->body_html !!}

                                <div class="row">
                                    <div class="col-4">
                                        <div class="ml-auto">
                                            @can('update', $answer)
                                            <a href="{{ route('questions.answers.edit',[ $question->id, $answer->id]) }}" class="btn btn-sm btn-outline-info">Edit</a>
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

                                        <span class="text-muted">
                                            Answered {{ $answer->created_date}}
                                        </span>

                                        <div class="media">
                                            <a href="{{ $answer->user->url }}" class="pr-2">
                                                <img src="{{$answer->user->avatar }}" alt="">
                                            </a>
                                            <div class="media-body mt-1">
                                                <a href="{{ $answer->user->url }}">{{ $answer->user->name }}/</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    @endforeach
                </div>
            </div>
        </div>
    </div>
