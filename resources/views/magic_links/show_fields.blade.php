<!-- Hash Field -->
<div class="col-sm-12">
    {!! Form::label('hash', 'Hash:') !!}
    <p>{{ $magicLink->hash }}</p>
</div>

<!-- User Id Field -->
<div class="col-sm-12">
    {!! Form::label('user_id', 'User Id:') !!}
    <p>{{ $magicLink->user_id }}</p>
</div>

<!-- Expires At Field -->
<div class="col-sm-12">
    {!! Form::label('expires_at', 'Expires At:') !!}
    <p>{{ $magicLink->expires_at }}</p>
</div>

<!-- Is Active Field -->
<div class="col-sm-12">
    {!! Form::label('is_active', 'Is Active:') !!}
    <p>{{ $magicLink->is_active }}</p>
</div>

