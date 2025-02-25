@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Խնդրում ենք հաստատել ձեր email-ը</h2>
        <p>Ձեր email-ին ուղարկվել է հաստատման հղում։ Խնդրում ենք ստուգել ձեր մուտքի արկղը և սեղմել հղումը։</p>
        <p>Եթե դուք չեք ստացել նամակը, <a href="{{ route('verification.resend') }}">սեղմեք այստեղ կրկին ուղարկելու համար</a>.</p>
    </div>
@endsection
