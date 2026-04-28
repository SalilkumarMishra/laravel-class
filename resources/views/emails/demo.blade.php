@extends('layout')

@section('content')
    <h2>Email Demo</h2>
    <p>This example shows the common Laravel email sending styles: raw text, a Blade mailable, and a mailable with attachment.</p>

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

    <form method="POST" action="{{ route('emails.send') }}" enctype="multipart/form-data">
        @csrf

        <div>
            <label for="recipient">Recipient email</label>
            <input id="recipient" type="email" name="recipient" value="{{ old('recipient') }}">
        </div>

        <div>
            <label for="subject">Subject</label>
            <input id="subject" type="text" name="subject" value="{{ old('subject') }}">
        </div>

        <div>
            <label for="message">Message</label>
            <textarea id="message" name="message">{{ old('message') }}</textarea>
        </div>

        <div>
            <label for="mode">Send mode</label>
            <select id="mode" name="mode">
                <option value="raw" {{ old('mode') === 'raw' ? 'selected' : '' }}>Raw text email</option>
                <option value="html" {{ old('mode') === 'html' ? 'selected' : '' }}>Blade HTML mailable</option>
                <option value="attachment" {{ old('mode') === 'attachment' ? 'selected' : '' }}>HTML mailable with attachment</option>
            </select>
        </div>

        <div>
            <label for="cc">CC</label>
            <input id="cc" type="email" name="cc" value="{{ old('cc') }}">
        </div>

        <div>
            <label for="bcc">BCC</label>
            <input id="bcc" type="email" name="bcc" value="{{ old('bcc') }}">
        </div>

        <div>
            <label for="reply_to">Reply to</label>
            <input id="reply_to" type="email" name="reply_to" value="{{ old('reply_to') }}">
        </div>

        <div>
            <label for="attachment">Attachment</label>
            <input id="attachment" type="file" name="attachment">
        </div>

        <button type="submit">Send Example Email</button>
    </form>

    <p>Tip: the default mailer in this app is <strong>log</strong>, so messages will be written to logs unless you change <code>MAIL_MAILER</code>.</p>
@endsection
