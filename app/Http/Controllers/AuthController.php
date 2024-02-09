<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Site;
use App\Models\Page;
use Illuminate\Support\Facades\Session;
use App\Models\Menu;

class AuthController extends Controller {

    public function login(Request $request) {
        // Récupère les identifiants de connexion (email et mot de passe) à partir de la requête.
        $credentials = $request->only('email', 'password');
    
        // Tente de connecter l'utilisateur avec les identifiants fournis.
        if (Auth::attempt($credentials)) {
            // Récupère le site associé à l'utilisateur connecté.
            $site = Site::where('user_id', auth()->user()->id)->first();
    
            // Redirige l'utilisateur vers le tableau de bord de son site.
            return redirect()->route('site.dashboard', ['siteName' => $site->name]);
        } else {
            // Redirige l'utilisateur vers la page précédente avec un message d'erreur.
            return redirect()->back()->with([
                'errors' => "Email ou mot de passe incorrect",
            ]);
        }
    }

    public function register (Request $request) {
        // Validation des données du formulaire d'inscription.
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required',
            'mdp' => 'required',
        ], [
            // Messages d'erreur personnalisés pour les règles de validation.
            'first_name.required' => 'Le prénom est requis.',
            'last_name.required' => 'Le nom est requis.',
            'email.required' => 'L\'adresse e-mail est requise.',
            'email.email' => 'L\'adresse e-mail doit être valide.',
            'phone.required' => 'Le numéro de téléphone est requis.',
            'mdp.required' => 'Le mot de passe est requis.',
        ]);
    
        // Si la validation échoue, redirige l'utilisateur vers la page précédente avec les erreurs.
        if ($validator->fails()) {
            $errors = json_decode($validator->errors(), true);
            return redirect()->back()->with([
                'errors' => $errors
            ]);
        }
    
        // Crée un nouvel utilisateur avec les données fournies.
        $first_name = $request->input('first_name');
        $last_name = $request->input('last_name');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $password = $request->input('mdp');
    
        $user = User::create([
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'phone' => $phone,
            'password' => Hash::make($password)
        ]);
    
        // Crée un nouveau site, une nouvelle page et un nouveau menu pour l'utilisateur.
        $site = Site::Create([
            'name' => 'monSite',
            'font_color' => '#333333',
            'background_color' => '#D8E5EB',
            'section_color' => '#40535B',
            'user_id' => $user->id
        ]);
    
        $page = Page::Create([
            'name' => 'Index',
            'site_id' => $site->id
        ]);
    
        $menu = Menu::Create([
            'type' => 'burger',
            'site_id' => $site->id
        ]);
    
        // Connecte l'utilisateur après l'inscription.
        Auth::login($user);
    
        // Redirige l'utilisateur vers le tableau de bord de son site avec un message de succès.
        return redirect()->route('site.dashboard', ['siteName' => $user->site->name])->with([
            'success' => 'Vous avez bien été créé'
        ]);
    }

    public function logout (Request $request) {
        Auth::logout();

        Session::flush();

        return redirect('/');
    }

}
 