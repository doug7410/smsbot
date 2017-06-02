@extends('layout')

@section('header')
    <div class="page-header clearfix">
        <h1>
            <i class="glyphicon glyphicon-align-justify"></i> OutboundBots
            <a class="btn btn-success pull-right" href="{{ route('outbound_bots.create') }}"><i class="glyphicon glyphicon-plus"></i> Create</a>
        </h1>

    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if($outbound_bots->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NAME</th>
                        <th>DESCRIPTION</th>
                        <th>PHONE_NUMBER</th>
                        <th class="text-right">OPTIONS</th>
                        <th>Test</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($outbound_bots as $outbound_bot)
                            <tr>
                                <td>{{$outbound_bot->id}}</td>
                                <td>{{$outbound_bot->name}}</td>
                    <td>{{$outbound_bot->description}}</td>
                    <td>{{$outbound_bot->phone_number}}</td>
                        <td class="text-right">
                        <a class="btn btn-xs btn-primary" href="{{ route('outbound_bots.show', $outbound_bot->id) }}"><i class="glyphicon glyphicon-eye-open"></i> View</a>
                        <a class="btn btn-xs btn-warning" href="{{ route('outbound_bots.edit', $outbound_bot->id) }}"><i class="glyphicon glyphicon-edit"></i> Edit</a>
                        <form action="{{ route('outbound_bots.destroy', $outbound_bot->id) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Delete? Are you sure?')) { return true } else {return false };">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete</button>
                        </form>
                    </td>
                    <td>
                        <button class="test-bot btn btn-sm">Test Bot</button>
                    </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $outbound_bots->render() !!}
            @else
                <h3 class="text-center alert alert-info">Empty!</h3>
            @endif

        </div>
    </div>
    <script
            src="https://code.jquery.com/jquery-3.2.1.min.js"
            integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
            crossorigin="anonymous"></script>

    <script>
        $('.test-bot').click(function () {
          console.log('tested');
          $.post('/api/outbound_bot/initiate/1').then(function (data) {
            console.log(data)
          })
        })
    </script>
@endsection