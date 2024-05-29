<!DOCTYPE html>
<html lang="en">

<head>
    @include('Layout.common-head')
</head>

<body class="g-sidenav-show  bg-gray-200">
    @include('Layout.sidebar')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        @include('Layout.header')
        @section('main-content')
        @show
        @include('Layout.footer')
    </main>

    @include('Layout.common-end')
    @stack('custom-scripts')
</body>
</html>
