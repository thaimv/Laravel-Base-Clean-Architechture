@extends('layouts.mail')

@section('content')
    <div>
        <p><a href="{{ $data['url'] }}">Click here to reset password</a></p>
    </div>
@endsection
