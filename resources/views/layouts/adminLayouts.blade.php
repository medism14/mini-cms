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
    </style>

    </head>
    <body class="antialiased">
        
    <section class="flex">
        <section class="min-h-screen w-[20%]">
            <section class="fixed min-h-screen flex flex-col w-[20%]">
                <div class="h-[40vh] w-[90] overflow-auto p-5 pt-10 flex flex-col text-center border-b-2">
                    
                </div>

                <div class="h-[60vh] w-full overflow-auto p-5 pt-10 flex flex-col">
                    
                </div>
            </section>
        </section>

        <section class="overflow-auto w-[60%] p-5 flex flex-col items-center bg-[{{ $user->site->background_color }}]">
            @yield('content')
        </section>

        <section class="min-h-screen w-[20%]">
            <section class="fixed min-h-screen flex flex-col w-[20%]">
                <div class="h-[10vh] border-b-2 w-full overflow-auto flex flex-col items-center justify-center">
                        <a href="{{ route('users.dashboard') }}" class="p-2"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Rendu public</a>
                </div>
                <div class="h-[90vh] w-full overflow-auto p-5 pt-10">
                    <div class="flex flex-col">
                        <h1 class="text-center text-xl font-bold underline mb-3">Background Color</h1>
                        <p class="flex items-center"><span class="mr-3">Couleur Beige: </span><input type="color" name="color" value="#F2F4F2" class="rounded-lg mr-3"> <input type="radio"></p>
                        <p class="flex items-center"><span class="mr-3">Bleu claire: </span><input type="color" name="color" value="#ADD8E6" class="rounded-lg mr-3"> <input type="radio"></p>
                        <p class="flex items-center"><span class="mr-3">Vert claire: </span><input type="color" name="color" value="#D3F2B4" class="rounded-lg mr-3"> <input type="radio"></p>
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
