@extends('layout')
@section('css')
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/css/bootstrap-datepicker.css" rel="stylesheet">
@endsection
@section('header')
    <div class="page-header">
        <h1><i class="glyphicon glyphicon-edit"></i> Answers / Edit #{{$answer->id}}</h1>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            <form action="{{ route('answers.update', $answer->id) }}" method="POST">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group @if($errors->has('bot_id')) has-error @endif">
                       <label for="bot_id-field">Bot_id</label>
                    <input type="text" id="bot_id-field" name="bot_id" class="form-control" value="{{ is_null(old("bot_id")) ? $answer->bot_id : old("bot_id") }}"/>
                       @if($errors->has("bot_id"))
                        <span class="help-block">{{ $errors->first("bot_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('question_id')) has-error @endif">
                       <label for="question_id-field">Question_id</label>
                    <input type="text" id="question_id-field" name="question_id" class="form-control" value="{{ is_null(old("question_id")) ? $answer->question_id : old("question_id") }}"/>
                       @if($errors->has("question_id"))
                        <span class="help-block">{{ $errors->first("question_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('trigger')) has-error @endif">
                       <label for="trigger-field">Trigger</label>
                    <input type="text" id="trigger-field" name="trigger" class="form-control" value="{{ is_null(old("trigger")) ? $answer->trigger : old("trigger") }}"/>
                       @if($errors->has("trigger"))
                        <span class="help-block">{{ $errors->first("trigger") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('answer')) has-error @endif">
                       <label for="answer-field">Answer</label>
                    <input type="text" id="answer-field" name="answer" class="form-control" value="{{ is_null(old("answer")) ? $answer->answer : old("answer") }}"/>
                       @if($errors->has("answer"))
                        <span class="help-block">{{ $errors->first("answer") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('next_question_id')) has-error @endif">
                       <label for="next_question_id-field">Next_question_id</label>
                    <input type="text" id="next_question_id-field" name="next_question_id" class="form-control" value="{{ is_null(old("next_question_id")) ? $answer->next_question_id : old("next_question_id") }}"/>
                       @if($errors->has("next_question_id"))
                        <span class="help-block">{{ $errors->first("next_question_id") }}</span>
                       @endif
                    </div>
                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a class="btn btn-link pull-right" href="{{ route('answers.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>
                </div>
            </form>

        </div>
    </div>
@endsection
@section('scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/js/bootstrap-datepicker.min.js"></script>
  <script>
    $('.date-picker').datepicker({
    });
  </script>
@endsection
