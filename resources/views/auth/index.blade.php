<!DOCTYPE html>
<html>
<head>
    <title>Blog Posts</title>
</head>
<body>
    <h1>All Blog Posts</h1>
    <ul>
        @foreach($posts as $post)
            <li>{{ $post['title'] }}</li>
        @endforeach
    </ul>
</body>
</html>