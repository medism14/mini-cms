<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Site;
use App\Models\Page;
use App\Models\Menu;
class AuthController extends Controller {

    public function login(Request $request) {

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('users.dashboard');
        } else {
            return redirect()->back()->with([
                'errors' => "Email ou mot de passe incorrect",
            ]);
        }

    }

    public function register (Request $request) {
        
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'mdp' => 'required',
        ], [
            'first_name.required' => 'Le prénom est requis.',
            'last_name.required' => 'Le nom est requis.',
            'email.required' => 'L\'adresse e-mail est requise.',
            'email.email' => 'L\'adresse e-mail doit être valide.',
            'phone.required' => 'Le numéro de téléphone est requis.',
            'mdp.required' => 'Le mot de passe est requis.',
        ]);

        if ($validator->fails()) {
            $errors = json_decode($validator->errors(), true);

            return redirect()->back()->with([
                'errors' => $errors
            ]);
        }

        $first_name = $request->input('first_name');
        $last_name = $request->input('last_name');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $password = $request->input('password');

        $user = User::create([
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'phone' => $phone,
            'password' => Hash::make($password)
        ]);

        $site = Site::Create([
            'name' => 'monSite',
            'font_color' => 'black',
            'background_color' => '#F2F4F2',
            'section_color' => '#C2DCBC',
            'user_id' => $user->id
        ]);

        $page = Page::Create([
            'name' => 'Index',
            'order' => 1,
            'site_id' => $site->id
        ]);

        $menu = Menu::Create([
            'type' => 'burger',
            'site_id' => $site->id
        ]);

        Auth::login($user);

        return redirect()->route('users.dashboard')->with([
            'success' => 'Vous avez bien été créé'
        ]);
    }

    public function logout (Request $request) {
        Auth::logout();
        return redirect('/');
    }

}
 