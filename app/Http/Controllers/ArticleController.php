<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\Models\Article;
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
            'filename' => $filename,
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

    public function configArticle (Request $request, $id) {

    }

    public function getArticle (Request $request, $id) {
        $article = Article::find($id);

        return response()->json($article, 200);
    }

    public function view (Request $request, $id) {

    }

    public function delete (Request $request, $id) {
        $article = Article::find($id);

        $article->delete();

        return redirect()->back()->with([
            'success' => 'L\'article a bien été supprimé',
        ]);
    }
}
