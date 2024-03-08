<div class="row">
    <div class="col-12 mt-4">
        <ul class="nav nav-tabs border-bottom border-danger bg-light">
            @if($sideBarHotReports->count() > 0)
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#home"><i class="fa fa-newspaper-o"></i></a>
            </li>
            @endif
            @if($setting->keywords)
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#menu1"><i class="fa fa-tags"></i></a>
            </li>
            @endif
            @if($sidebarComments->count() > 0)
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#menu2"><i class="fa fa-comments-o"></i></a>
            </li>
            @endif
        </ul>

        <!-- Tab panes -->
        <div class="tab-content bg-light py-2">
            @if($sideBarHotReports->count() > 0)
            <div id="home" class="container tab-pane active"><br>
                <ul>
                    @foreach ($sideBarHotReports as $sideBarHotReport)
                    <li class="p-3 border-bottom b1 border-light text-right text-dark">
                        <a href="{{ route('user.reports.detail', $sideBarHotReport) }}" target="_black" class="text-decoration-none  text-hover">{{$sideBarHotReport->title}}</a>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif
            @if($setting->keywords)
            <div id="menu1" class="container tab-pane fade"><br>
                @php
                $tags = $setting->keywords ? explode(',', $setting->keywords) : null;
                @endphp
                <ul class="list-unstyled p-0">
                    <li class="d-flex flex-wrap font-14">
                        @foreach ($tags as $tag)
                        <a href="{{ route('user.reports.index', ['search' => $tag ]) }}" target="_black" class="bg-black text-white text-decoration-none bg-hover p-2  m-2">
                            {{$tag}}
                        </a>
                        @endforeach

                    </li>
                </ul>
            </div>
            @endif

            @if($sidebarComments->count() > 0)
            <div id="menu2" class="container tab-pane fade"><br>
                <ul class="list-unstyled p-0">
                    <li class="py-1">
                        @foreach ($sidebarComments as $sidebarComment)
                        <div class="media text-right">
                            <img src="{{ hasFileUpload($sidebarComment->author->profile_photo_path, 'avatar') }}" alt="avatar" class="mr-3 mt-3 rounded-circle" style="width:52px;">
                            <div class="media-body">
                                <h4 class="h5 mt-4 mr-2"> {{$sidebarComment->author->full_name}} : </h4>
                                <div class="media p-2">
                                    <div class="media-body bg-white rounded p-3 text-justify m-t">
                                        <p class="font-14">{{$sidebarComment->body}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </li>
                </ul>
            </div>
            @endif
        </div>
    </div>
</div>