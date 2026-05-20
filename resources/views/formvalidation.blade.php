<form action="/submit-form" method="post" enctype="multipart/form-data" novalidate>
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

    Student Name: <input type="text" name="studentname" value="{{ old('studentname') }}">
    @error('studentname')
    <div style="color: red;">{{ $message }}</div>
    @enderror
    <br><br>

    Email: <input type="text" name="email" value="{{ old('email') }}">
    @error('email')
    <div style="color: red;">{{ $message }}</div>
    @enderror
    <br><br>

    Mobile Number: <input type="text" name="mobile" value="{{ old('mobile') }}">
    @error('mobile')
    <div style="color: red;">{{ $message }}</div>
    @enderror
    <br><br>

    Alternate Mobile: <input type="text" name="alternate_mobile" value="{{ old('alternate_mobile') }}">
    @error('alternate_mobile')
    <div style="color: red;">{{ $message }}</div>
    @enderror
    <br><br>

    Gender:
    <select name="gender">
        <option value="">Select Gender</option>
        <option value="male" @selected(old('gender') === 'male')>Male</option>
        <option value="female" @selected(old('gender') === 'female')>Female</option>
        <option value="other" @selected(old('gender') === 'other')>Other</option>
    </select>
    @error('gender')
    <div style="color: red;">{{ $message }}</div>
    @enderror
    <br><br>

    Date of Birth: <input type="text" name="dateofbirth" value="{{ old('dateofbirth') }}">
    @error('dateofbirth')
    <div style="color: red;">{{ $message }}</div>
    @enderror
    <br><br>

    Age: <input type="text" name="age" value="{{ old('age') }}">
    @error('age')
    <div style="color: red;">{{ $message }}</div>
    @enderror
    <br><br>

    Address: <input type="text" name="address" value="{{ old('address') }}">
    @error('address')
    <div style="color: red;">{{ $message }}</div>
    @enderror
    <br><br>

    Pincode: <input type="text" name="pincode" value="{{ old('pincode') }}">
    @error('pincode')
    <div style="color: red;">{{ $message }}</div>
    @enderror
    <br><br>

    Course: <input type="text" name="course" value="{{ old('course') }}">
    @error('course')
    <div style="color: red;">{{ $message }}</div>
    @enderror
    <br><br>

    Percentage/Marks: <input type="text" name="percentage" value="{{ old('percentage') }}">
    @error('percentage')
    <div style="color: red;">{{ $message }}</div>
    @enderror
    <br><br>

    Signature Upload: <input type="file" name="signatureupload">
    @error('signatureupload')
    <div style="color: red;">{{ $message }}</div>
    @enderror
    <br><br>

    Password: <input type="password" name="password">
    @error('password')
    <div style="color: red;">{{ $message }}</div>
    @enderror
    <br><br>

    Confirm Password: <input type="password" name="password_confirmation">
    @error('password_confirmation')
    <div style="color: red;">{{ $message }}</div>
    @enderror
    <br><br>

    Terms & Conditions: <input type="checkbox" name="terms" value="1" @checked(old('terms'))>
    @error('terms')
    <div style="color: red;">{{ $message }}</div>
    @enderror
    <br><br>
    <button type="submit" value="Submit">
        Submit
    </button>
</form>
