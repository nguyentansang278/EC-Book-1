<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found</title>
    @vite([ 'resources/css/app.css', 
                'resources/js/app.js',
                'resources/css/custom.css', 
                'resources/js/custom.js'])
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="text-center">
        <p class="text-5xl font-bold text-gray-800">404</p>
        <p class="text-2xl text-gray-600 mt-4">Oops! Page not found.</p>
        <p class="text-gray-500 mt-2">Sorry, the page you are looking for could not be found.</p>
        <a href="{{ route('home') }}" class="mt-6 inline-block bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Go to Homepage</a>
    </div>
</body>
</html>
