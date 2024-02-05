@extends('layouts.guestLayouts')

@section('title', 'Authentification')


@section('content')
    <h1 class="text-center mt-10 text-2xl font-bold">CMS Blog</h1>

    <h1 class="text-center text-2xl bg-gray-700 rounded-lg rounded-b-none w-[70%] md:w-[50%] mx-auto mt-10 text-white p-5">Authentification</h1>
    <section class=" p-5 w-[70%] md:w-[50%] bg-[#BACFF0] mx-auto rounded-t-none rounded-lg flex flex-col pb-10 mb-16">
        <form action="{{ route('login') }}" method="POST" class="m-0 p-0" onsubmit="return confirmMDP()">
            @csrf
        <!-- Row -->
        <div class="flex w-full items-center mt-3">
            <div class="flex-1 flex flex-col space-y-1 items-center justify-center">
                <label for="email">Email:</label>
                <input id="email" name="email" type="text" class="outline-none focus:ring focus:border-blue-100 rounded w-full md:w-[60%] shadow-md p-1">
            </div>
        </div>  

        <!-- Row -->
        <div class="flex w-full items-center mt-5">
            <div class="flex-1 flex flex-col space-y-1 items-center justify-center">
                <label for="password">Mot de passe:</label>
                <input id="password" name="password" type="password" class="outline-none focus:ring focus:border-blue-100 rounded w-full md:w-[60%] shadow-md p-1">
            </div>
        </div> 

        <!-- Row -->
        <div class="flex w-full items-center mt-10">
            <!-- Column -->
            <div class="flex-1 flex flex-col space-y-1 items-center justify-center">
                <button class="px-3 py-2 bg-blue-500 text-white rounded-lg transition-all duration-300 hover:bg-blue-600">Se connecter</button>
            </div>
        </div>
        </form>
    </section>

@endsection

@section('scripts')
    <script>
        const confirmMDP = () => {
            const mdp = document.getElementById('password');

            if (mdp.value.length < 5) { 
                alert('Le mot de passe doit être supérieur à 5 lettre');
                return false;
            }

            return true;
        }
    </script>
@endsection