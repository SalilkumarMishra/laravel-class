@extends('layout')

@section('content')
    <h2>File Upload Demo</h2>
    <p>Choose a file, submit the form, and Laravel will validate and store it on the public disk.</p>

    @if (session('status'))
        <p>{{ session('status') }}</p>
    @endif

    @if (session('uploaded_file'))
        <div>
            <strong>Last uploaded file:</strong>
            <div>Title: {{ session('uploaded_file.title') }}</div>
            <div>Description: {{ session('uploaded_file.description') ?? 'None' }}</div>
            <div>Original name: {{ session('uploaded_file.original_name') }}</div>
            <div>Stored path: {{ session('uploaded_file.path') }}</div>
            <div>Public URL: <a href="{{ session('uploaded_file.url') }}" target="_blank">{{ session('uploaded_file.url') }}</a></div>
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

    <form method="POST" action="{{ route('file-upload.submit') }}" enctype="multipart/form-data">
        @csrf

        <div>
            <label for="title">Title</label>
            <input id="title" type="text" name="title" value="{{ old('title') }}">
        </div>

        <div>
            <label for="description">Description</label>
            <textarea id="description" name="description">{{ old('description') }}</textarea>
        </div>

        <div>
            <label for="attachment">Attachment</label>
            <input id="attachment" type="file" name="attachment">
        </div>

        <button type="submit">Upload</button>
    </form>

    <p>Note: file inputs cannot be repopulated after validation errors, but the text fields below will keep their old values.</p>
@endsection
