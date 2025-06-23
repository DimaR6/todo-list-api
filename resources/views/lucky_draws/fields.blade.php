<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::number('user_id', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Random Number Field -->
<div class="form-group col-sm-6">
    {!! Form::label('random_number', 'Random Number:') !!}
    {!! Form::number('random_number', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Result Field -->
<div class="form-group col-sm-6">
    {!! Form::label('result', 'Result:') !!}
    {!! Form::text('result', null, ['class' => 'form-control', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
</div>

<!-- Win Amount Field -->
<div class="form-group col-sm-6">
    {!! Form::label('win_amount', 'Win Amount:') !!}
    {!! Form::number('win_amount', null, ['class' => 'form-control', 'required']) !!}
</div>