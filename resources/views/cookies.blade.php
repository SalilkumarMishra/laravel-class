@extends('layout')

@section('content')
    <h2>Cookie Demo</h2>
    <p>Choose a theme and nickname, then submit the form to save them as cookies.</p>

    @if (session('status'))
        <p>{{ session('status') }}</p>
    @endif

    @if (!empty($storedTheme))
        <div>
            <strong>Stored cookie values from the browser:</strong>
            <div>Theme: {{ $storedTheme }}</div>
            <div>Nickname: {{ request()->cookie('nickname') ?? 'None' }}</div>
        </div>
    @endif

    @if (session('cookie_preview'))
        <div>
            <strong>Just saved:</strong>
            <div>Theme: {{ session('cookie_preview.theme') }}</div>
            <div>Nickname: {{ session('cookie_preview.nickname') ?: 'None' }}</div>
        </div>
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

    <form method="POST" action="{{ route('cookies.submit') }}">
        @csrf

        <div>
            <label for="theme">Theme</label>
            <select id="theme" name="theme">
                <option value="">Select a theme</option>
                <option value="light" {{ old('theme') === 'light' ? 'selected' : '' }}>Light</option>
                <option value="dark" {{ old('theme') === 'dark' ? 'selected' : '' }}>Dark</option>
                <option value="system" {{ old('theme') === 'system' ? 'selected' : '' }}>System</option>
            </select>
        </div>

        <div>
            <label for="nickname">Nickname</label>
            <input id="nickname" type="text" name="nickname" value="{{ old('nickname') }}">
        </div>

        <button type="submit">Save Cookie</button>
    </form>

    <p>The theme and nickname are stored in cookies for 30 days.</p>
@endsection
