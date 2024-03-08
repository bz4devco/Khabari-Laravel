<!-- NAVIGATION -->
<nav class="navbar navbar-expand-lg py-0 navbar-dark bg-danger">
        <div class="container-fluid max-width">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="col-md-2 col-6 d-block bold d-lg-none navbar-nav text-white d-flex"><span class="mr-auto mt-0">{{jalaliDate(now(), '%A %d %B %Y')}}</span></div>
            <div class="collapse col-md-10 pr-0 col-12 text-center navbar-collapse" id="navbarNav">
                <ul class="col-lg-6 col-12 pr-0 navbar-nav">
                    @if ($headerPages->count() > 0) 
                    @foreach ($headerPages as $headerPage)
                    <li class="nav-item bold active">
                        <a class="nav-link py-2 px-4 nav-hover" href="{{ $headerPage->url ? route('user.pages', $headerPage) : '#' }}">{{$headerPage->title}}</a>
                    </li>
                    @endforeach
                    @endif
                </ul>
                <ul class="col-lg-6 col-12 bold float-left navbar-nav d-flex justify-content-end">
                    @if($setting->instagram)
                    <li class="nav-item ml-2 active">
                        <a class="nav-link py-2 px-2 nav-hover" href="{{ $setting->instagram }}"><i class="fa fa-instagram ml-2" aria-hidden="true"></i>اینستاگرام</a>
                    </li>
                    @endif
                    @if($setting->telegram)
                    <li class="nav-item ml-2 active">
                        <a class="nav-link py-2 px-2 nav-hover" href="{{ $setting->telegram }}"><i class="fa fa-telegram ml-2" aria-hidden="true"></i>تلگرام</a>
                    </li>
                    @endif
                    @if($setting->twitter)
                    <li class="nav-item ml-2 active">
                        <a class="nav-link py-2 px-2 nav-hover" href="{{ $setting->twitter }}"><i class="fa fa-twitter ml-2" aria-hidden="true"></i>توییتر</a>
                    </li>
                    @endif
                    <li class="nav-item ml-2 active">
                        <a class="nav-link py-2 px-2 nav-hover" href="http://www.varzesh3.com/"><i class="fa fa-play ml-2" aria-hidden="true"></i>نتایج زنده</a>
                    </li>
                    <li class="nav-item ml-2 active">
                        <a class="nav-link py-2 px-2 nav-hover" href="https://www.varzesh3.com/table/%d8%ac%d8%af%d9%88%d9%84-%d9%84%d9%8a%da%af-%d8%a8%d8%b1%d8%aa%d8%b1-%d8%a7%db%8c%d8%b1%d8%a7%d9%86-00-99"><i class="fa fa-bullseye ml-2" aria-hidden="true"></i>جداول لیگ</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-2 col-sm-3 col-3 d-lg-block bold d-none navbar-nav text-white"><span class="mr-auto mt-0">{{jalaliDate(now(), '%A %d %B %Y')}}</span></div>
        </div>
    </nav>