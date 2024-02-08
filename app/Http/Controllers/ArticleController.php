<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\Models\Article;
use App\Models\Comment;
use App\Models\Site;
use App\Models\Text;
use App\Models\Image;

class ArticleController extends Controller
{
    public function add (Request $request) {
        $validator = Validator::make($request->all(), [
            'addArticleTitle' => 'required|max:255',
            'addArticleImage' => 'required|image',
            'addArticleContent' => 'required',
        ], [
            'addArticleTitle.required' => 'Le titre de l\'article est requis.',
            'addArticleTitle.max' => 'Le titre de l\'article ne doit pas dépasser 255 caractères.',
            'addArticleImage.required' => 'L\'image de l\'article est requise.',
            'addArticleImage.image' => 'Le fichier doit être une image.',
            'addArticleContent.required' => 'Le contenu de l\'article est requis.',
        ]);

        if ($validator->fails()) {
            $errors = json_decode($validator->errors(), true);

            return redirect()->back()->with([
                'errors' => $errors
            ]);
        }

        $site = Site::where('user_id', auth()->user()->id)->first();

        //Manip order
        $page = session('pageConfig');
        $order = Article::where('page_id', $page->id)->max('order');

        if (!$order) {
            $order = 1;
        } else {
            $order++;
        }

        $article = Article::Create([
            'title' => $request->input('addArticleTitle'),
            'order' => $order,
            'page_id' => $page->id,
        ]);

        //Manip image
        $img = $request->file('addArticleImage');
        $file = $img->getClientOriginalName();
        $info = pathinfo($file);

        $filename = $info['filename'];
        $extension = $info['extension'];

        $path = $img->storeAs('images', $filename . '_' . $article->id . '.' . $extension, 'public');

        $image = Image::Create([
            'filename' => $filename . '.' . $extension,
            'path' => $path,
            'article_id' => $article->id,
        ]);

        $text = Text::Create([
            'content' => $request->input('addArticleContent'),
            'article_id' => $article->id,
        ]);

        return redirect()->back()->with([
            'success' => 'l\'article a bien été créé',
        ]);

    }

    public function edit (Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'editArticleTitle' => 'required|max:255',
            'editArticleContent' => 'required',
        ], [
            'editArticleTitle.required' => 'Le titre de l\'article est requis.',
            'editArticleTitle.max' => 'Le titre de l\'article ne doit pas dépasser 255 caractères.',
            'editArticleContent.required' => 'Le contenu de l\'article est requis.',
        ]);

        if ($validator->fails()) {
            $errors = json_decode($validator->errors(), true);

            return redirect()->back()->with([
                'errors' => $errors
            ]);
        }

        $article = Article::where('id', $id)->first();
        $image = Image::where('article_id', $article->id)->first();
        $text = Text::where('article_id', $article->id)->first();

        $article->title = $request->input('editArticleTitle');
        $article->save();

        $text->content = $request->input('editArticleContent');
        $text->save();

        if ($request->file('editArticleImage')) {
            $img = $request->file('editArticleImage');
            $file = $img->getClientOriginalName();
            $info = pathinfo($file);

            $filename = $info['filename'];
            $extension = $info['extension'];

            $path = $img->storeAs('images', $filename . '_' . $article->id . '.' . $extension, 'public');

            $image->delete();

            Image::Create([
                'filename' => $filename . '.' . $extension,
                'path' => $path,
                'article_id' => $article->id
            ]);
        }

        return redirect()->back()->with([
            'success' => 'l\'article a bien été modifié',
        ]);

    }

    public function configArticle (Request $request, $id) {
        $article = Article::find($id);

        $comments = Comment::whereHas('article', function ($query) use ($article) {
            $query->where('id', $article->id);
        })->orderBy('created_at', 'desc')->get();

        if ($article->page->site->user->id != auth()->user()->id) {
            return redirect()->back()->with([
                'error' => 'Vous n\'avez pas le droit de configurer cette article'
            ]);
        }

        return view('authed.configArticle', [
            'article' => $article,
            'comments' => $comments
        ]);
    }

    public function getArticle (Request $request, $id) {
        $article = Article::with('text', 'image')->find($id);

        return response()->json($article, 200);
    }

    public function view (Request $request, $id) {
        $article = Article::find($id);

        $comments = Comment::whereHas('article', function ($query) use ($article) {
            $query->where('id', $article->id);
        })->orderBy('created_at', 'desc')->get();

        return view('authed.article', [
            'article' => $article,
            'comments' => $comments
        ]);
    }

    public function delete (Request $request, $id) {
        $article = Article::find($id);

        $article->delete();

        return redirect()->back()->with([
            'success' => 'L\'article a bien été supprimé',
        ]);
    }
}
