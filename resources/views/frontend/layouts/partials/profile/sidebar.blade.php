@php
$myProfileActive = Request::url() === route('user.profile.index') ? 'text-danger' : '';
$myFavoriteActive = Request::url() === route('user.profile.comments') ? 'text-danger' : '';
$myCommentsActive = Request::url() === route('user.profile.favorites') ? 'text-danger' : '';

@endphp

<section class="col-md-3 my-2">
    <div class="modal-content text-right ">
        <div class="modal-body">
            <ul class="list-unstyled pr-3">
                <li class="py-3">
                    <strong>
                        <a href="{{route('user.profile.index')}}" class="text-decoration-none {{ $myProfileActive }}"> <i class="fa fa-user fa-lg ml-1"></i> اطلاعات کاربری</a>
                    </strong>
                </li>
                <li class="py-3">
                    <strong>
                        <a href="{{route('user.profile.comments')}}" class="text-decoration-none {{ $myFavoriteActive }}"> <i class="fa fa-comments fa-lg ml-1"></i> لیست نظرات من</a>
                    </strong>
                </li>
                <li class="py-3">
                    <strong>
                        <a href="{{route('user.profile.favorites')}}" class="text-decoration-none {{ $myCommentsActive }}"> <i class="fa fa-list fa-lg ml-1"></i> لیست علاقه مندی ها</a>
                    </strong>
                </li>
                <li class="pt-3">
                    <strong>
                        <a href="{{route('user.auth.logout')}}" class="text-decoration-none"> <i class="fa fa-sign-out fa-lg ml-1"></i> خروج از حساب</a>
                    </strong>
                </li>
            </ul>
        </div>
    </div>
</section>