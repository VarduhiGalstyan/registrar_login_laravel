@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ __('Verify Phone Number') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('verify-phone') }}">
                        @csrf

                        <input type="hidden" name="phone" value="{{ session('phone') }}">

                        <div class="mb-3">
                            <label>{{ __('Enter the 4-digit code sent to your phone') }}</label>
                            <input type="text" class="form-control" name="code" required>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            {{ __('Verify') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
