<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'Plastic Ecommerce')</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @yield('styles')
</head>

<body>
    @include('components.header')

    <main>
        @yield('content')
    </main>

    @include('components.footer')

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>

    <script src="{{ asset('js/jquery.slicknav.js') }}"></script>

    <script>
        // Logic đếm lượt truy cập (giữ nguyên)
        document.addEventListener('DOMContentLoaded', function() {
            if (!window.location.pathname.startsWith('/admin')) {
                fetch('{{ route("visitor.increment") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Visitor count:', data);
                    })
                    .catch(error => {
                        console.error('Error with visitor count:', error);
                    });
            }
        });
    </script>

    <script src="{{ asset('js/main.js') }}"></script>

    @yield('scripts')


</body>

</html>