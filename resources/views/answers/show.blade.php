@extends('layout')
@section('header')
<div class="page-header">
        <h1>Answers / Show #{{$answer->id}}</h1>
        <form action="{{ route('answers.destroy', $answer->id) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Delete? Are you sure?')) { return true } else {return false };">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="btn-group pull-right" role="group" aria-label="...">
                <a class="btn btn-warning btn-group" role="group" href="{{ route('answers.edit', $answer->id) }}"><i class="glyphicon glyphicon-edit"></i> Edit</a>
                <button type="submit" class="btn btn-danger">Delete <i class="glyphicon glyphicon-trash"></i></button>
            </div>
        </form>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">

            <form action="#">
                <div class="form-group">
                    <label for="nome">ID</label>
                    <p class="form-control-static"></p>
                </div>
                <div class="form-group">
                     <label for="bot_id">BOT_ID</label>
                     <p class="form-control-static">{{$answer->bot_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="question_id">QUESTION_ID</label>
                     <p class="form-control-static">{{$answer->question_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="trigger">TRIGGER</label>
                     <p class="form-control-static">{{$answer->trigger}}</p>
                </div>
                    <div class="form-group">
                     <label for="answer">ANSWER</label>
                     <p class="form-control-static">{{$answer->answer}}</p>
                </div>
                    <div class="form-group">
                     <label for="next_question_id">NEXT_QUESTION_ID</label>
                     <p class="form-control-static">{{$answer->next_question_id}}</p>
                </div>
            </form>

            <a class="btn btn-link" href="{{ route('answers.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>

        </div>
    </div>

@endsection