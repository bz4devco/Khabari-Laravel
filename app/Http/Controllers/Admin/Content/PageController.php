<?php

namespace App\Http\Controllers\Admin\Content;

use Carbon\Carbon;
use App\Models\Content\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Services\Image\ImageService;
use App\Http\Requests\Admin\Content\PageRequest;

class PageController extends Controller
{

    protected $logName;


    public function __construct()
    {
        $this->logName = Log::build(['driver' => 'single', 'path' => storage_path('logs/page-admin.log')]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Page::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.contents.page.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.contents.page.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PageRequest $request, page $page)
    {
        $inputs = $request->all();
        $inputs['slug'] = trim(str_replace(' ', '-', 'slug'));
        $inputs['body'] = checkEditorXss($inputs['body']);
        $page->create($inputs);

        // set log  message
        Log::stack(['slack', $this->logName])->info('admin create page', [
            'author' => auth()->user()->full_name,
            'page_title' => $inputs['title'],
            'opration' => 'create',
            'created_at' => Carbon::now(),
        ]);

        return redirect()->route('admin.content.page.index')
            ->with('alert-section-success', 'پیج جدید شما با موفقیت ثبت شد');
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadImagesCkeditor(Request $request, ImageService $imageService)
    {
        $request->validate([
            'upload' => 'sometimes|required|max:10240|image|mimes:png,jpg,jpeg,gif,ico,svg,webp'
        ]);
        // image Upload
        if ($request->hasFile('upload')) {
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'page-body');
            $url = $imageService->save($request->file('upload'));
            $url = str_replace('\\', '/', $url);
            $url = asset($url);

            return "<script>window.parent.CKEDITOR.tools.callFunction(1, '{$url}' , '')</script>";
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        return view('admin.contents.page.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PageRequest $request, Page $page)
    {
        $page->update($request->all());

        $inputs = $request->all();


        // set log  message
        Log::stack(['slack', $this->logName])->info('admin update page', [
            'author' => auth()->user()->full_name,
            'page_title' => $inputs['title'],
            'opration' => 'update',
            'data_changed' => '(' . implode(',', $inputs) . ')',
            'updated_at' => Carbon::now(),
        ]);


        return redirect()->route('admin.content.page.index')
            ->with('alert-section-success', 'ویرایش پیج با عنوان  ' . $page['title'] . ' با موفقیت انجام شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        $result = $page->delete();
        return redirect()->route('admin.content.page.index')
            ->with('alert-section-success', ' پیج با عنوان ' . $page->title . ' با موفقیت حذف شد');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status(Page $page)
    {
        $page->status = $page->status == 0 ? 1 : 0;
        $result = $page->save();

        if ($result) {
            if ($page->status == 0) {
                return response()->json(['status' => true, 'checked' => false, 'id' => $page->title]);
            } else {
                return response()->json(['status' => true, 'checked' => true, 'id' => $page->title]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }
}
