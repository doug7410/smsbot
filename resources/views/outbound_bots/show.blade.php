@extends('layout')
@section('header')
<div class="page-header">
    <h3>OutboundBot - {{$outbound_bot->name}}</h3>
    <a class="btn btn-xs btn-warning" href="{{ route('outbound_bots.edit', $outbound_bot->id) }}"><i class="glyphicon glyphicon-edit"></i> Edit</a>
    <strong>Phone Number:</strong> {{$outbound_bot->phone_number}}
    <br><br>
    <button class="test-bot btn btn-info" data-id="{{$outbound_bot->id}}">Test This Bot <i class="glyphicon glyphicon-cog"></i></button>
    This makes a post request to <strong>"http://{{  $_SERVER['HTTP_HOST'] }}/api/outbound_bot/initiate/{{$outbound_bot->id}}"</strong>
    <span class="sending">sending messages ...</span>
</div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <p>
                <strong>Description:</strong> {{$outbound_bot->description}}
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <strong class="heading">Questions and Answers</strong>
            <a class="btn btn-success pull-right" href="{{ route('outbound_bot_questions.create', $outbound_bot->id) }}">
                <i class="glyphicon glyphicon-plus"></i> Add a Question
            </a>
            @foreach($questions as $question)
            <table class="table table-bordered">
                <tr class="info">
                    <td>
                        <strong>ID: {{ $question->id }} - {{ $question->question }}</strong>
{{--                        <a class="btn btn-xs btn-warning" href="{{ route('questions.edit', $question->id) }}"><i class="glyphicon glyphicon-edit"></i> Edit</a>--}}
                        <br>
                        <strong class="heading">Answers:</strong>
                        <a class="btn btn-success btn-xs" href="{{ route('outbound_bot_answers.create', [$outbound_bot->id, $question->id]) }}">
                            <i class="glyphicon glyphicon-plus"></i> Add Answer
                        </a>
                        <table class="table table-bordered table-condensed">
                            <tr>
                                <th>Trigger</th>
                                <th>Text</th>
                                <th>Next Question</th>
                                <th>&nbsp;</th>
                            </tr>
                            @foreach($question->answers as $answer)
                                <tr>
                                    <td class="ten-percent">
                                        {{ $answer->trigger }}
                                    </td>
                                    <td class="forty-percent">
                                        {{ $answer->answer }}
                                    </td>
                                    <td class="forty-percent">
                                        {{ $answer->next_question_id ? \App\Question::find($answer->next_question_id)->question : 'none' }}
                                    </td>
                                    <td class="ten-percent">
                                        <a class="btn btn-xs btn-warning" href="{{ route('answers.edit', $answer->id) }}"><i class="glyphicon glyphicon-edit"></i> Edit</a>
                                        <form action="{{ route('answers.destroy', $answer->id) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Delete? Are you sure?')) { return true } else {return false };">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </td>
                </tr>
            </table>
            @endforeach
            <a class="btn btn-link" href="{{ route('outbound_bots.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>

        </div>
    </div>

    <style>
        .ten-percent {
            width: 10%
        }
        .forty-percent {
            width: 40%;
        }
        .heading {
            font-size: 20px;
        }
        .sending {
            display: none;
        }
    </style>

    <script
            src="https://code.jquery.com/jquery-3.2.1.min.js"
            integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
            crossorigin="anonymous"></script>

    <script>
      $('.test-bot').click(function () {
        var id = $('.test-bot').data('id');
        $('.sending').css('display', 'block');
        $.post('/api/outbound_bot/initiate/'+id).then(function (data) {
          $('.sending').text(data);
        })
      })
    </script>
@endsection