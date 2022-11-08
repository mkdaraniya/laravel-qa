@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"> <div class="d-flex align-items-center">
                    <h2>{{ $question->title }}</h2>
                    <div class="ml-auto">
                        <a href="{{route('questions.index')}}" class="btn btn-outline-secondary"> Back to all Questions</a>
                    </div>
                </div>
            </div>


                <div class="card-body">

                    @include('shared._vote',[
                            'model' => $question
                        ])
                        
                    <div class="col-xs-10" style="float:right;width: 90%;">
                        {!! $question->body_html !!}

                        <div class="row">
                            <div class="col-4"></div>
                            <div class="col-4"></div>
                            <div class="col-4">
                                @include('shared._auther',[
                                        'model' => $question,
                                        'label' => 'asked'
                                    ])
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    @include('answers._index',[
        'answers' => $question->answers,
        'answersCount' => $question->answers_count,    
    ])

    @include('answers._create')

</div>
@endsection
