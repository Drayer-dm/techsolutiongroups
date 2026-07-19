<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> {{$title ?? Inicio}}</title>
    @vite(['resources/css/app.css'])
    <x-atoms.icon.icon/>
</head>
<body>
    <body class="bg-slate-100 text-slate-800 font-sans p-12 flex flex-col items-left min-h-screen">
        <x-organism.navbar/>
    </body>



</body>
</html>