@if ($sidebarLatestReports)
<div class="row">
    <div class="col mt-4">
        <div class="w-100 mb-3 border-bottom border-danger">
            <a href="{{ route('user.profile.index') }}" target="_black" class="text-decoration-none">
                <h3 class="title h4 border-danger text-right text-hover text-dark">عناوین خبر</h3>
            </a>
        </div>

        @foreach ($sidebarLatestReports as $sidebarLatestReport)
        <div class="card mb-3 border-0" style="max-width: 650px;">
            <div class="row no-gutters border-bottom b1 border-light">
                <div class="col-lg-12 align-self-center">
                    <a href="{{ route('user.reports.detail', $sidebarLatestReport) }}" target="_black" class="text-decoration-none align-self-center text-dark">
                        <img src="{{ $sidebarLatestReport->image ? hasFileUpload($sidebarLatestReport->image['indexArray'][$sidebarLatestReport->image['currentImage']]) : hasFileUpload('a.png') }}" alt="{{$sidebarLatestReport->title}}" class="w-100" style="max-height: 180px;object-fit: cover;">
                    </a>
                </div>
                <div class="col-md-12">
                    <div class="card-body text-right">
                        <a href="{{ route('user.reports.detail', $sidebarLatestReport) }}" target="_black" class="text-decoration-none text-dark">
                            <h5 class="card-title text-hover">{!! strip_tags(Str::limit($sidebarLatestReport->title, 25)) !!}</h5>
                        </a>
                        <p class="card-text">{!! strip_tags(Str::limit($sidebarLatestReport->abstract, 60)) !!}</p>
                        <p class="card-text">
                        <div class="time-dallas font-10 mt-2">
                            <span class=""><i class="fa fa-clock-o"></i>
                                {{ jalaliDate($sidebarLatestReport->new_date, 'H:i %d/%m/%Y')}}
                            </span>
                            <a href="javascript:void(0);" target="_black" class="text-decoration-none text-hover"><i class="fa fa-comment-o mr-3"></i>
                                {{$sidebarLatestReport->comments()->count()}} نظر
                            </a>
                            <a href="javascript:void(0);" target="_black" class="text-decoration-none text-hover"><i class="fa fa-eye mr-3"></i>
                                {{$sidebarLatestReport->visit_counter}} بازدید
                            </a>
                        </div>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

    </div>
</div>
@endif