@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="col-sm-6">
        <h3>Enter App By clicking the button</h3>
    </div>

    @if ($hash)
    <a class="btn btn-primary"
        href="{{ route('magicLinks.index') }}">
        Click here - {{ $hash}}
    </a>
    @else

    <div class="alert alert-warning">
        <strong>Warning!</strong> No magic link hash found.
    </div>
    @endif

</div>
@endsection