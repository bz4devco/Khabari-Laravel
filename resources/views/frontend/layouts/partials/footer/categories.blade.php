@if ($footerCategories->count() > 0)
<div class="col-md-5">
    <div class="row">
        <div class="col-12">
            <div class="w-75 mb-4  border-bottom border-danger">
                <h3 class="title h4 border-danger text-right text-white">دسته بندی ها</h3>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-6">
            <ul class="list-unstyled text-right p-0 font-14">
                @foreach ($footerCategories as $footerCategory)
                @if($loop->iteration % 2 != 0)
                <li class="mb-2">
                    <a href="{{ route('user.reports.index', $footerCategory) }}" class="text-white text-decoration-none text-hover">
                        {{$footerCategory->name}}
                    </a>
                </li>
                @endif
                @endforeach
            </ul>
        </div>
        <div class="col-md-6 col-sm-6">
            <ul class="list-unstyled text-right p-0 font-14">
                @foreach ($footerCategories as $footerCategory)
                @if($loop->iteration % 2 == 0)
                <li class="mb-2">
                    <a href="{{ route('user.reports.index', $footerCategory) }}" class="text-white text-decoration-none text-hover">
                        {{$footerCategory->name}}
                    </a>
                </li>
                @endif
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endif