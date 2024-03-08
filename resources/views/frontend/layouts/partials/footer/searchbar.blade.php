@php
$category = isset($reportCategory) ? $reportCategory : '';
@endphp
<div class="row">
    <div class="col mb-5">
        <div class="input-group d-flex justify-content-center">
            <form action="{{ route('user.reports.index', $category) }}" id="footer-search" method="get">
            </form>
            <input class="search-input text-white placeholder border-light bg-danger form-control-lg w-75" type="search" form="footer-search" name="search" id="search" placeholder="جستجو خبر..." value="{{ request()->search }}">
            <button id="search-btn2" class="btn search-btn btn-light text-white border-light bg-danger btn-lg px-3" type="submit" form="footer-search" id="button-addon1"><i class="fa fa-search" aria-hidden="true"></i></button>
        </div>
    </div>
</div>