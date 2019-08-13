@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 30px">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading" style="color: #57BC90;background-color: #f2dede;border-color: #ebccd1;font-weight: 800;text-align: center">Request Confirmed</div>
                <div class="panel-body" style="background-color: #d6e9c6;color: #3c763d;border-color: #d6e9c6;font-weight: 700;text-align: center">
                   Thank You For Requesting the Product. <br>Click here to Go <a href="{{url('/')}}">Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection