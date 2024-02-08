<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\Menu;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class SiteController extends Controller
{
    public function editSiteName (Request $request) {
        
        $validator = Validator::make($request->all(), [
            'siteName' => 'unique:sites,name'
        ], [
            'siteName.unique' => 'Le nom du site doit être unique'
        ]);

        if ($validator->fails()) {
            $errors = json_decode($validator->errors(), true);

            return redirect()->back()->with([
                'errors' => $errors,
            ]);
        }

        $site = Site::where('user_id', auth()->user()->id)->first();

        $sites = Site::all();



        $site->name = $request->input('siteName');
        $site->save();

        return redirect()->back()->with([
            'success' => 'Le site a bien été mis à jour'
        ]);
    }

    public function editMenuType (Request $request) {
        $site = Site::where('user_id', auth()->user()->id)->first();
        
        $menu = Menu::where('site_id', $site->id)->first();
        
        $menu->type = $request->input('typeMenu');
        $menu->save();

        return redirect()->back()->with([
            'success' => 'Le site a bien été mis à jour'
        ]);
    }

    public function editBackgroundColor (Request $request) {
        $site = Site::where('user_id', auth()->user()->id)->first();
        
        $site->background_color = $request->input('backgroundColor');
        $site->save();

        return redirect()->back()->with([
            'success' => 'Le site a bien été mis à jour'
        ]);
    }

    public function editFontColor (Request $request) {
        $site = Site::where('user_id', auth()->user()->id)->first();

        $site->font_color = $request->input('fontColor');
        $site->save();

        return redirect()->back()->with([
            'success' => 'Le site a bien été mis à jour'
        ]);
    }

    public function editSectionColor (Request $request) {
        $site = Site::where('user_id', auth()->user()->id)->first();

        $site->section_color = $request->input('sectionColor');
        $site->save();

        return redirect()->back()->with([
            'success' => 'Le site a bien été mis à jour'
        ]);
    }
}
