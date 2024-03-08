<?php

namespace App\Http\Controllers\Admin\Content;

use Carbon\Carbon;
use App\Models\Comment;
use App\Models\GuestComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\CommentRequest;

class CommentController extends Controller
{

    protected $logName;


    public function __construct()
    {
        $this->logName = Log::build(['driver' => 'single', 'path' => storage_path('logs/comment-admin.log')]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::where('commentable_type', 'App\Models\Content\Report')
            ->orderBy('seen', 'asc')
            ->orderBy('approved', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.contents.comment.index', compact('comments'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {

        if ($comment->seen == 0) {
            // update seen comment when comment showed with admin
            Comment::where('id', $comment->id)->update(['seen' => 1]);
        }

        return view('admin.contents.comment.show', compact('comment'));
    }




    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status(Comment $comment)
    {
        $comment->status = $comment->status == 0 ? 1 : 0;
        $result = $comment->save();

        // set log  message
        Log::stack(['slack', $this->logName])->info('admin status comment', [
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
    public function approved(Comment $comment)
    {
        $comment->approved = $comment->approved == 0 ? 1 : 0;
        $result = $comment->save();

        // set log  message
        Log::stack(['slack', $this->logName])->info('admin approved comment', [
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
