<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Page;

class UserController extends Controller
{
    public function index (Request $request) {
        $user = User::find(auth()->user()->id);

        //S'il change de page
            if ($request->input('pageId')) {

                $page = Page::where('id', $request->input('pageId'))->first();

                session(['pagePublic' => $page]);
                session()->save();
            }
        //

        if (!session()->has('pagePublic')) {
            $pageActuelle = Page::whereHas('site.user', function ($query) use ($user){
                $query->where('id', $user->id);
            })->first();

            session(['pagePublic' => $pageActuelle]);
            session()->save();
        }

        return view('authed.pages', [
            'user' => $user,
        ]);
    }

    public function config (Request $request) {
        $user = User::find(auth()->user()->id);

        //S'il change de page
            if ($request->input('pageId')) {
                $page = Page::where('id', $request->input('pageId'))->first();

                session(['pageConfig' => $page]);
                session()->save();
            }
        //

        $pages = Page::whereHas('site.user', function ($query) use ($user) {
            $query->where('id', $user->id);
        })->get();

        if (!session()->has('pageConfig')) {

            $pageActuelle = Page::whereHas('site.user', function ($query) use ($user){
                $query->where('id', $user->id);
            })->first();

            session(['pageConfig' => $pageActuelle]);
            session()->save();
        }

        return view('authed.config', [
            'user' => $user,
            'pages' => $pages
        ]);
    }

}
