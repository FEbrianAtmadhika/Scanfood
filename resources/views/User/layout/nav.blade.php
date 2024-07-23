<div class="main-container d-flex">
    <div class="sidebar" id="side_nav">
        <div class="header-box px-2 pt-3 pb-4 d-flex justify-content-between">
            <img src="{{ asset('img/Logo-removebg.png') }}" alt="">
            <button class="btn d-md-none d-block close-btn px-1 py-0 text-white"><i
                    class="fal fa-stream"></i></button>
        </div>

        <ul class="list-unstyled px-2">
            <li class="{{ Route::is('dashboard') ? 'active' : '@'}}"><a href="{{ Route::is('dashboard') ? '#' : route("dashboard")}}" class="text-decoration-none px-3 py-2 d-block"><i
                        class="fal fa-home"></i> Dashboard</a></li>
            <li class="{{ Route::is('history') ? 'active' : '@' }}"><a href="{{ Route::is('history') ? '#' : route("history")}}" class="text-decoration-none px-3 py-2 d-block"><i class="fal fa-list"></i>
                    History</a></li>

        </ul>
        <hr class="h-color mx-2">

    </div>
    <div class="content">
        <nav class="navbar navbar-expand-md navbar-light bg-light">
            <div class="container-fluid">
                <div class="d-flex justify-content-between d-md-none d-block">
                 <button class="btn px-1 py-0 open-btn me-2"><i class="fal fa-stream"></i></button>
                    <a class="navbar-brand fs-4" href="#"><span class="bg-dark rounded px-2 py-0 text-white">CL</span></a>

                </div>
                <button class="navbar-toggler p-0 border-0" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fal fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                    <ul class="navbar-nav mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('logout') }}">Logout</a>
                        </li>

                    </ul>

                </div>
            </div>
        </nav>

