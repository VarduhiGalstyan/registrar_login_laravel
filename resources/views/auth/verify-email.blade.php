@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Please confirm your email.</h2>
        <p>A confirmation link has been sent to your email. Please check your inbox and click the link.</p>
        <p>If you haven't received the letter, <a href="{{ route('verification.resend') }}">click here to resend</a>.</p>
    </div>
@endsection
