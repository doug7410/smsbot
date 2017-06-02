@extends('layout')

@section('header')
    <div class="page-header clearfix">
        <h1>
            <i class="glyphicon glyphicon-align-justify"></i> Conversations
            <a class="btn btn-success pull-right" href="{{ route('conversations.create') }}"><i class="glyphicon glyphicon-plus"></i> Create</a>
        </h1>

    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if($conversations->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>BOT</th>
                        <th>CUSTOMER_PHONE_NUMBER</th>
                        <th>STATUS</th>
                        <th>LAST_QUESTION_ID</th>
                            <th class="text-right">OPTIONS</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($conversations as $conversation)
                            <tr>
                                <td>{{$conversation->id}}</td>
                                <td>
                                    {{ \App\OutboundBot::find($conversation->bot_id)->name }} -
                                    <a href="/outbound_bots/{{$conversation->bot_id}}">View Bot</a>
                                </td>
                    <td>{{$conversation->customer_phone_number}}</td>
                    <td>{{$conversation->status}}</td>
                    <td>{{$conversation->last_question_id}}</td>
                                <td class="text-right">
                                    <a class="btn btn-xs btn-primary" href="{{ route('conversations.show', $conversation->id) }}"><i class="glyphicon glyphicon-eye-open"></i> View</a>
                                    <a class="btn btn-xs btn-warning" href="{{ route('conversations.edit', $conversation->id) }}"><i class="glyphicon glyphicon-edit"></i> Edit</a>
                                    <form action="{{ route('conversations.destroy', $conversation->id) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Delete? Are you sure?')) { return true } else {return false };">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $conversations->render() !!}
            @else
                <h3 class="text-center alert alert-info">Empty!</h3>
            @endif

        </div>
    </div>

@endsection