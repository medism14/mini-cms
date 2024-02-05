@extends('layouts.guestLayouts')

@section('title', 'Inscription')


@section('content')
    <h1 class="text-center text-2xl bg-gray-700 rounded-lg rounded-b-none w-[80%] md:w-[70%] mx-auto mt-10 text-white p-5">Inscription</h1>
    <section class=" p-5 w-[80%] md:w-[70%] bg-[#BACFF0] mx-auto rounded-t-none rounded-lg flex flex-col pb-10 mb-16">
        <form action="{{ route('register') }}" method="POST" class="m-0 p-0" onsubmit="return confirmMDP()">
        @csrf
        <!-- Row -->
        <div class="md:flex w-full items-center mt-3">
            <div class="flex-1 flex flex-col space-y-1 items-center justify-center mb-3 md:mb-0">
                <label for="first_name">Prenom:</label>
                <input id="first_name" name="first_name" type="text" class="outline-none focus:ring focus:border-blue-100 rounded w-[90%] shadow-md p-1">
            </div>

            <div class="flex-1 flex flex-col space-y-1 items-center justify-center">
                <label for="last_name">Nom:</label>
                <input id="last_name" name="last_name" type="text" class="outline-none focus:ring focus:border-blue-100 rounded w-[90%] shadow-md p-1">
            </div>
        </div>  

        <!-- Row -->
        <div class="md:flex w-full items-center mt-5">
            <div class="flex-1 flex flex-col space-y-1 items-center justify-center">
                <label for="email">Email:</label>
                <input id="email" name="email" type="email" class="outline-none focus:ring focus:border-blue-100 rounded w-[90%] shadow-md p-1">
            </div>

            <div class="flex-1 flex flex-col space-y-1 items-center justify-center mb-3 md:mb-0">
                <label for="phone">Telephone:</label>
                <input id="phone" name="phone" type="number" class="outline-none focus:ring focus:border-blue-100 rounded w-[90%] shadow-md p-1">
            </div>
        </div>  

        <!-- Row -->
        <div class="md:flex w-full items-center mt-5">
            <div class="flex-1 flex flex-col space-y-1 items-center justify-center mb-3 md:mb-0">
                <label for="mdp">Mot de passe:</label>
                <input id="mdp" name="mdp" type="password" class="outline-none focus:ring focus:border-blue-100 rounded w-[90%] shadow-md p-1">
            </div>

            <div class="flex-1 flex flex-col space-y-1 items-center justify-center">
                <label for="mdp_confirmation">Confirmation de mot de passe:</label>
                <input id="mdp_confirmation" name="mdp_confirmation" type="password" class="outline-none focus:ring focus:border-blue-100 rounded w-[90%] shadow-md p-1">
            </div>
        </div>

        <!-- Row -->
        <div class="flex space-x-10 w-full items-center mt-10">
            <!-- Column -->
            <div class="flex-1 flex space-y-1 items-center justify-end">
                <button class="px-3 py-2 bg-blue-500 text-white rounded-lg transition-all duration-300 hover:bg-blue-600">S'inscrire</button>
            </div>
            <!-- Column -->
            <div class="flex-1 flex space-y-1 items-center justify-start">
                <button class="px-3 py-2 bg-red-500 text-white rounded-lg transition-all duration-300 hover:bg-red-600">Annuler</button>
            </div>
        </div>
        </form>
    </section>

@endsection

@section('scripts')
    <script>
        const confirmMDP = () => {
            const mdp = document.getElementById('mdp');
            const mdp_confirmation = document.getElementById('mdp_confirmation');

            if (mdp.value.length < 5) { 
                alert('Le mot de passe doit être supérieur à 5 lettre');
                return false;
            }

            if (mdp.value != mdp_confirmation.value) {
                alert('Les mots de passe ne se correspondent pas');
                return false;
            }

            return true;
        }
    </script>
@endsection