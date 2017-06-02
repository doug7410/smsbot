@extends('layout')
@section('header')
<div class="page-header">
        <h1>Conversations / Show #{{$conversation->id}}</h1>
        <form action="{{ route('conversations.destroy', $conversation->id) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Delete? Are you sure?')) { return true } else {return false };">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="btn-group pull-right" role="group" aria-label="...">
                <a class="btn btn-warning btn-group" role="group" href="{{ route('conversations.edit', $conversation->id) }}"><i class="glyphicon glyphicon-edit"></i> Edit</a>
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
                     <p class="form-control-static">{{$conversation->bot_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="customer_phone_number">CUSTOMER_PHONE_NUMBER</label>
                     <p class="form-control-static">{{$conversation->customer_phone_number}}</p>
                </div>
                    <div class="form-group">
                     <label for="status">STATUS</label>
                     <p class="form-control-static">{{$conversation->status}}</p>
                </div>
                    <div class="form-group">
                     <label for="last_question_id">LAST_QUESTION_ID</label>
                     <p class="form-control-static">{{$conversation->last_question_id}}</p>
                </div>
            </form>

            <a class="btn btn-link" href="{{ route('conversations.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>

        </div>
    </div>

@endsection