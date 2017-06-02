@extends('layout')
@section('css')
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/css/bootstrap-datepicker.css" rel="stylesheet">
@endsection
@section('header')
    <div class="page-header">
        <h1><i class="glyphicon glyphicon-edit"></i> CustomerLists / Edit #{{$customer_list->id}}</h1>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            <form action="{{ route('customer_lists.update', $customer_list->id) }}" method="POST">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group @if($errors->has('full_name')) has-error @endif">
                       <label for="full_name-field">Full_name</label>
                    <input type="text" id="full_name-field" name="full_name" class="form-control" value="{{ is_null(old("full_name")) ? $customer_list->full_name : old("full_name") }}"/>
                       @if($errors->has("full_name"))
                        <span class="help-block">{{ $errors->first("full_name") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('phone_number')) has-error @endif">
                       <label for="phone_number-field">Phone_number</label>
                    <input type="text" id="phone_number-field" name="phone_number" class="form-control" value="{{ is_null(old("phone_number")) ? $customer_list->phone_number : old("phone_number") }}"/>
                       @if($errors->has("phone_number"))
                        <span class="help-block">{{ $errors->first("phone_number") }}</span>
                       @endif
                    </div>
                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a class="btn btn-link pull-right" href="{{ route('customer_lists.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>
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
