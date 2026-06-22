{{-- 
  =====================================================================
  LAYOUT BASE DE CONNERA SHOP  ->  <x-app-layout>
  Este es el "molde" que comparten todas las pantallas del panel.
  Cada página solo inyecta su contenido en la zona {{ $slot }}.
  =====================================================================
--}}
<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Token de seguridad que Laravel usa para proteger los formularios --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Título de la pestaña del navegador. Usa el que le pase cada página,
         o "Connera Shop" si la página no especifica uno. --}}
    <title>{{ $title ?? 'Connera Shop' }}</title>

    {{-- Carga tus estilos compilados (Tailwind + tus colores de marca) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

{{-- El fondo usa tu color corporativo claro (connera-bg) y el texto tu gris oscuro --}}
<body class="h-full bg-connera-bg text-connera-text antialiased">

    {{-- Aquí se inserta el contenido propio de cada pantalla --}}
    {{ $slot }}

</body>
</html>