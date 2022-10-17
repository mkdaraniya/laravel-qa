@extends('layouts.app')

@section('content')
<div class="row mt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h3>Edit answer for question: <strong>{{ $question->title }}</strong></h3>
                    </div>

                    <hr>

                    <form action="{{ route('questions.answers.update', [$question->id, $answer->id ]) }}" method="post">
                        @csrf 
                        @method('PATCH')
                        <div class="form-group">
                            <textarea name="body" class="form-control {{ $errors->has('body') ? 'is-invalid' : '' }}" id="" cols="30" rows="10">
                                {{ old('body',$answer->body)}}
                            </textarea>
                            @if ( $errors->has('body'))
                                <div class="invalid-feedback">
                                    <strong>
                                        {{$errors->first('body')}}
                                    </strong>
                                </div>
                            @endif
                        </div>

                        <div class="from-group mt-3">
                            <button type="submit" class="btn btn-lg btn-outline-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection