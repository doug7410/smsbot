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
            <div>
                <label for="">Bot Name: </label>
                <span>{{ $bot->name }}</span>
            </div>
            <div>
                <label for="">Question: </label>
                <span>{{ $question->question }}</span>
            </div>
            <form action="{{ route('answers.update', $answer->id) }}" method="POST">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" id="bot_id-field" name="bot_id" class="form-control" value="{{ $bot->id }}"/>
                <input type="hidden" id="question_id-field" name="question_id" class="form-control" value="{{ $question->id }}"/>
                <div class="form-group @if($errors->has('trigger')) has-error @endif">
                    <label for="trigger-field">Trigger</label>
                    <input type="text" id="trigger-field" name="trigger" class="form-control" value="{{ $answer->trigger }}"/>
                    @if($errors->has("trigger"))
                        <span class="help-block">{{ $errors->first("trigger") }}</span>
                    @endif
                </div>
                <div class="form-group @if($errors->has('answer')) has-error @endif">
                    <label for="answer-field">Answer</label>
                    <input type="text" id="answer-field" name="answer" class="form-control" value="{{ $answer->answer }}"/>
                    @if($errors->has("answer"))
                        <span class="help-block">{{ $errors->first("answer") }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="next_question_id-field">Next Question</label>
                    <div>
                        <select name="next_question_id" id="">
                            @foreach($relatedQuestions as $relatedQuestion)
                                <option value="{{ $relatedQuestion->id }}" @if($relatedQuestion->id == $answer->next_question_id) selected @endif>{{ $relatedQuestion->question }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a class="btn btn-link pull-right" href="{{ route('outbound_bots.show', $bot->id) }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
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
