<div class="w-75 m-auto border-bottom border-danger">
    <h3 class="title h4 border-danger text-center text-white">کانال های خبری</h3>
</div>
<ul class="bold list-unstyled mt-4 p-0 d-flex justify-content-center">
    @if($setting->instagram)
    <li class="nav-item mx-3">
        <a class="nav-link text-white media-icon py-2 px-2 text-hover" href="http://www.instagram.com/" data-toggle="tooltip" data-placement="bottom" title="صفحه خبر در اینستاگرام"><i class="fa fa-instagram ml-2 text-hover" aria-hidden="true"></i></a>
    </li>
    @endif
    @if($setting->telegram)
    <li class="nav-item mx-3">
        <a class="nav-link text-white media-icon py-2 px-2 " href="http://www.telegram.org/" data-toggle="tooltip" data-placement="bottom" title="کانال خبری  تلگرام"><i class="fa fa-telegram ml-2 text-hover" aria-hidden="true"></i></a>
    </li>
    @endif
    @if($setting->twitter)
    <li class="nav-item mx-3">
        <a class="nav-link text-white media-icon py-2 px-2 text-hover" href="http://www.twittercom/" data-toggle="tooltip" data-placement="bottom" title="صفحه خبری در توییتر"><i class="fa fa-twitter ml-2 text-hover" aria-hidden="true"></i></a>
    </li>
    @endif
</ul>