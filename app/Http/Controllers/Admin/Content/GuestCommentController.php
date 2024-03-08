<?php

namespace App\Http\Controllers\Admin\Content;

use Carbon\Carbon;
use App\Models\GuestComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class GuestCommentController extends Controller
{

    protected $logName;


    public function __construct()
    {
        $this->logName = Log::build(['driver' => 'single', 'path' => storage_path('logs/guest-comment-admin.log')]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = GuestComment::where('commentable_type', 'App\Models\Content\Report')
            ->orderBy('seen', 'asc')
            ->orderBy('approved', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.contents.guest-comment.index', compact('comments'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(GuestComment $comment)
    {

        if ($comment->seen == 0) {
            // update seen comment when comment showed with admin
            GuestComment::where('id', $comment->id)->update(['seen' => 1]);
        }

        return view('admin.contents.guest-comment.show', compact('comment'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status(GuestComment $comment)
    {
        $comment->status = $comment->status == 0 ? 1 : 0;
        $result = $comment->save();

        // set log  message
        Log::stack(['slack', $this->logName])->info('admin status guest comment', [
            'admin' => auth()->user()->full_name,
            'comment_id' => $comment->id,
            'opration' => 'status',
            'value_set' => $comment->status,
            'deleted_at' => Carbon::now(),
        ]);

        if ($result) {
            if ($comment->status == 0) {
                return response()->json(['status' => true, 'checked' => false, 'id' => $comment->id]);
            } else {
                return response()->json(['status' => true, 'checked' => true, 'id' => $comment->id]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approved(GuestComment $comment)
    {
        $comment->approved = $comment->approved == 0 ? 1 : 0;
        $result = $comment->save();


        // set log  message
        Log::stack(['slack', $this->logName])->info('admin approved guest comment', [
            'admin' => auth()->user()->full_name,
            'comment_id' => $comment->id,
            'opration' => 'approved',
            'value_set' => $comment->approved,
            'deleted_at' => Carbon::now(),
        ]);


        if ($result) {
            if ($comment->approved == 0) {
                return response()->json(['approved' => true, 'checked' => false, 'id' => $comment->id]);
            } else {
                return response()->json(['approved' => true, 'checked' => true, 'id' => $comment->id]);
            }
        } else {
            return response()->json(['approved' => false]);
        }
    }
}
