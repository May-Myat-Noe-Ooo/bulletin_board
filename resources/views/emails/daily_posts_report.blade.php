<!DOCTYPE html>
<html>
<head>
    <title>Daily Posts Report</title>
</head>
<body>
    <h1>Daily Ten latest Active Posts Report</h1>
    <ul>
        @foreach($posts as $post)
            <li>{{ $post->title }} - {{ $post->created_at->format('Y-m-d H:i:s') }}</li>
        @endforeach
    </ul>
</body>
</html>