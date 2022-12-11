<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  @vite('resources/css/app.css')
  <title>Qui veut gagner des Shitcoins ?</title>
</head>
<body>
  <header class="flex px-4 items-center h-16 w-full bg-indigo-800">
    <nav class="flex gap-6 text-white">
      <a href="{{ route('sessions.index') }}">Sessions</a>
      <a href="">Questions</a>
    </nav>
  </header>
  <main class="p-4">
    @yield('content')
  </main>
</body>
</html>