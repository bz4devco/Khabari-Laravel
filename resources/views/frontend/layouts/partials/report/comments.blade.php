@if($report->commentable)
<div class="row">
    <div class="col my-3">
        <div class="w-100 mb-3 border-bottom border-danger">
            <h3 class="title h4 border-danger text-right text-dark">نظرات</h3>
        </div>

        <!-- start show users comments button -->
        @if($report->activeComments()->count() > 0 || $report->activeGuesrComments()->count() > 0)
        @forelse ($report->activeComments() as $comment)
        <section class="bg-light border my-2 card p-3">
            <section class="report-comment">
                <section class="report-comment-header d-flex justify-content-between">
                    <section class="report-comment-title text-right"><strong>{{ ($comment->author) ? $comment->author->full_name : 'ناشناس'}}</strong></section>
                    <small class="report-comment-date text-secondary text-right">{{jalaliDate($comment->created_at)}}</small>
                </section>
                <section class="report-comment-body mr-4  text-right">
                    <i class="fa fa-comment text-secondary ml-1"></i>
                    {{ $comment->body }}
                </section>
            </section>
        </section>
        @endforeach
        @forelse ($report->activeGuesrComments() as $comment)
        <section class="bg-light border my-2 card p-3">
            <section class="report-comment">
                <section class="report-comment-header d-flex justify-content-between">
                    <section class="report-comment-title text-right"><strong>{{ ($comment->author) ? $comment->author->full_name : 'ناشناس'}}</strong></section>
                    <small class="report-comment-date text-secondary text-right">{{jalaliDate($comment->created_at)}}</small>
                </section>
                <section class="report-comment-body mr-4  text-right">
                    <i class="fa fa-comment text-secondary ml-1"></i>
                    {{ $comment->body }}
                </section>
            </section>
        </section>
        @endforeach
        @else
        <section class="report-comment">
            <section class="report-comment-body text-center py-3">
                <strong>شمار اولین نفر باشید در نظر دادن به این خبر</strong>
            </section>
        </section>
        @endif
        <br>
        <hr>
        <div class="row">
            <div class="col">
                <ul class="text-right">
                    <li>نظرات حاوی توهین و هرگونه نسبت ناروا به اشخاص حقیقی و حقوقی منتشر
                        نمی‌شود</li>
                    <li>نظراتی که غیر از زبان فارسی یا غیر مرتبط با خبر باشد منتشر نمی‌شود</li>
                </ul>
            </div>
        </div>
        <form class="mt-3" action="{{ route('user.reports.detail.comment', $report->id)}}" method="post">
            @csrf
            <div class="row mt-3">
                <div class="col-md-12">
                    <label for="body" class="float-right font-14">نظر شما :</label>
                    <textarea class="form-control" rows="4" name="body" id="body">{{old('body')}}</textarea>
                    @error('body')
                    <small class="text-danger">
                        <strong>
                            {{ $message }}
                        </strong>
                    </small>
                    @enderror
                </div>
                <div class="col-md-12 mt-3">
                    <button type="submit" class="btn btn-danger w-100">ارسال نظر</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endif