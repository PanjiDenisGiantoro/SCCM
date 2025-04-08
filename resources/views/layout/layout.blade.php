<!-- meta tags and other links -->
<!DOCTYPE html>
<html lang="en" data-theme="light">
<meta name="csrf-token" content="{{ csrf_token() }}">

<x-head />
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">

<body>

    <!-- ..::  header area start ::.. -->
    <x-sidebar />
    <!-- ..::  header area end ::.. -->

    <main class="dashboard-main">

        <!-- ..::  navbar start ::.. -->
        <x-navbar />
        <!-- ..::  navbar end ::.. -->
        <div class="dashboard-main-body">

            <!-- ..::  breadcrumb  start ::.. -->
            <x-breadcrumb title='{{ $title }}' subTitle='{{ $subTitle }}' />
            <!-- ..::  header area end ::.. -->

            <style>
                body {
                    font-size: 0.85rem; /* Ukuran teks lebih kecil */
                }

                .card {
                    padding: 0.5rem; /* Mengurangi padding card */
                    margin-bottom: 0.5rem; /* Mengurangi margin antar card */
                }

                .card-header h6 {
                    font-size: 0.9rem; /* Mengurangi ukuran header */
                }

                .form-group {
                    margin-bottom: 0.5rem; /* Mengurangi spasi antar input */
                }

                .form-control, .form-select {
                    font-size: 0.85rem; /* Mengurangi ukuran teks input & select */
                    padding: 0.3rem 0.5rem; /* Mengurangi padding input */
                }

                button {
                    font-size: 0.85rem; /* Mengurangi ukuran teks pada button */
                    padding: 0.3rem 0.6rem; /* Mengurangi padding button */
                }
            </style>

            @yield('content')

        </div>
        <!-- ..::  footer  start ::.. -->
        <x-footer />
        <!-- ..::  footer area end ::.. -->

    </main>

    <!-- ..::  scripts  start ::.. -->

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <x-scripts script="{{ isset($script) ? $script : '' }}" />
    @include('sweetalert::alert')
    <!-- ..::  scripts  end ::.. -->

</body>

</html>
