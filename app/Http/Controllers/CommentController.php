<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\Models\Comment;
use App\Models\Article;

class CommentController extends Controller
{
    public function add (Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'comment' => 'required|max:301',
        ], [
            'comment.required' => 'Le commentaire est réquis.',
            'comment.max' => 'Le commentaire ne doit pas dépasser 255caractère',
        ]);

        if ($validator->fails()) {
            $errors = json_decode($validator->errors(), true);

            return redirect()->back()->with([
                'errors' => $errors
            ]);
        }

        Comment::Create([
            'content' => $request->input('comment'),
            'user_id' => auth()->user()->id,
            'article_id' => $id
        ]);

        return redirect()->back()->with([
            'success' => 'le commentaire a bien été posté',
        ]);

    }

    public function delete (Request $request, $id) {
        
        $comment = Comment::find($id);

        $comment->delete();

        return redirect()->back()->with([
            'success' => 'le commentaire a bien été supprimé',
        ]);

    }

}
