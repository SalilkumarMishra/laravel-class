@extends('layout')

@section('content')
    <h2>Old Input Demo</h2>
    <p>Submit the form with empty or invalid values to see the old input refill after validation fails.</p>

    @if (session('status'))
        <p>{{ session('status') }}</p>
    @endif

    @if ($errors->any())
        <div>
            <strong>Please fix the following errors:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('old-input.submit') }}">
        @csrf

        <div>
            <label for="name">Name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}">
        </div>

        <div>
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}">
        </div>

        <div>
            <label for="message">Message</label>
            <textarea id="message" name="message">{{ old('message') }}</textarea>
        </div>

        <button type="submit">Submit</button>
    </form>
@endsection
