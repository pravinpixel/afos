@include('layouts.header')

<body style="background: url('{{ asset('assets/front/images/body.jpg')}}')">
    <nav class="navbar navbar-expand-lg navbar-light bg-light" id="navigation_bar">
        <div class="container">
            <a class="navbar-brand logo-container" href="#">
                <img src="{{ asset('assets/front/images/logo.png' ) }}" alt="logo1" class="img-fluid">
            </a>  
            <a class="logo-container navbar-brand">
                <img src="{{ asset('assets/front/images/logo1.png' ) }}" alt="logo1" class="img-fluid">
            </a>
        </div>
    </nav>
    @include('layouts.topbar')
    @yield('content')
    
</body>
</html>