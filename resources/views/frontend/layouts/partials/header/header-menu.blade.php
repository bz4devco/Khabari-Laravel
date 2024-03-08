<nav class="navbar navbar-expand-lg navbar-dark bg-dark py-0">
    <div class="container-fluid max-width">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav2" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav2">
            <ul class="navbar-nav p-0 text-right">
                <li class="nav-item">
                    <a class="nav-link px-4 py-3 nav-hover-2 active" href="{{ route('user.home') }}">خانه</a>
                </li>
                @forelse ($headerCateegories as $headerCateegory)
                @if($loop->iteration >= 9)
                @break
                @endif

                <li class="nav-item">
                    <a class="nav-link px-4 py-3 nav-hover-2 active" href="{{ route('user.reports.index', $headerCateegory->slug) }}">{{$headerCateegory->name}}</a>
                </li>
                @empty
                @endforelse
                @if($headerCateegories->count() >= 9)
                <li class="nav-item px-3 py-2 nav-hover-2 active dropdown">
                    <a class="nav-link dropdown-toggle" id="navbardrop" data-toggle="dropdown">
                        عناوین بیشتر
                    </a>
                    <div class="dropdown-menu text-right bg-dark">
                        @forelse ($headerCateegories as $headerCateegory)
                        @if($loop->iteration >= 9)
                        <a class="nav-link px-4 py-3 nav-hover-2 active" href="{{ route('user.reports.index', $headerCateegory->slug) }}">{{$headerCateegory->name}}</a>
                        @endif
                        @empty
                        @endforelse
                    </div>
                </li>
                @endif
            </ul>
        </div>
        <section class="authorize-section">
            @guest
            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#login-modal">
                <i class="fa fa-user ml-1"></i>
                ورود/ثبت نام
            </button>
            @endguest
            @auth
            @if(auth()->user()->user_type !== 0)
            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#login-modal">
                <i class="fa fa-user ml-1"></i>
                ورود/ثبت نام
            </button>
            @else
            <a href="{{ route('user.profile.index') }}" class="btn btn-danger btn-sm">
                <i class="fa fa-user ml-1"></i>
                مشاهده حساب کاربری
            </a>
            @endif
            @endauth
        </section>
    </div>
    </div>
</nav>