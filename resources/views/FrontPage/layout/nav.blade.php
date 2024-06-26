<nav class="navbar navbar-expand-lg py-3 " style="z-index: 3;">
    <div class="pe-lg-0 ps-lg-5 container-fluid justify-content-between">
        <a class="navbar-brand" href="#">
            <img src="{{ asset('img/logounp.png') }}" height="60" alt="logo">
        </a>
        <h3>TALENT UNP</h3>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
            </svg></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" style="font-size:20px" id="navbarSupportedContent">
            <div class="nav_left d-lg-flex align-items-center">
                <nav>
                    <div class="nav d-block d-lg-flex nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="home-tab" type="button"><a href="{{ route('front_home') }}" style="text-decoration: none; color: white">Home</a></button>
                        <button class="nav-link nav-item dropdown dropdown-hover position-static dropdown-toggle" id="about-tab" data-bs-toggle="tab" data-bs-target="#about" data-mdb-toggle="dropdown"
                            type="button" role="tab" aria-selected="false" aria-expanded="false">
                              Talent
                              <div class=" dropdown-menu w-100" id="talentDropdown" aria-labelledby="navbarDropdown" style="border-top-left-radius: 0;border-top-right-radius: 0;">
                                <div class="row p-3 ">
                                  <div class="col-6 col-md-4 p-5">
                                    <div class="tabs_list" style="font-size:24px;">
                                      <ul>
                                        @foreach ($menutalent as $item)
                                        <li data-tc="tab_item_{{ $item->id }}" class="active"><a class="text-dark" style=”color:black;background-color:transparent;text-decoration:none;” > {{ $item->kategori  }}</a>
                                             </li>
                                        @endforeach

                                      </ul>
                                    </div>
                                  </div>
                                  <div class="col-sm-6 col-md-8 " style="border-left: 2px solid black; ">
                                  <div class="tabs_content mx-5">
                                    <div class="tab_body">
                                        @foreach ($menutalent as $item)
                                        <div class="tab_item tab_item_{{ $item->id }}">
                                          <h3>{{ $item->kategori }}</h3>
                                          @foreach ($item->Subtalent as $skill)
                                          <p><a href="{{ route('anggota_show', $skill->id) }}" style="text-decoration: none;color: black">{{ $skill->nama_talent }}</a></p>
                                          @endforeach
                                      </div>
                                        @endforeach
                                 </div>
                                  </div>
                                  </div>
                                </div>

                              </div>
                          </button>
                    </div>
                </nav>
                <div class="position-relative d-inline-block me-lg-4 p-2">
                    <form id="searchForm" action="{{ route('search_submit') }}" method="GET" onsubmit="handleEnter(event)">
                        @csrf
                        <div class="search-bar">
                            <div id="select" class="text-center">
                                <p id="selectText">Skill</p>
                                <ul id="list" class="card">
                                    <li class="options" data-value="1">Skill</li>
                                    <li class="options" data-value="2">Talent</li>
                                    <li class="options" data-value="3">Peserta</li>
                                </ul>
                            </div>
                            <input type="hidden" id="selectedOption" name="selectedOption" value="{{ request('selectedOption') }}">
                            <input name="input" class="search_input ms-5 mb-3 mb-lg-0 ms-lg-0 pe-5 ps-3" value="{{ request('input') }}" id="inputField" type="search" placeholder="Search" aria-label="Search" onkeydown="handleEnter(event)">
                        </div>
                    </form>
                </div>
                <div class="nav d-block d-lg-flex nav-tabs" id="nav-tab" role="tablist">
                @auth

                    <button class="nav-link" id="courses-tab" data-bs-toggle="tab" data-bs-target=""
                    type="button" role="tab" aria-controls="courses" aria-selected="false" > <a class="btn"  href="{{ route('user_profile') }}" >
                      <img class="ratio ratio-1x1 rounded-circle" style=" height: 50px; width: 150%;" src="{{ Auth::guard()->user()->photo ? asset($path = 'storage/public/img/'. Auth::guard()->user()->id.'/' . Auth::guard()->user()->photo) : asset('img/hu.JPG')}}" alt="" /></a></button>

                    <button class="nav-link" id="courses-tab" data-bs-toggle="tab" data-bs-target="#courses"
                    type="button" role="tab" aria-controls="courses" aria-selected="false"> <a href="{{ route('user_logout') }}" class="btn rounded-pill btn-sm text-white bg-primary" style="--bs-bg-opacity: .5; "> Logout</a> </button>

                    @else
                    <button class="nav-link" id="courses-tab" data-bs-toggle="tab" data-bs-target="#courses"
                    type="button" role="tab" aria-controls="courses" style="font-size:20px" aria-selected="false"> <a href="{{ route('user_login') }}" class="btn rounded-pill btn-sm text-white bg-primary " style="--bs-bg-opacity: .5; " >   Login  </a> </button>
                    @endauth

                  </div>

            </div>
        </div>
    </div>
</nav>
