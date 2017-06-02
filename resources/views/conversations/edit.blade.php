@extends('layout')
@section('css')
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/css/bootstrap-datepicker.css" rel="stylesheet">
@endsection
@section('header')
    <div class="page-header">
        <h1><i class="glyphicon glyphicon-edit"></i> Conversations / Edit #{{$conversation->id}}</h1>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            <form action="{{ route('conversations.update', $conversation->id) }}" method="POST">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group @if($errors->has('bot_id')) has-error @endif">
                       <label for="bot_id-field">Bot_id</label>
                    <input type="text" id="bot_id-field" name="bot_id" class="form-control" value="{{ is_null(old("bot_id")) ? $conversation->bot_id : old("bot_id") }}"/>
                       @if($errors->has("bot_id"))
                        <span class="help-block">{{ $errors->first("bot_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('customer_phone_number')) has-error @endif">
                       <label for="customer_phone_number-field">Customer_phone_number</label>
                    <input type="text" id="customer_phone_number-field" name="customer_phone_number" class="form-control" value="{{ is_null(old("customer_phone_number")) ? $conversation->customer_phone_number : old("customer_phone_number") }}"/>
                       @if($errors->has("customer_phone_number"))
                        <span class="help-block">{{ $errors->first("customer_phone_number") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('status')) has-error @endif">
                       <label for="status-field">Status</label>
                    <input type="text" id="status-field" name="status" class="form-control" value="{{ is_null(old("status")) ? $conversation->status : old("status") }}"/>
                       @if($errors->has("status"))
                        <span class="help-block">{{ $errors->first("status") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('last_question_id')) has-error @endif">
                       <label for="last_question_id-field">Last_question_id</label>
                    <input type="text" id="last_question_id-field" name="last_question_id" class="form-control" value="{{ is_null(old("last_question_id")) ? $conversation->last_question_id : old("last_question_id") }}"/>
                       @if($errors->has("last_question_id"))
                        <span class="help-block">{{ $errors->first("last_question_id") }}</span>
                       @endif
                    </div>
                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a class="btn btn-link pull-right" href="{{ route('conversations.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>
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
