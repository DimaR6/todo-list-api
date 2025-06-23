@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Roll The Dice</h1>
            </div>
            <div class="col-sm-6">
                
                {!! Form::open(['route' => 'luckyDraws.store']) !!}

                {!! Form::submit('Roll The Dice', ['class' => 'btn btn-primary float-right']) !!}

                {!! Form::close() !!}
            </div>
        </div>
    </div>
</section>

<div class="content px-3">

    @include('flash::message')

    <div class="clearfix"></div>

    <div class="card">
        @include('lucky_draws.table')
    </div>
</div>

@endsection