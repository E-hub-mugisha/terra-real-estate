<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">

<head>
    @include('includes.panel.head')
    @stack('head')
</head>

@include('includes.panel.shell')

</html>
