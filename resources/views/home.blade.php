@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(isset($user))
                        <ul>
                            <li><strong>Name:</strong> {{ $user->name }}</li>
                            <li><strong>Email:</strong> {{ $user->email }}</li>
                            <li><strong>Phone:</strong> {{ $user->phone }}</li>
                            <li><strong>Gender:</strong> {{ $user->gender }}</li>
                        </ul>
                    @else
                        <p>User data is not available.</p>
                    @endif
                    <!-- stripe -->
                    <form action="/checkout" method="POST">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <button type="submit" class="btn btn-primary">Checkout</button>
                    </form>
                    <!-- stripe -->

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
