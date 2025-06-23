<!-- User Id Field -->
<div class="col-sm-12">
    {!! Form::label('user_id', 'User Id:') !!}
    <p>{{ $luckyDraw->user_id }}</p>
</div>

<!-- Random Number Field -->
<div class="col-sm-12">
    {!! Form::label('random_number', 'Random Number:') !!}
    <p>{{ $luckyDraw->random_number }}</p>
</div>

<!-- Result Field -->
<div class="col-sm-12">
    {!! Form::label('result', 'Result:') !!}
    <p>{{ $luckyDraw->result }}</p>
</div>

<!-- Win Amount Field -->
<div class="col-sm-12">
    {!! Form::label('win_amount', 'Win Amount:') !!}
    <p>{{ $luckyDraw->win_amount }}</p>
</div>

