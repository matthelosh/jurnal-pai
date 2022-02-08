<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <meta name="description" content="{{ $pageDescription?? 'Laman Beranda Jurnal PAI Wagir'}}">
        <title>{{ $pageTitle ?? 'Jurnal PAI Kecamatan Wagir'}}</title>
        <link href="{{ mix('/css/app.css') }}" rel="stylesheet" />
        <script src="{{ mix('/js/app.js') }}" defer></script>
        <style>
            * {
                font-family: 'Roboto';
                }
        </style>
        @inertiaHead
    </head>
    <body>
        @inertia
    </body>
</html>
