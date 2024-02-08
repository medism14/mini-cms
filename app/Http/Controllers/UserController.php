<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Page;
use App\Models\Site;

class UserController extends Controller
{

    public function index (Request $request, $siteName) {
        $user = User::find(auth()->user()->id);

        $site = Site::where('name', $siteName)->first();

        //Si une autre page que l'actuel
            if (session('pagePublic')) {
                $goodPage = false;
                foreach ($site->pages as $page) {
                    if ($page->id == session('pagePublic')->id) {
                        $goodPage = true;
                    }
                }

                if (!$goodPage) {
                    $pageActuelle = Page::where('site_id', $site->id)->first();
                    session(['pagePublic' => $pageActuelle]);
                }
            }
            
        //
        
        //Si l'utilisateur n'est pas sur son site
            if ($site->user_id != $user->id) {
                $pageActuelle = Page::where('site_id', $site->id)->first();
                session(['pagePublic' => $pageActuelle]);
            }
        //
        

        //S'il change de page ou pas
            if ($request->input('pageId')) {

                $page = Page::where('id', $request->input('pageId'))->first();
                session(['pagePublic' => $page]);

            } else if (!session('pagePublic')){

                $pageActuelle = Page::where('site_id', $site->id)->first();
                session(['pagePublic' => $pageActuelle]);

            } else {

                $pageActuelle = Page::where('id', session('pagePublic')->id)->first();
                session(['pagePublic' => $pageActuelle]);
            }
        //

        return view('authed.pages', [
            'user' => $user,
            'site' => $site
        ]);
    }

    public function config (Request $request) {
        $user = User::find(auth()->user()->id);

        //S'il change de page ou pas
            if ($request->input('pageId')) {

                $page = Page::where('id', $request->input('pageId'))->first();

                session(['pageConfig' => $page]);
            } else if (!session('pageConfig')){

                $pageActuelle = Page::whereHas('site.user', function ($query) use ($user) {
                    $query->where('id', $user->id);
                })->first();
                session(['pageConfig' => $pageActuelle]);

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
