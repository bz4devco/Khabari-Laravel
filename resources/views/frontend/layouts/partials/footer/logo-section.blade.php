<div class="col-md-2">
    <a href="{{ route('user.home') }}" class="text-decoration-none">
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <img class="card-img logo-img"  src="{{ hasFileUpload($setting->logo) }}" alt="footer-logo">
            </div>
            <div class="col-12 mt-3 mb-5 text-center">
                <div class="col-12 p-0">
                    <h1 class="h2 bold text-white">{{ $setting->title }}</h1>
                </div>
                <div class="col-12 p-0">
                    <h5 class="text-white">اخبار روز جهان و ایران</h1>
                </div>
            </div>
        </div>
    </a>
</div>