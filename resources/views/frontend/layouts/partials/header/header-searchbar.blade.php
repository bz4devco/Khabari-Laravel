@php
$category = isset($reportCategory) ? $reportCategory : '';
@endphp
<nav class="container-fluid bg-light">
    <div class="row  max-width m-auto">
        <div class="col-md-1 bg-danger  d-lg-block d-none text-center text-white bold py-2">اخبار تازه <i class="fa fa-chevron-left mr-2" aria-hidden="true"></i></div>
        <div class="col-md-7 d-lg-block d-none">
            <div class="s-wrap">
                <div class="s-move text-right">
                    @forelse ($latestReports as $report)
                    <div class="slide">
                        <a href="{{ route('user.reports.detail', $report) }}" class="text-decoration-none text-dark">
                            <p>
                                [{{ jalaliDate($report->new_date, '%d %m %Y') }}] {{$report->title}} <i class="fa fa-caret-left mr-2"></i> <span class="category-news">{{$report->category->name}}</span>
                            </p>
                        </a>
                    </div>
                    @empty
                    @endforelse
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="input-group d-flex justify-content-center">
                <form action="{{ route('user.reports.index', $category) }}" id="header-search" method="get">
                </form>
                <input class="search-input form-control-sm w-75" form="header-search" type="search" name="search" id="search" placeholder="جستجو خبر..."  value="{{ request()->search }}">
                <button id="search-btn" class="btn search-btn btn-outline-secondary btn-sm px-3" form="header-search" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
            </div>
        </div>
    </div>
</nav>