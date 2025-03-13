<!-- meta tags and other links -->
<!DOCTYPE html>
<html lang="en" data-theme="light">
<meta name="csrf-token" content="{{ csrf_token() }}">

<x-head />

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

            @yield('content')

        </div>
        <!-- ..::  footer  start ::.. -->
        <x-footer />
        <!-- ..::  footer area end ::.. -->

    </main>

    <!-- ..::  scripts  start ::.. -->

    <x-scripts script="{{ isset($script) ? $script : '' }}" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
            $(".select2").select2(
                {
                    width: 'resolve',
                }
            );
    </script>
    @include('sweetalert::alert')

    <!-- ..::  scripts  end ::.. -->

</body>

</html>
