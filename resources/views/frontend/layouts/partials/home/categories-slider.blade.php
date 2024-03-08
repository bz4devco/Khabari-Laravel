@if($categoriesSlider->count() > 0)
<div class="col-md-12 mt-3 bg-dark py-2 border-danger border-bottom border-top">
    <div id="demo2" class="carousel slide" data-ride="carousel">

        <!-- The slideshow -->
        <div class="carousel-inner">
            <div class="carousel-item position-relative active">
                <div class="row">
                    @foreach ($categoriesSlider as $categorySlider)
                    @if($loop->iteration > 4)
                    @break
                    @endif

                    <div class="col-md-3">
                        @foreach ($categorySlider->reports as $report)
                        @if($loop->iteration == 1)
                        <a href="{{ route('user.reports.detail', $report)}}" target="_black" class="text-decoration-none">
                            <div class="bg-danger text-white position-absolute p-2">
                                {{$categorySlider->name}}
                            </div>
                            <img src="{{ $report->image ? hasFileUpload($report->image['indexArray'][$report->image['currentImage']]) : hasFileUpload('a.png') }}" class="w-100" style="max-height: 200px;object-fit: cover;" alt="{{$report->title}}">
                        </a>
                        @endif
                        @endforeach
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="carousel-item position-relative">
                @if($categoriesSlider->count() > 4)
                <div class="row">
                    @foreach ($categoriesSlider as $categorySlider)
                    @if($loop->iteration > 4)
                    <div class="col-md-3">
                        @foreach ($categorySlider->reports as $report)
                        @if($loop->iteration == 1)
                        <a href="{{ route('user.reports.detail', $report)}}" target="_black" class="text-decoration-none">
                            <div class="bg-danger text-white position-absolute p-2">
                                {{$categorySlider->name}}
                            </div>
                            <img src="{{ $report->image ? hasFileUpload($report->image['indexArray'][$report->image['currentImage']]) : hasFileUpload('a.png') }}" class="w-100" style="max-height: 200px;object-fit: cover;" alt="{{$report->title}}">
                        </a>
                        @endif
                        @endforeach
                    </div>
                    @endif
                    @endforeach

                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endif