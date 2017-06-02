@extends('layout')
@section('header')
<div class="page-header">
        <h1>CustomerLists / Show #{{$customer_list->id}}</h1>
        <form action="{{ route('customer_lists.destroy', $customer_list->id) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Delete? Are you sure?')) { return true } else {return false };">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="btn-group pull-right" role="group" aria-label="...">
                <a class="btn btn-warning btn-group" role="group" href="{{ route('customer_lists.edit', $customer_list->id) }}"><i class="glyphicon glyphicon-edit"></i> Edit</a>
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
                     <label for="full_name">FULL_NAME</label>
                     <p class="form-control-static">{{$customer_list->full_name}}</p>
                </div>
                    <div class="form-group">
                     <label for="phone_number">PHONE_NUMBER</label>
                     <p class="form-control-static">{{$customer_list->phone_number}}</p>
                </div>
            </form>

            <a class="btn btn-link" href="{{ route('customer_lists.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>

        </div>
    </div>

@endsection