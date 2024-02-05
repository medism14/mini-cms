<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link rel="icon" href="{{ asset('images/blogIcon.png') }}">
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <style>
        body {
            background-color: white;
        }
        .sectionContent {
            color: {{ $user->site->font_color }};
            border-bottom: 2px solid {{ $user->site->section_color }};
        }

        input[type="color"] {
            -webkit-appearance: none;
            border: 1px solid black;
            width: 32px;
            height: 17px;
        }
        input[type="color"]::-webkit-color-swatch-wrapper {
            padding: 0;
        }
        input[type="color"]::-webkit-color-swatch {
            border: none;
        }
    </style>

    </head>
    <body class="antialiased">
        
    <!-- Section pour séparer les trois parties -->
    <section class="flex">
        <!-- Section gauche -->
        <section class="min-h-screen w-[20%]">
            <!-- Section gauche conteneur -->
            <section class="fixed min-h-screen flex flex-col w-[20%]">
                <!-- Section gauche partie haute -->
                <div class="h-[40vh] overflow-auto flex flex-col text-center border-b-2">
                    <!-- Ajouter une nouvelle page -->
                    <div class="m-4 flex">
                        <div class="flex-1 flex justify-start">
                            Pages
                        </div>
                        <div class="flex-1 flex justify-end">
                            <button class="px-3 rounded-lg bg-green-600 text-white"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                    
                    <!-- Pages -->
                    @foreach ($pages as $page)  
                        <div>
                            <form action="{{ route('users.config') }}" method="POST" class="m-0 p-0">
                                @csrf
                                <button name="pageId" value="{{ $page->id }}" class="underline px-4 rounded-b-lg border-b-2 border-gray-900 text-lg text-gray-700 font-bold hover:text-gray-900 m-2" type="submit">{{ $page->name }}</button>
                            </form>
                        </div>
                    @endforeach

                </div>
                <!-- Section gauche partie bas -->
                <div class="h-[60vh] overflow-auto flex flex-col text-center">
                    <!-- Ajouter une nouvelle section -->
                    <div class="m-4 flex">
                        <div class="flex-1 flex justify-start">
                            <p>Sections</p>
                        </div>
                        <div class="flex-1 flex justify-end">
                            <button class="px-3 rounded-lg bg-green-600 text-white"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>

                    <!-- Pages -->
                    @foreach (session('pageConfig')->sections as $section)
                        <div>
                            sz
                        </div>
                    @endforeach
                </div>
            </section>
        </section>

        <section class="overflow-auto w-[60%] p-5 flex flex-col items-center bg-[{{ $user->site->background_color }}]">
            @yield('content')
        </section>

        <!-- Section droite -->
        <section class="min-h-screen w-[20%]">
            <!-- Section droite conteneur -->
            <section class="fixed min-h-screen flex flex-col w-[20%]">
                <!-- Section droite partie haute -->
                <div class="h-[10vh] border-b-2 w-full overflow-auto flex flex-col items-center justify-center">
                        <a href="{{ route('users.dashboard') }}" class="p-2"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Rendu public</a>
                </div>
                <!-- Section droite partie bas -->
                <div class="h-[90vh] w-full overflow-auto pt-5">
                
                    <!-- Nom du site -->
                    <div class="border-b-4 mb-5">
                        <h1 class="text-center text-xl font-bold underline mb-3">Nom du site</h1>
                        <div class="flex justify-center">
                            <input type="text" name="siteName" class="w-[70%] border-2 border-gray-400 p-1 outline-none rounded">
                        </div>

                        <div class="w-full flex justify-center p-2">
                            <button class="mt-4 px-2 py-1 bg-green-500 text-white rounded-lg shadow-md transition-all duration-300 hover:bg-green-600">Enregistrer</button>
                        </div>
                    </div>

                    <!-- Background color -->
                    <div class="border-b-4 mb-5">
                        <div class="flex flex-col">
                            <h1 class="text-center text-xl font-bold underline mb-3">Background Color</h1>
                            <div class="lg:flex">
                                <p class="lg:w-[60%] text-center">Bleu</p>
                                <p class="lg:w-[20%] text-center"><input type="color" value="#ADD8E6" class="cursor-pointer" disabled></p>
                                <p class="lg:w-[20%] text-center"><input type="radio" value="#ADD8E6" name="background" class="cursor-pointer"></p>
                            </div>
                            
                            <div class="lg:flex">
                                <p class="lg:w-[60%] text-center">Gris clair</p>
                                <p class="lg:w-[20%] text-center"><input type="color" value="#F2F4F2" class="cursor-pointer" disabled></p>
                                <p class="lg:w-[20%] text-center"><input type="radio" value="#F2F4F2" name="background" class="cursor-pointer"></p>
                            </div>

                            <div class="lg:flex">
                                <p class="lg:w-[60%] text-center">Vert</p>
                                <p class="lg:w-[20%] text-center"><input type="color" value="#D3F2B4" class="cursor-pointer" disabled></p>
                                <p class="lg:w-[20%] text-center"><input type="radio" value="#D3F2B4" name="background" class="cursor-pointer"></p>
                            </div>
                        </div>
                        <div class="w-full flex justify-center p-2">
                            <button class="mt-4 px-2 py-1 bg-green-500 text-white rounded-lg shadow-md transition-all duration-300 hover:bg-green-600">Enregistrer</button>
                        </div>
                    </div>
                    
                    <!-- Font color -->
                    <div class="border-b-4 mb-5">
                        <div class="flex flex-col">
                            <h1 class="text-center text-xl font-bold underline mb-3">Font Color</h1>
                            <div class="lg:flex">
                                <p class="lg:w-[60%] text-center">Gris foncé</p>
                                <p class="lg:w-[20%] text-center"><input type="color" value="#333333" class="cursor-pointer" disabled></p>
                                <p class="lg:w-[20%] text-center"><input type="radio" value="#333333" name="font" class="cursor-pointer"></p>
                            </div>
                            
                            <div class="lg:flex">
                                <p class="lg:w-[60%] text-center">Noir</p>
                                <p class="lg:w-[20%] text-center"><input type="color" value="#000000" class="cursor-pointer" disabled></p>
                                <p class="lg:w-[20%] text-center"><input type="radio" value="#000000" name="font" class="cursor-pointer"></p>
                            </div>

                            <div class="lg:flex">
                                <p class="lg:w-[60%] text-center">Marron foncé</p>
                                <p class="lg:w-[20%] text-center"><input type="color" value="#663300" class="cursor-pointer" disabled></p>
                                <p class="lg:w-[20%] text-center"><input type="radio" value="#663300" name="font" class="cursor-pointer"></p>
                            </div>
                        </div>
                        <div class="w-full flex justify-center p-2">
                            <button class="mt-4 px-2 py-1 bg-green-500 text-white rounded-lg shadow-md transition-all duration-300 hover:bg-green-600">Enregistrer</button>
                        </div>
                    </div>

                    <!-- Section Separation -->
                    <div class="mb-5">
                        <div class="flex flex-col">
                            <h1 class="text-center text-xl font-bold underline mb-3">Section Color</h1>
                            <div class="lg:flex">
                                <p class="lg:w-[60%] text-center">Gris Ardoise</p>
                                <p class="lg:w-[20%] text-center"><input type="color" value="#40535B" class="cursor-pointer" disabled></p>
                                <p class="lg:w-[20%] text-center"><input type="radio" value="#40535B" name="section" class="cursor-pointer"></p>
                            </div>
                            
                            <div class="lg:flex">
                                <p class="lg:w-[60%] text-center">Vert foncé</p>
                                <p class="lg:w-[20%] text-center"><input type="color" value="#495B40" class="cursor-pointer" disabled></p>
                                <p class="lg:w-[20%] text-center"><input type="radio" value="#495B40" name="section" class="cursor-pointer"></p>
                            </div>

                            <div class="lg:flex">
                                <p class="lg:w-[60%] text-center">Taupe</p>
                                <p class="lg:w-[20%] text-center"><input type="color" value="#847A67" class="cursor-pointer" disabled></p>
                                <p class="lg:w-[20%] text-center"><input type="radio" value="#847A67" name="section" class="cursor-pointer"></p>
                            </div>
                        </div>
                        <div class="w-full flex justify-center p-2">
                            <button class="mt-4 px-2 py-1 bg-green-500 text-white rounded-lg shadow-md transition-all duration-300 hover:bg-green-600">Enregistrer</button>
                        </div>
                    </div>
                
                </div>
            </section>
        </section>
    </section>

    <script>
        const mediaQuery = window.matchMedia("(max-width:768px)");
    </script>
        @yield('scripts')
    </body>
</html>
