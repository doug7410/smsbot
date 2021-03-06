@extends('layout')
@section('css')
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/css/bootstrap-datepicker.css" rel="stylesheet">
@endsection
@section('header')
    <div class="page-header">
        <h1><i class="glyphicon glyphicon-edit"></i> Questions / Edit #{{$question->id}}</h1>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            <form action="{{ route('questions.update', $question->id) }}" method="POST">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group @if($errors->has('bot_id')) has-error @endif">
                       <label for="bot_id-field">Bot_id</label>
                    <input type="text" id="bot_id-field" name="bot_id" class="form-control" value="{{ is_null(old("bot_id")) ? $question->bot_id : old("bot_id") }}"/>
                       @if($errors->has("bot_id"))
                        <span class="help-block">{{ $errors->first("bot_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('question')) has-error @endif">
                       <label for="question-field">Question</label>
                    <input type="text" id="question-field" name="question" class="form-control" value="{{ is_null(old("question")) ? $question->question : old("question") }}"/>
                       @if($errors->has("question"))
                        <span class="help-block">{{ $errors->first("question") }}</span>
                       @endif
                    </div>
                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a class="btn btn-link pull-right" href="{{ route('outbound_bots.show', $bot->id) }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>
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
