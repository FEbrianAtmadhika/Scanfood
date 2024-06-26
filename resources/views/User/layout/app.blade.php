<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <title>@yield('title')</title>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;600;700&display=swap" rel="stylesheet">
    @include('User.layout.styles')

    @include('User.layout.scripts')
    <link rel="stylesheet" href="{{ asset('dist/css/nav.css') }}">

</head>
{{-- style="background-color: #F1F6F5;"  --}}
<body >
<div id="app">
    <div class="main-wrapper" >

        @include('User.layout.nav')

        <div class="main-content h-100 " style="z-index: -1">
            <section class="section h-100">
                <div class="section-header h-100">
                    @yield('main_content')
                </div>



            </section>

        </div>

    </div>
</div>

<br><br>

@include('User.layout.scripts_footer')

</body>
</html>
