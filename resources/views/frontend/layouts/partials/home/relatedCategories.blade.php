@if($mainCategoryReports->count() >= 3)
<div class="col-md-12">
    <div class="row">
        @foreach ($mainCategoryReports as $mainCategoryReport)
        @if($loop->iteration > 2)
        <div class="col-md-4">
            <div class="w-100 mt-4  border-bottom border-danger">
                <a href="sport.html" class="text-decoration-none">
                    <h3 class="title h4 border-danger text-right text-hover text-dark">{{$mainCategoryReport->name}}</h3>
                </a>
            </div>
            @foreach ($mainCategoryReport->reports as $report)
            @if($loop->iteration == 1)
            <a href="{{ route('user.reports.detail', $report) }}" target="_black" class="text-decoration-none text-right">
                <div class="card mt-3 mb-2 border-bottom b1 border-light">
                    <img class="card-img-top" src="{{ $report->image ? hasFileUpload($report->image['indexArray'][$report->image['currentImage']]) : hasFileUpload('a.png') }}" alt="{{ $report->title }}" style="width:100%;max-height: 180px;object-fit: cover;">
                    <div class="card-body">
                        <h4 class="card-title text-dark text-hover">{{ strip_tags(Str::limit($report->title, 25)) }}</h4>
                        <p class="card-text text-dark">{{ strip_tags(Str::limit($report->body, 60)) }}</p>
                    </div>
                    <div class="card-footer text-right">
                        <div class="time-dallas font-10 mt-2">
                            <span class="text-dark"><i class="fa fa-clock-o"></i>
                                {{ jalaliDate($report->new_date, '%a %d %b %Y H:i:s')}}
                            </span>
                            <a href="javascript:void(0);" target="_black" class="text-decoration-none text-hover"><i class="fa fa-comment-o mr-3"></i>
                                {{$report->comments()->count()}} نظر
                            </a>
                            <a href="javascript:void(0);" target="_black" class="text-decoration-none text-hover"><i class="fa fa-eye mr-3"></i>
                                {{$report->visit_counter}} بازدید
                            </a>
                        </div>
                    </div>
                </div>
            </a>
            @endif
            @if($loop->iteration > 1)
            <div class="card border-0" style="max-width: 540px;">
                <div class="row no-gutters border-bottom b1 border-light">
                    <div class="col-lg-4 align-self-center">
                        <a href="{{ route('user.reports.detail', $report) }}" target="_black" class="text-decoration-none align-self-center text-dark">
                            <img src="{{ $report->image ? hasFileUpload($report->image['indexArray'][$report->image['currentImage']]) : hasFileUpload('a.png') }}" alt="{{ $report->title }}" class="card-img">
                        </a>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body text-right">
                            <a href="{{ route('user.reports.detail', $report) }}" target="_black" class="text-decoration-none text-dark">
                                <h5 class="card-title text-hover">{{ strip_tags(Str::limit($report->title, 25)) }}</h5>
                            </a>
                            <p class="card-text">{{ strip_tags(Str::limit($report->body, 60)) }}</p>
                            <p class="card-text">
                            <div class="time-dallas font-10 mt-2">
                                <span class="text-dark"><i class="fa fa-clock-o"></i>
                                    {{ jalaliDate($report->new_date, '%a %d %b %Y H:i:s')}}
                                </span>
                                <a href="javascript:void(0);" target="_black" class="text-decoration-none text-hover"><i class="fa fa-comment-o mr-3"></i>
                                    {{$report->comments()->count()}} نظر
                                </a>
                                <a href="javascript:void(0);" target="_black" class="text-decoration-none text-hover"><i class="fa fa-eye mr-3"></i>
                                    {{$report->visit_counter}} بازدید
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if($loop->iteration > 5)
            @break
            @endif
            @endforeach
        </div>
        @endif

        @endforeach


    </div>
</div>
@endif