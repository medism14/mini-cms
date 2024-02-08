<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="icon" href="{{ asset('images/blogIcon.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>{{ $article->title }}</title>
    <style>
        body {
            color: {{ $article->page->site->font_color }};
        }
    </style>
</head>
<body class="bg-gray-600">
    <section class="min-h-screen w-full md:w-[70%] mx-auto bg-white relative justify-center rounded-lg rounded-b-none overflow-y-auto flex-col space-y-10 p-3 pb-0">
        <!-- Pour le bouton revenir et modifier -->
        @if (session('errors'))
                @if (is_array(session('errors')))
                    <script>
                        var errors = '';
                    </script>
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
                <p class="w-full text-center mb-5 text-green-600 message">{{ session('success') }}</p>
            @endif
        
        <div class="w-full flex">
            <div class="flex-1 flex justify-start text-lg">
                <a href="{{ route('site.dashboard', ['siteName' => session('pagePublic')->site->name]) }}" class="p-2 text-lg text-gray-700 font-bold hover:text-gray-800"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Revenir</a>
            </div>
            <div class="flex-1 flex justify-end">
            </div>
        </div>

        <!--  Partie article -->
        <div class="flex flex-col items-center">
            <img src="{{ asset('storage/' . $article->image->path) }}" class="rounded-lg w-full md:w-[50%]">
            <h1 class="font-bold text-xl underline mb-5">{{ $article->title }}</h1>

            <div class="container">
                {!! nl2br($article->text->content) !!}</p>
            </div>
        </div>

        <div id="ecartCommentaire"></div>

        <!-- Partie commentaire -->
        <div class="border-t-2 p-2 pb-10 bg-gray-200" id="Commentaire">
            <h1 class="text-center underline font-bold mb-5">Commentaires</h1>

            @if (auth()->user()->id != $article->page->site->user_id)
                <div class="flex flex-col">
                    <form action="{{ route('comments.add', ['id' => $article->id]) }}" method="POST" class="">
                    @csrf
                    <textarea name="comment" rows="7" class="w-full p-2 focus:outline-none focus:ring-2 border-blue-200 rounded border-2" maxlength="300"></textarea>
                    <div class="w-full flex justify-center">
                        <button class="mt-4 px-2 py-1 bg-blue-500 text-white rounded-lg shadow-md transition-all duration-300 hover:bg-blue-600">Enregistrer</button>
                    </div>
                    </form>
                </div>
            @endif
                

                @foreach ($comments as $comment)
                <div class="comment flex flex-col w-full border-b-2 p-2 border-gray-800 comment">
                    <div class="p-2 flex items-center w-full">
                        <div class="w-1/4"></div>

                        <div class="w-2/4 flex justify-center items-center space-x-2">
                            <i class="fas fa-user"></i> <span class="text-blue-600"> {{ $comment->user->first_name }} {{ $comment->user->last_name }}</span>: 
                        </div>

                        <div class="w-1/4 flex justify-end">
                            
                        </div>
                    </div>
                    <div class="flex-1 text-center">
                        <p>{{ $comment->content }}</p>
                    </div>
                </div>
            @endforeach

            @if ($comments->isEmpty())
                <h1 class="comment text-center mt-5">Aucun commentaire</h1>
            @endif

        </div>  
    </section>

    <script>
        //Suppression des messages existants
            const msg = Array.from(document.getElementsByClassName('message'));

            setTimeout(() => {
                msg.forEach((m) => {
                    m.remove();
                });
            }, 3000);
        //

        //Modification position commentaire
            const commentaire = document.getElementById('Commentaire');
            const ecartCommentaire = document.getElementById('ecartCommentaire');
            let comment = Array.from(document.getElementsByClassName('comment'));

            comment = comment[0];

            let positionCommentaire = comment.getBoundingClientRect().height + comment.getBoundingClientRect().y + 8;

            let ecart = window.innerHeight - positionCommentaire;

            if (ecart > 0) {
                ecartCommentaire.classList.add(`pb-[${ecart}px]`);
            }
        //
    </script>
</body>
</html>