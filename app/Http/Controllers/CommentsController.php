<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentsController extends Controller
{
    /**
     * Добавить комментарий к фильму
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        DB::table('comments')->insert([
            'user_id' => $request->user_id,
            'movie_id' => $request->movie_id,
            'body' => $request->body,
        ]);

        return redirect()->back();
    }

    /**
     * Удалить комментарий
     *
     * @param Comment $comment
     * @return Redirect
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return redirect()->back();
    }
}
