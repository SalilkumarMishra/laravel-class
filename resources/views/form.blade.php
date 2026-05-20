<!-- <form action="/submit-form" method="post">
    @csrf

    @if ($errors->any())
        <div style="color: red;">
            <strong>Please fix the following errors:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    Username: <input type="text" name="username" value="{{ old('username') }}">
    @error('username')
        <div style="color: red;">{{ $message }}</div>
    @enderror
    <br><br>

    Email: <input type="text" name="email" value="{{ old('email') }}">
    @error('email')
        <div style="color: red;">{{ $message }}</div>
    @enderror
    <br><br>

    <button type="submit" value="Submit">
        Submit
    </button>
</form> -->
