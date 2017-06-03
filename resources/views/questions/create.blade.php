@extends('layout')
@section('css')
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/css/bootstrap-datepicker.css" rel="stylesheet">
@endsection
@section('header')
    <div class="page-header">
        <h1><i class="glyphicon glyphicon-plus"></i> Questions / Create </h1>
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
            <form action="{{ route('questions.store') }}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group @if($errors->has('bot_id')) has-error @endif">
                    <input type="hidden" id="bot_id-field" name="bot_id" class="form-control" value="{{ $bot->id }}"/>
                    <div class="form-group @if($errors->has('question')) has-error @endif">
                       <label for="question-field">Question</label>
                    <input type="text" id="question-field" name="question" class="form-control" value="{{ old("question") }}"/>
                       @if($errors->has("question"))
                        <span class="help-block">{{ $errors->first("question") }}</span>
                       @endif
                    </div>
                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Create</button>
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
