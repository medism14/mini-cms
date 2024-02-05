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
    </head>

    <style>
        body {
            background-color: {{ $user->site->background_color }};
        }
        .sectionContent {
            color: {{ $user->site->font_color }};
            border-bottom: 2px solid {{ $user->site->section_color }};
        }

        .soulignement::before {
            content: "";
            position: absolute;
            width: 0;
            bottom: 0;
            transition: 0.2s ease-in-out;
            left: 50%;
            border-bottom: 2px solid black;
            transform: translateX(-50%);
        }

        .soulignement:hover::before {
            width: 60%;
        }

        .soulignementB::before {
            content: "";
            position: absolute;
            width: 0;
            bottom: 0;
            transition: 0.2s ease-in-out;
            left: 50%;
            border-bottom: 2px solid white;
            transform: translateX(-50%);
        }

        .soulignementB:hover::before {
            width: 60%;
        }

        #sidebar::after {
            content: "Loup";
            position: absolute;
            right: 0;
            top: 50%;
            color: black;
        }
    </style>
    <body class="antialiased">
    
    @if ($user->site->menu->type == 'horizontale')
        <!-- Horizontale -->
        <section class="flex flex-col w-full h-screen">
            <nav class="w-full p-5 flex justify-center rounded-b-lg text-base bg-white">
                <div class="md:w-1/6" id="siteName">
                </div>
                <div class="w-5/6 md:w-4/6 flex justify-center items-center">
                    <ul class="list-style-none text-black font-bold flex space-x-2">
                        @foreach ($user->site->pages as $page)
                            <form action="{{ route('users.dashboard') }}" method="POST">
                                @csrf
                                <input class="hidden" value="{{ $page->id }}" name="pageId">
                                <button type="submit" class="rounded-b-lg px-2 border-black border-b-2">{{ $page->name }}</button>
                            </form>
                        @endforeach
                    </ul>
                </div>

                <div class="w-1/6 flex justify-end">
                    <ul class="list-style-none flex justify-end space-x-2 items-center">
                        <li>
                            <a href="/users/config" class="text-white cursor-pointer bg-gray-800 transition-all duration-300 hover:bg-gray-900 px-3 py-1 rounded-lg">
                                <i class="fas fa-cog"></i>
                            </a>
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="m-0 p-0">
                                @csrf
                                <button class="text-white bg-gray-800 transition-all duration-300 hover:bg-gray-900 px-3 py-1 rounded-lg">
                                    <i class="fas fa-door-open"></i>
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>

            <section class="w-full p-5 flex flex-col items-center">
                @if (session('errors'))
                    @if (is_array(session('errors')))
                            @foreach (session('errors') as $v => $error)
                                <script>
                                    errors += '{{ $error }}';
                                </script>
                            @endforeach
                        <script>
                            alert(errors);
                        </script>
                    @else
                        <script>
                            alert("{{ session('errors') }}");
                        </script>
                    @endif
                @endif

                @if (session('success'))
                    <p class="w-full text-center mb-5 text-green-600">{{ session('success') }}</p>
                @endif
                @yield('content')
            </section>
        </section>
    @endif

    @if ($user->site->menu->type == 'verticale')
        <!-- Verticale -->
        <section class="w-full flex">
            <nav class="w-[25%] bg-white" id="menuVerticale">
                <nav id="subMenuVerticale" class="fixed w-[25%] bg-white h-screen rounded-r-lg text-white flex flex-col">
                    <i id="closeMenuVerticale" class="fa fa-arrow-left bg-gray-800 hover:bg-gray-900 p-1 text-white absolute fixed right-0 cursor-pointer text-2xl top-[50%]"></i>
                    <div class="h-1/6">
                        <ul class="list-style-none flex justify-center mt-3 space-x-3 items-center">
                            <li>
                                <a href="/users/config" class="text-white cursor-pointer bg-gray-800 transition-all duration-300 hover:bg-gray-900 px-3 py-1 rounded-lg">
                                    <i class="fas fa-cog"></i>
                                </a>
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="m-0 p-0">
                                    @csrf
                                    <button class="text-white bg-gray-800 transition-all duration-300 hover:bg-gray-900 px-3 py-1 rounded-lg">
                                        <i class="fas fa-door-open"></i>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>

                    <div class="flex-1 flex items-center flex-col space-y-5 justify-center">
                        @foreach ($user->site->pages as $page)
                        <div class="text-center text-xl pb-2 text-black">
                            <form action="{{ route('users.dashboard') }}" method="POST">
                                @csrf
                                <input class="hidden" value="{{ $page->id }}" name="pageId">
                                <button type="submit" class="px-3 border-black border-b-2 rounded-lg">{{ $page->name }}</button>
                            </form>
                        </div>
                        @endforeach
                    </div>
                    
                    <div class="h-1/6"></div>
                </nav>
            </nav>
            <section id="contentMenuVerticale" class="p-5 w-[75%] flex flex-col items-center">
            <i id="openMenuVerticale" class="fa fa-arrow-right fixed cursor-pointer left-0 top-0 text-2xl bg-gray-800 hover:bg-gray-900 p-1 text-white "></i>
                @if (session('errors'))
                    @if (is_array(session('errors')))
                            @foreach (session('errors') as $v => $error)
                                <script>
                                    errors += '{{ $error }}';
                                </script>
                            @endforeach
                        <script>
                            alert(errors);
                        </script>
                    @else
                        <script>
                            alert("{{ session('errors') }}");
                        </script>
                    @endif
                @endif

                @if (session('success'))
                    <p class="w-full text-center mb-5 text-green-600">{{ session('success') }}</p>
                @endif
                @yield('content')
            </section>
        </section>
    @endif

    @if ($user->site->menu->type == 'burger')
        <!-- Burger -->
        <nav id="burgerNav" class="hidden h-screen w-full flex flex-col bg-gray-700">
            <div class="w-full flex justify-end p-3 h-1/6">
                <i id="closeBurger" class="fas fa-close text-2xl text-white font-bold cursor-pointer"></i>
            </div>
            <nav class="h-4/6 flex flex-col justify-center items-center text-xl">
                    @foreach ($user->site->pages as $page)
                        <div class="text-center text-xl pb-2 text-white border-white rounded-b-lg border-b-2 rounded-lg-b">
                            <form action="{{ route('users.dashboard') }}" method="POST">
                                @csrf
                                <input class="hidden" value="{{ $page->id }}" name="pageId">
                                <button type="submit" class="soulignementB px-6 relative">{{ $page->name }}</button>
                            </form>
                        </div>
                    @endforeach
            </nav>
            <div class="h-1/6">
                
            </div>
        </nav>

        <section id="burgerSection">
            <nav class="left-5 w-full flex bg-white">
                <div class="p-5 flex-1 justify-start text-2xl">
                    <i id="openBurger" class="fa fa-bars cursor-pointer" aria-hidden="true"></i>
                </div>
                <div class="flex-1 justify-end mr-5">
                    <ul class="list-style-none flex items-center justify-end space-x-3">
                        <li class="py-5">
                            <a href="/users/config" class="text-white cursor-pointer bg-gray-800 transition-all duration-300 hover:bg-gray-900 px-3 py-1 rounded-lg">
                                <i class="fas fa-cog"></i>
                            </a>
                        </li>
                        <li class="py-5">
                            <form action="{{ route('logout') }}" method="POST" class="m-0 p-0">
                                @csrf
                                <button class="text-white bg-gray-800 transition-all duration-300 hover:bg-gray-900 px-3 py-1 rounded-lg">
                                    <i class="fas fa-door-open"></i>
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>
            
                <section class="w-full p-5 flex flex-col items-center">
                @if (session('errors'))
                    @if (is_array(session('errors')))
                            @foreach (session('errors') as $v => $error)
                                <script>
                                    errors += '{{ $error }}';
                                </script>
                            @endforeach
                        <script>
                            alert(errors);
                        </script>
                    @else
                        <script>
                            alert("{{ session('errors') }}");
                        </script>
                    @endif
                @endif

                @if (session('success'))
                    <p class="w-full text-center mb-5 text-green-600">{{ session('success') }}</p>
                @endif
                @yield('content')
            </section>
        </section>
    @endif

    <script>
        //Manipulation verticale
            const mediaQuery = window.matchMedia("(max-width:768px)");
            
            @if ($user->site->menu->type == 'verticale')
                const menuVerticale = document.getElementById('menuVerticale');
                const subMenuVerticale = document.getElementById('subMenuVerticale');
                const contentMenuVerticale = document.getElementById('contentMenuVerticale');

                //Reglage des ouvertures menuvertiface et fermeture
                const openMenuVerticale = document.getElementById('openMenuVerticale');
                const closeMenuVerticale = document.getElementById('closeMenuVerticale');

                openMenuVerticale.addEventListener('click', () => {
                    openMenuVerticale.classList.add('hidden');
                    closeMenuVerticale.classList.remove('hidden');

                    menuVerticale.classList.remove('hidden');
                    menuVerticale.classList.remove('w-[25%]');
                    menuVerticale.classList.add('w-full');

                    subMenuVerticale.classList.remove('hidden');
                    subMenuVerticale.classList.remove('w-[25%]');
                    subMenuVerticale.classList.add('w-full');

                    contentMenuVerticale.classList.add('hidden');
                });

                closeMenuVerticale.addEventListener('click', () => {
                    openMenuVerticale.classList.remove('hidden');
                    closeMenuVerticale.classList.add('hidden');

                    menuVerticale.classList.add('hidden');
                    menuVerticale.classList.add('w-[25%]');
                    menuVerticale.classList.remove('w-full');

                    subMenuVerticale.classList.add('hidden');
                    subMenuVerticale.classList.add('w-[25%]');
                    subMenuVerticale.classList.remove('w-full');

                    contentMenuVerticale.classList.remove   ('hidden');
                });

                if (mediaQuery.matches) {
                    menuVerticale.classList.add('hidden');
                    contentMenuVerticale.classList.remove('w-[75%]');
                    contentMenuVerticale.classList.add('w-full');

                    openMenuVerticale.classList.remove('hidden')
                    closeMenuVerticale.classList.add('hidden')

                } else {
                    menuVerticale.classList.remove('hidden');
                    contentMenuVerticale.classList.add('w-[75%]');
                    contentMenuVerticale.classList.remove('w-full');

                    openMenuVerticale.classList.add('hidden');
                    closeMenuVerticale.classList.add('hidden');
                }
            @endif
        //

        //Manipulation burger
            @if ($user->site->menu->type == 'burger')
                const openBurger = document.getElementById('openBurger');
                const closeBurger = document.getElementById('closeBurger');

                const burgerSection = document.getElementById('burgerSection');
                const burgerNav = document.getElementById('burgerNav');

                openBurger.addEventListener('click', () => {
                    burgerSection.classList.add('hidden');
                    burgerNav.classList.remove('hidden');
                });

                closeBurger.addEventListener('click', () => {
                    burgerSection.classList.remove('hidden');
                    burgerNav.classList.add('hidden');
                });
            @endif
        //

        //Image du site
            // Fonction pour dessiner l'image et le texte sur le canvas
            function drawImageWithText() {
                
            }
            drawImageWithText();
        //
    </script>
    
    @yield('scripts')
    </body>
</html>
