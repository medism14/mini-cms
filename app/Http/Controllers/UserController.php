<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Page;

class UserController extends Controller
{
    public function index (Request $request) {
        $user = User::find(auth()->user()->id);

        //S'il change de page ou pas
            if ($request->input('pageId')) {

                $page = Page::where('id', $request->input('pageId'))->first();

                session(['pagePublic' => $page]);
            } else {

            $pageActuelle = Page::where('id', session('pagePublic')->id)->first();

            session(['pagePublic' => $pageActuelle]);
        }
    //

        return view('authed.pages', [
            'user' => $user,
        ]);
    }

    public function config (Request $request) {
        $user = User::find(auth()->user()->id);

        //S'il change de page ou pas
            if ($request->input('pageId')) {

                $page = Page::where('id', $request->input('pageId'))->first();

                session(['pageConfig' => $page]);
            } else {

                $pageActuelle = Page::where('id', session('pageConfig')->id)->first();

                session(['pageConfig' => $pageActuelle]);
            }
        //

        $pages = Page::whereHas('site.user', function ($query) use ($user) {
            $query->where('id', $user->id);
        })->get();

        return view('authed.config', [
            'user' => $user,
            'pages' => $pages
        ]);
    }

}
