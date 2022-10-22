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
                    <div class="col-xs-1 vote-controls" style="display:table-cell; font-size: 30px; color:#606060; text-align: center;float:left;width:7%;">
                        <span title="this question is useful" 
                            class="fa fa-caret-up col-md-12 vote-up {{ Auth::guest() ? 'off' : '' }} "
                            onclick="event.preventDefault(); document.getElementById('up-vote-question-{{ $question->id }}').submit()"
                            ></span>
                            <form id="up-vote-question-{{ $question->id }}" action="/questions/{{ $question->id }}/vote" method="post" style="display:none" >
                                @csrf
                                <input type="hidden" name="vote" value="1" />
                            </form>
                        <span class="col-md-12 votes-count">{{ $question->votes_count }}</span>
                        <!-- Number goes here -->
                        <span class="fa fa-caret-down col-md-12 vote-down {{ Auth::guest() ? 'off' : '' }} " 
                        onclick="event.preventDefault(); document.getElementById('down-vote-question-{{ $question->id }}').submit()"
                        ></span> 
                        <form id="down-vote-question-{{ $question->id }}" action="/questions/{{ $question->id }}/vote" method="post" style="display:none" >
                            @csrf
                            <input type="hidden" name="vote" value="-1" />
                        </form>

                        <span class="favorite mt-2 favorited fa fa-star col-md-12 vote-down" onclick="event.preventDefault(); document.getElementById('favorite-question-{{ $question->id }}').submit()"></span>
                        <span class=" favorites-count  {{Auth::guard() ? 'off' : ($question->is_favorited ? 'favorited' : '') }}" >{{$question->favorites_count}}</span>
                        <form id="favorite-question-{{ $question->id }}" action="/questions/{{ $question->id }}/favorites" method="post" style="display:none" >
                            @csrf
                            @if($question->is_favorited)
                                @method('DELETE')
                            @endif
                        </form>
                    </div>
                    <div class="col-xs-10" style="float:right;width: 90%;">
                        {!! $question->body_html !!}

                        <div class="float-right">
                            <span class="text-muted">
                                Question {{ $question->created_date}}
                            </span>

                            <div class="media">
                                <a href="{{ $question->user->url }}" class="pr-2">
                                    <img src="{{$question->user->avatar }}" alt="">
                                </a>
                                <div class="media-body mt-1">
                                    <a href="{{ $question->user->url }}">{{ $question->user->name }}/</a>
                                </div>
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
