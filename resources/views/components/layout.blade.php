<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> {{$title ?? 'Inicio'}}</title>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script> {{-- xD --}}
    @vite(['resources/css/app.css'])
    <x-atoms.icon.icon/>
</head>
    <body class="bg-slate-100 text-slate-800 font-sans flex flex-col items-left min-h-screen">
          <x-organism.navbar/>
          
            <div class="p-12 flex-1">
                {{$slot ?? ''}}
            </div>

          <x-organism.footer/>
    </body>
</html>