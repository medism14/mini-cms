<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\Models\Page;
use App\Models\Site;

class PageController extends Controller
{
    public function add (Request $request) {
        $validator = Validator::make($request->all(), [
            'pageName' => 'required'
        ], [
            'pageName.required' => 'Veuillez entrer le nom de la page'
        ]);

        if ($validator->fails()) {
            $errors = json_decode($validator->errors(), true);

            return redirect()->back()->with([
                'errors' => $errors
            ]);
        }

        $site = Site::where('user_id', auth()->user()->id)->first();
        Page::where('site_id', $site->id);

        $page = Page::create([
            'name' => $request->input('pageName'),
            'site_id' => $site->id
        ]);

        return redirect()->back()->with([
            'success' => 'La page a bien été créé',
        ]);
    }

    public function edit (Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'editPageName' => 'required'
        ], [
            'editPageName.required' => 'Veuillez entrer le nom de la page'
        ]);

        if ($validator->fails()) {
            $errors = json_decode($validator->errors(), true);

            return redirect()->back()->with([
                'errors' => $errors
            ]);
        }

        $page = Page::find($id);
        $page->name = $request->input('editPageName');
        $page->save();

        return redirect()->back()->with([
            'success' => 'La page a bien été modifié',
        ]);
    }

    public function getPage ($id) {
        $page = Page::find($id);

        return response()->json($page, 200);
    }

    public function delete (Request $request, $id) {
        
        $site = Site::where('user_id', auth()->user()->id)->first();

        $count = Page::where('site_id', $site->id)->count();

        if ($count == 1) {
            return redirect()->back()->with([
                'errors' => 'Vous devez laisser au moins une page', 
            ]);
        }
        
        $page = Page::find($id);
        
        $page->delete();

        return redirect()->back()->with([
            'delete' => 'La page a bien été supprimée',
        ]);
    }
}
