<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #F7F7F7;    
        }

        .special-ouverture::before {
            content: "";
            position: absolute;
            left: 50%;
            bottom: 0;
            transition: 0.2s ease-in-out;
            width: 0;
            border-bottom: 2px solid white;
            transform: translateX(-50%);
        }

        .special-ouverture:hover::before {
            width: 100%;
        }
    </style>

    </head>
    <body>
        <nav class="bg-gray-700 p-5 mt-0 md:mt-2  bg-gray-700 text-white font-bold flex rounded-t-none md:rounded-t-lg justify-center rounded-lg w-full md:w-[80%] mx-auto">
            <ul class="list-style-none flex items-center flex-row justify-between w-[50%]">
                <li class="relative">
                    <a href="/" class="special-ouverture">Connexion</a>
                </li>      

                <li class="relative">
                    <a href="/inscription" class="special-ouverture">Inscription</a>
                </li>      
            </ul>
        </nav>

        <!-- Section erreur -->
        <section>
            <script>
                let errors = '';
            </script>
            @if (session('errors'))
                 @if (is_array(session('errors')))
                        @foreach (session('errors') as $error)
                            @foreach ($error as $v)
                                <script>
                                    errors += '{{ $v }}\n';
                                </script>
                            @endforeach
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

            
        </section>

        <!-- Section contenu -->
        <section>@yield('content')</section>

        <footer class="fixed w-full bottom-0 bg-gray-700 text-center text-white p-2 mt-5">
            Tout droits reservés ©
        </footer>

        <script>
        //Suppression des messages existants
            const msg = Array.from(document.getElementsByClassName('message'));

            setTimeout(() => {
                msg.forEach((m) => {
                    m.remove();
                });
            }, 4000);
        //
        </script>

        @yield('scripts')
    </body>
</html>
