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
                <a href="{{ route('config') }}" class="p-2 text-lg text-gray-700 font-bold hover:text-gray-800"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Revenir</a>
            </div>
            <div class="flex-1 flex justify-end">
                <button class="text-lg text-orange-600 font-bold hover:text-orange-700" id="editArticle">Modifier <i class="fas fa-pencil-alt"></i></button>
            </div>
        </div>

        <!--  Partie article -->
        <div class="flex flex-col items-center">
            <img src="{{ asset('storage/' . $article->image->path) }}" class="rounded-lg w-full md:w-[50%]">
            <h1 class="font-bold text-xl underline mb-5">{{ $article->title }}</h1>

            <div class="container break-words">
                <p>{!! nl2br($article->text->content) !!}</p>
            </div>
        </div>

        <div id="ecartCommentaire"></div>

        <!-- Partie commentaire -->
        <div class="border-t-2 p-2 pb-10 bg-gray-200" id="Commentaire">
            <h1 class="text-center underline font-bold mb-5">Commentaires</h1>

            @foreach ($comments as $comment)
                <div class="comment flex flex-col w-full border-b-2 p-2 border-gray-800 comment">
                    <div class="p-2 flex items-center w-full">
                        <div class="w-1/4"></div>

                        <div class="w-2/4 flex justify-center items-center space-x-2">
                            <i class="fas fa-user"></i> <span class="text-blue-600"> {{ $comment->user->first_name }} {{ $comment->user->last_name }}</span>: 
                        </div>

                        <div class="w-1/4 flex justify-end">
                            <form action="{{ route('comments.delete', ['id' => $comment->id]) }}" method="POST" class="m-0 p-0" onsubmit="return confirm('Voulez vous vraiment supprimer ce commentaire')">
                                @method('DELETE')
                                @csrf
                                <button name="pageId" class="text-lg text-red-600 font-bold hover:text-red-700" type="submit"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                    <div class="flex-1 text-center">
                        <p>{{ $comment->content }}</p>
                    </div>
                </div>
            @endforeach

            @if ($comments->isEmpty())
                <h1 class="comment text-center">Aucun commentaire</h1>
            @endif

        </div>  
    </section>

    <!-- Modal modifier article -->
    <div id="editArticleModal" class="hidden h-screen z-50 overflow-auto inset-0 fixed bg-gray-300 bg-opacity-75">
            <form action="{{ route('articles.edit', ['id' => $article->id ]) }}" method="POST" class="m-0 p-0" enctype="multipart/form-data" onsubmit="return verifyImage()">
            @csrf
            <div id="subeditArticleModal" class="w-full md:w-[80%] mx-auto flex justify-center flex flex-col my-5">
                <!-- Modal title -->
                <div class="rounded-lg w-full rounded-b-none p-3 text-center bg-green-800 text-white flex">
                    <p class="w-1/3"></p>
                    <p class="flex-1">Modifier Article</p>
                    <p class="text-end w-1/3"><i class="fas fa-times cursor-pointer text-xl" id="closeEditArticleModal"></i></p>
                </div>

                <!-- Modal body -->
                <div class="rounded-lg w-full rounded-t-none rounded-b-none p-3 text-center bg-gray-300 flex flex-col space-y-8">
                    <!-- Row -->
                    <div class="w-full flex justify-center items-center">
                        <label for="editArticleTitle">Titre de l'article: </label>
                        <input type="text" placeholder="Titre de l'article..." name="editArticleTitle" id="editArticleTitle" class="ml-3 p-1 rounded outline-none shadow-md">
                    </div>

                    <!-- Row -->
                    <div class="w-full flex justify-center items-center">
                        <label for="editArticleImage">Image de l'article: </label>
                        <input type="file" name="editArticleImage" id="editArticleImage" class="ml-3 shadow-md border-none rounded-lg px-2 py-1 focus:outline-none focus:ring-2 focus:border-transparent">
                    </div>

                    <!-- Row -->
                    <div class="w-full flex justify-center items-center flex-col">
                        <label for="editArticleContent">Contenu: </label>
                        <textarea id="editArticleContent" placeholder="Contenu de l'article..." name="editArticleContent" cols="100" rows="30" class="p-1 focus:outline-none focus:ring-2 border-blue-300 rounded"></textarea>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="rounded-lg w-full rounded-t-none p-3 text-center bg-gray-100 border-t-2 border-gray-400">
                    <button class="px-2 py-1 bg-green-700 text-white rounded-lg transition-all duration-300 hover:bg-green-800">Modifier</button>
                </div>
            </div>
            </form>
        </div>

    
    <script>
        //editPageModal
            const editArticleModal = document.getElementById('editArticleModal');
            const closeEditArticleModal = document.getElementById('closeEditArticleModal');
            const editArticle = document.getElementById('editArticle');

            editArticle.addEventListener('click', async () => {

                let id = {{ $article->id }};
                let response = await fetch(`/articles/getArticle/${id}`);
                let data = await response.json();

                let editArticleTitle = document.getElementById('editArticleTitle');
                let editArticleImage = document.getElementById('editArticleImage');
                let editArticleContent = document.getElementById('editArticleContent');

                editArticleTitle.value = data.title;
                editArticleContent.value = data.text.content;   

                editArticleModal.classList.remove('hidden');
            });

            closeEditArticleModal.addEventListener('click', () => {
                editArticleModal.classList.add('hidden');
                location.reload();
            })
        //
        
        //Verification si image ou pas
            function verifyImage () {
                let editArticleImage = document.getElementById('editArticleImage');

                if (editArticleImage.files.length > 0) {
                    let file = editArticleImage.files[0]

                    if (file.type.startsWith('image/')) {
                        return true;
                    } else {
                        alert('Veuillez soumettre une image');
                        return false;
                    }
                }
            }
        //

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

            let positionCommentaire = comment.getBoundingClientRect().height + comment.getBoundingClientRect().y + 48;

            let ecart = window.innerHeight - positionCommentaire;

            console.log(ecart)

            if (ecart > 0) {
                ecartCommentaire.classList.add(`pb-[${ecart}px]`);
            }
        //
    </script>
</body>
</html>