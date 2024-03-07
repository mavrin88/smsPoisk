<!DOCTYPE html>
<html class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    {{-- Inertia --}}
    <script src="https://polyfill.io/v3/polyfill.min.js?features=smoothscroll,NodeList.prototype.forEach,Promise,Object.values,Object.assign"
            defer></script>

    {{-- For Widgets --}}
    <link href="{{ asset('css/theme.bundle.css') }}" rel="stylesheet" id="stylesheetLight"/>

    {{-- Ping CRM --}}
    <script src="https://polyfill.io/v3/polyfill.min.js?features=String.prototype.startsWith" defer></script>
    @routes
    <script src="{{ mix('/js/app.js') }}" defer></script>
    @inertiaHead
</head>
<body class="font-sans leading-none text-gray-700 antialiased">
@inertia
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>

</body>
</html>
