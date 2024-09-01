<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage Marquees</title>
    <!-- Include any CSS or JavaScript files -->
</head>
<body>
    <div>
        <!-- Your HTML content for managing marquees goes here -->
        <h1>Manage Marquees</h1>
        <!-- Example: Form to add a new marquee -->
        <form action="{{ route('marquees.store') }}" method="POST">
            @csrf
            <input type="text" name="content" placeholder="Enter marquee content">
            <button type="submit">Add Marquee</button>
        </form>
        <!-- Example: List of existing marquees -->
        <ul>
            @foreach($marques as $marquee)
                <li>{{ $marquee->content }}</li>
                <!-- Add buttons for editing/deleting marquees -->
            @endforeach
        </ul>
    </div>
</body>
</html>
