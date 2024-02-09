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
        

    <style>
        body {
            background-color: white;
        }

        .sectionContent {
            color: {{ $user->site->font_color }};
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
        <section class="min-h-screen relative w-[20%]" id="sectionGauche">
            <!-- Section gauche conteneur -->
            <section class="fixed min-h-screen flex flex-col w-[20%]" id="subSectionGauche">

                <button class="absolute hidden left-0 text-2xl font-bold cursor-pointer m-2" id="sectionGaucheBoutton">
                    <i class="fas fa-angle-left"></i>
                </button>

                <!-- Section gauche partie haute -->
                <div class="h-[40vh] overflow-auto flex flex-col text-center border-b-2">
                    <!-- Ajouter une nouvelle page -->
                    <div class="m-4 flex">
                        <div class="flex-1">

                        </div>
                        <div class="flex-1 flex justify-start">
                            Pages
                        </div>
                        <div class="flex-1 flex justify-end">
                            <button class="px-3 rounded-lg bg-green-600 text-white" id="addPage"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                    
                    <!-- Pages -->
                    @foreach ($pages as $page)
                        <div class="flex border-b-2">
                            <form action="{{ route('config') }}" method="POST" class="m-0 p-0 flex-1">
                                @csrf
                                <button name="pageId" value="{{ $page->id }}" class="{{ session('pageConfig')->name == $page->name ? 'rounded-b-lg border-b-2 border-gray-900' : '' }} px-4 text-lg text-gray-700 font-bold hover:text-gray-900 m-2" type="submit">{{ $page->name }}</button>
                            </form>
                            
                            <div class="w-1/6 ml-3 flex items-center">
                                <input id="pageId" value="{{ $page->id }}" class="hidden">
                                <button name="pageId" value="{{ $page->id }}" class="text-lg text-orange-600 font-bold hover:text-orange-700" type="submit" id="editPage"><i class="fas fa-pencil-alt"></i></button>
                            </div>

                            <form action="{{ route('pages.delete', ['id' => $page->id]) }}" method="POST" class="m-0 p-0 w-1/6 flex items-center"  onsubmit="return confirm('Voulez vous vraiment supprimer cette article ?')">
                                @csrf
                                @method('DELETE')
                                <button name="pageId" value="{{ $page->id }}" class="text-lg text-red-600 font-bold hover:text-red-700" type="submit"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    @endforeach

                </div>
                <!-- Section gauche partie bas -->
                <div class="h-[60vh] overflow-auto flex flex-col text-center">
                    <!-- Ajouter une nouvelle section -->
                    <div class="m-4 flex">
                        <div class="flex-1">

                        </div>
                        <div class="flex-1 flex justify-start">
                            <p>Articles</p>
                        </div>
                        <div class="flex-1 flex justify-end">
                            <button class="px-3 rounded-lg bg-green-600 text-white" id="addArticle"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>

                    <!-- Articles -->
                    @if ((session('pageConfig')->articles))
                        @foreach (session('pageConfig')->articles as $article)
                            <div class="border-b-2 font-bold p-2 bg-gray-200 text-black w-full my-1 flex">
                                <div class="w-2/3 flex justify-start">
                                    {{ $article->title }}
                                </div>
                                <div class="w-1/3 flex space-x-4 justify-end">
                                    <div>
                                        <a href="{{ route('articles.configArticle', ['id' => $article->id]) }}" name="pageId" class="text-lg text-blue-700 font-bold hover:text-blue-800" id="editPage"><i class="fas fa-cog"></i></a>
                                    </div>

                                    <form action="{{ route('articles.delete', ['id' => $article->id]) }}" method="POST" class="m-0 p-0 flex items-center" onsubmit="return confirm('Voulez vous vraiment supprimer cette article ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button name="pageId" value="{{ $page->id }}" class="text-lg text-red-600 font-bold hover:text-red-700" type="submit"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    
                </div>
            </section>
        </section>

        <!-- Section milieu -->
        <section id="sectionDisplay" class="relative overflow-auto w-[60%] p-5 flex flex-col items-center bg-[{{ $user->site->background_color }}]">
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
            
            <button class="absolute hidden right-0 text-2xl font-bold cursor-pointer m-2" id="sectionMilieuDroiteBoutton">
                <i class="fas fa-angle-left"></i>
            </button>
            
            <button class="absolute hidden left-0 text-2xl font-bold cursor-pointer m-2" id="sectionMilieuGaucheBoutton">
                <i class="fas fa-angle-right"></i>
            </button>

            @if (session('success'))
                <p class="w-full text-center mb-5 text-green-600 message">{{ session('success') }}</p>
            @endif

            @yield('content')
        </section>

        <!-- Section droite -->
        <section class="min-h-screen w-[20%] relative" id="sectionDroite">
            <!-- Section droite conteneur -->
            <section class="fixed min-h-screen flex flex-col w-[20%]" id="subSectionDroite">

                <button class="absolute hidden right-0 text-2xl font-bold cursor-pointer m-2" id="sectionDroiteBoutton">
                    <i class="fas fa-angle-right"></i>
                </button>
                
                <!-- Section droite partie haute -->
                <div class="h-[10vh] border-b-2 w-full overflow-auto flex flex-col items-center justify-center">
                        <a href="{{ route('site.dashboard', ['siteName' => auth()->user()->site->name]) }}" class="p-2"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Rendu public</a>
                </div>
                <!-- Section droite partie bas -->
                <div class="h-[90vh] w-full overflow-auto pt-5">
                
                    <!-- Nom du site -->
                    <form action="{{ route('sites.editSiteName') }}" method="POST" class="m-0 p-0">
                    @csrf
                    <div class="border-b-4 mb-5">
                        <h1 class="text-center text-xl font-bold underline mb-3">Nom du site</h1>
                        <div class="flex justify-center">
                            <input type="text" name="siteName" class="w-[70%] border-2 border-gray-400 p-1 outline-none rounded" value="{{ session('pageConfig')->site->name }}">
                        </div>

                        <div class="w-full flex justify-center p-2">
                            <button class="mt-4 px-2 py-1 bg-green-500 text-white rounded-lg shadow-md transition-all duration-300 hover:bg-green-600">Enregistrer</button>
                        </div>
                    </div>
                    </form>

                    <!-- Menu Type -->
                    <form action="{{ route('sites.editMenuType') }}" method="POST" class="m-0 p-0">
                    @csrf
                    <div class="border-b-4 mb-5">
                        <div class="flex flex-col">
                            <h1 class="text-center text-xl font-bold underline mb-3">Type de menu</h1>
                            <div class="lg:flex">
                                <p class="lg:w-[60%] text-center">Burger</p>
                                <p class="lg:w-[20%] text-center"><input type="radio" value="burger" name="typeMenu" class="cursor-pointer" {{ (session('pageConfig')->site->menu->type == 'burger' ? 'checked' : '') }}></p>
                            </div>
                            
                            <div class="lg:flex">
                                <p class="lg:w-[60%] text-center">Verticale</p>
                                <p class="lg:w-[20%] text-center"><input type="radio" value="verticale" name="typeMenu" class="cursor-pointer" {{ (session('pageConfig')->site->menu->type == 'verticale' ? 'checked' : '') }}></p>
                            </div>

                            <div class="lg:flex">
                                <p class="lg:w-[60%] text-center">Horizontale</p>
                                <p class="lg:w-[20%] text-center"><input type="radio" value="horizontale" name="typeMenu" class="cursor-pointer" {{ (session('pageConfig')->site->menu->type == 'horizontale' ? 'checked' : '') }}></p>
                            </div>
                        </div>
                        <div class="w-full flex justify-center p-2">
                            <button class="mt-4 px-2 py-1 bg-green-500 text-white rounded-lg shadow-md transition-all duration-300 hover:bg-green-600">Enregistrer</button>
                        </div>
                    </div>
                    </form>

                    <!-- Background color -->
                    <form action="{{ route('sites.editBackgroundColor') }}" method="POST" class="m-0 p-0">
                    @csrf
                    <div class="border-b-4 mb-5">
                        <div class="flex flex-col">
                            <h1 class="text-center text-xl font-bold underline mb-3">Background Color</h1>
                            <div class="lg:flex">
                                <p class="lg:w-[60%] text-center">Bleu Clair</p>
                                <p class="lg:w-[20%] text-center"><input type="color" value="#D8E5EB" class="cursor-pointer" disabled></p>
                                <p class="lg:w-[20%] text-center"><input type="radio" value="#D8E5EB" name="backgroundColor" class="cursor-pointer" {{ (session('pageConfig')->site->background_color == '#D8E5EB' ? 'checked' : '') }}></p>
                            </div>
                            
                            <div class="lg:flex">
                                <p class="lg:w-[60%] text-center">Gris clair</p>
                                <p class="lg:w-[20%] text-center"><input type="color" value="#F2F4F2" class="cursor-pointer" disabled></p>
                                <p class="lg:w-[20%] text-center"><input type="radio" value="#F2F4F2" name="backgroundColor" class="cursor-pointer" {{ (session('pageConfig')->site->background_color == '#F2F4F2' ? 'checked' : '') }}></p>
                            </div>

                            <div class="lg:flex">
                                <p class="lg:w-[60%] text-center">Vert Clair</p>
                                <p class="lg:w-[20%] text-center"><input type="color" value="#ECF5E2" class="cursor-pointer" disabled></p>
                                <p class="lg:w-[20%] text-center"><input type="radio" value="#ECF5E2" name="backgroundColor" class="cursor-pointer" {{ (session('pageConfig')->site->background_color == '#ECF5E2' ? 'checked' : '') }}></p>
                            </div>
                        </div>
                        <div class="w-full flex justify-center p-2">
                            <button class="mt-4 px-2 py-1 bg-green-500 text-white rounded-lg shadow-md transition-all duration-300 hover:bg-green-600" name="background">Enregistrer</button>
                        </div>
                    </div>
                    </form>
                    
                    <!-- Font color -->
                    <form action="{{ route('sites.editFontColor') }}" method="POST" class="m-0 p-0">
                    @csrf
                    <div class="border-b-4 mb-5">
                        <div class="flex flex-col">
                            <h1 class="text-center text-xl font-bold underline mb-3">Font Color</h1>
                            <div class="lg:flex">
                                <p class="lg:w-[60%] text-center">Gris foncé</p>
                                <p class="lg:w-[20%] text-center"><input type="color" value="#333333" class="cursor-pointer" disabled></p>
                                <p class="lg:w-[20%] text-center"><input type="radio" value="#333333" name="fontColor" class="cursor-pointer" {{ (session('pageConfig')->site->font_color == '#333333' ? 'checked' : '') }}></p>
                            </div>
                            
                            <div class="lg:flex">
                                <p class="lg:w-[60%] text-center">Noir</p>
                                <p class="lg:w-[20%] text-center"><input type="color" value="#000000" class="cursor-pointer" disabled></p>
                                <p class="lg:w-[20%] text-center"><input type="radio" value="#000000" name="fontColor" class="cursor-pointer" {{ (session('pageConfig')->site->font_color == '#000000' ? 'checked' : '') }}></p>
                            </div>

                            <div class="lg:flex">
                                <p class="lg:w-[60%] text-center">Marron foncé</p>
                                <p class="lg:w-[20%] text-center"><input type="color" value="#3d1f00" class="cursor-pointer" disabled></p>
                                <p class="lg:w-[20%] text-center"><input type="radio" value="#3d1f00" name="fontColor" class="cursor-pointer" {{ (session('pageConfig')->site->font_color == '#3d1f00' ? 'checked' : '') }}></p>
                            </div>
                        </div>
                        <div class="w-full flex justify-center p-2">
                            <button class="mt-4 px-2 py-1 bg-green-500 text-white rounded-lg shadow-md transition-all duration-300 hover:bg-green-600" name="font">Enregistrer</button>
                        </div>
                    </div>
                    </form>

                    <!-- Section Color -->
                    <form action="{{ route('sites.editSectionColor') }}" method="POST" class="m-0 p-0">
                    @csrf
                    <div class="mb-5">
                        <div class="flex flex-col">
                            <h1 class="text-center text-xl font-bold underline mb-3">Section Color</h1>
                            <div class="lg:flex">
                                <p class="lg:w-[60%] text-center">Gris Ardoise</p>
                                <p class="lg:w-[20%] text-center"><input type="color" value="#40535B" class="cursor-pointer" disabled></p>
                                <p class="lg:w-[20%] text-center"><input type="radio" value="#40535B" name="sectionColor" class="cursor-pointer" {{ (session('pageConfig')->site->section_color == '#40535B' ? 'checked' : '') }}></p>
                            </div>
                            
                            <div class="lg:flex">
                                <p class="lg:w-[60%] text-center">Vert foncé</p>
                                <p class="lg:w-[20%] text-center"><input type="color" value="#495B40" class="cursor-pointer" disabled></p>
                                <p class="lg:w-[20%] text-center"><input type="radio" value="#495B40" name="sectionColor" class="cursor-pointer" {{ (session('pageConfig')->site->section_color == '#495B40' ? 'checked' : '') }}></p>
                            </div>

                            <div class="lg:flex">
                                <p class="lg:w-[60%] text-center">Taupe</p>
                                <p class="lg:w-[20%] text-center"><input type="color" value="#847A67" class="cursor-pointer" disabled></p>
                                <p class="lg:w-[20%] text-center"><input type="radio" value="#847A67" name="sectionColor" class="cursor-pointer" {{ (session('pageConfig')->site->section_color == '#847A67' ? 'checked' : '') }}></p>
                            </div>
                        </div>
                        <div class="w-full flex justify-center p-2">
                            <button class="mt-4 px-2 py-1 bg-green-500 text-white rounded-lg shadow-md transition-all duration-300 hover:bg-green-600" name="section">Enregistrer</button>
                        </div>
                    </div>
                    </form>
                </div>
            </section>
            </form>
        </section>

        <!-- Modal ajouter page -->
        <div id="addPageModal" class="hidden h-screen z-50 inset-0 fixed bg-gray-300 bg-opacity-75">
            <form action="{{ route('pages.add') }}" method="POST" class="p-0 m-0">
                @csrf
            <div id="subAddPageModal" class="w-full md:w-[40%] mx-auto my-24 flex justify-center flex flex-col">
                <!-- Modal title -->
                <div class="rounded-lg w-full rounded-b-none p-3 text-center bg-green-800 text-white flex">
                    <p class="w-1/3"></p>
                    <p class="flex-1">Ajout page</p>
                    <p class="text-end w-1/3"><i class="fas fa-times cursor-pointer text-xl" id="closeAddPageModal"></i></p>
                </div>

                <!-- Modal body -->
                <div class="rounded-lg w-full rounded-t-none rounded-b-none p-3 text-center bg-gray-300 ">
                    <!-- Row -->
                    <div class="w-full flex justify-center items-center">
                        <label for="pageName">Nom de la page: </label>
                        <input type="text" name="pageName" id="pageName" class="ml-3 p-1 rounded outline-none shadow-md">
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="rounded-lg w-full rounded-t-none p-3 text-center bg-gray-100 border-t-2 border-gray-400">
                    <button class="px-2 py-1 bg-green-700 text-white rounded-lg transition-all duration-300 hover:bg-green-800">Ajouter</button>
                </div>
            </div>
            </form>
        </div>

        <!-- Modal modifier page -->
        <div id="editPageModal" class="hidden h-screen z-50 inset-0 fixed bg-gray-300 bg-opacity-75">
            <form action="{{ route('pages.edit', ['id' => $page->id]) }}" method="POST" class="m-0 p-0">
                @csrf
            <div id="subEditPageModal" class="w-full md:w-[40%] mx-auto my-24 flex justify-center flex flex-col">
                <!-- Modal title -->
                <div class="rounded-lg w-full rounded-b-none p-3 text-center bg-green-800 text-white flex">
                    <p class="w-1/3"></p>
                    <p class="flex-1">Modification page</p>
                    <p class="text-end w-1/3"><i class="fas fa-times cursor-pointer text-xl" id="closeEditPageModal"></i></p>
                </div>

                <!-- Modal body -->
                <div class="rounded-lg w-full rounded-t-none rounded-b-none p-3 text-center bg-gray-300 ">
                    <!-- Row -->
                    <div class="w-full flex justify-center items-center">
                        <label for="editPageName">Nom de la page: </label>
                        <input type="text" name="editPageName" id="editPageName" class="ml-3 p-1 rounded outline-none shadow-md">
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="rounded-lg w-full rounded-t-none p-3 text-center bg-gray-100 border-t-2 border-gray-400">
                    <button class="px-2 py-1 bg-green-700 text-white rounded-lg transition-all duration-300 hover:bg-green-800">Modifier</button>
                </div>
            </div>
            </form>
        </div>

        <!-- Modal ajouter article -->
        <div id="addArticleModal" class="hidden h-screen z-50 inset-0 fixed bg-gray-300 bg-opacity-75 overflow-auto">
            <form action="{{ route('articles.add') }}" method="POST" class="m-0 p-0" enctype="multipart/form-data" onsubmit="verifyImage()">
            @csrf
            <div id="subaddArticleModal" class="w-full md:w-[80%] mx-auto flex justify-center flex flex-col my-5">
                <!-- Modal title -->
                <div class="rounded-lg w-full rounded-b-none p-3 text-center bg-green-800 text-white flex">
                    <p class="w-1/3"></p>
                    <p class="flex-1">Ajout Article</p>
                    <p class="text-end w-1/3"><i class="fas fa-times cursor-pointer text-xl" id="closeAddArticleModal"></i></p>
                </div>

                <!-- Modal body -->
                <div class="rounded-lg w-full rounded-t-none rounded-b-none p-3 text-center bg-gray-300 flex flex-col space-y-8">
                    <!-- Row -->
                    <div class="w-full flex justify-center items-center">
                        <label for="addArticleTitle">Titre de l'article: </label>
                        <input type="text" placeholder="Titre de l'article..." name="addArticleTitle" id="addArticleTitle" class="ml-3 p-1 rounded outline-none shadow-md">
                    </div>

                    <!-- Row -->
                    <div class="w-full flex justify-center items-center">
                        <label for="addArticleImage">Image de l'article: </label>
                        <input type="file" name="addArticleImage" id="addArticleImage" class="ml-3 shadow-md border-none rounded-lg px-2 py-1 focus:outline-none focus:ring-2 focus:border-transparent">
                    </div>

                    <!-- Row -->
                    <div class="w-full flex justify-center items-center flex-col">
                        <label for="addArticleContent">Contenu: </label>
                        <textarea id="addArticleContent" placeholder="Contenu de l'article..." name="addArticleContent" cols="100" rows="30" class="p-1 focus:outline-none focus:ring-2 border-blue-300 rounded"></textarea>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="rounded-lg w-full rounded-t-none p-3 text-center bg-gray-100 border-t-2 border-gray-400">
                    <button class="px-2 py-1 bg-green-700 text-white rounded-lg transition-all duration-300 hover:bg-green-800">Ajouter</button>
                </div>
            </div>
            </form>
        </div>
    </section>

    <script>
        const mediaQuery = window.matchMedia("(max-width:768px)");

        //addPageModal
            const addPageModal = document.getElementById('addPageModal');
            const closeAddPageModal = document.getElementById('closeAddPageModal');
            const addPage = document.getElementById('addPage');

            addPage.addEventListener('click', () => {
                addPageModal.classList.remove('hidden');
            });

            closeAddPageModal.addEventListener('click', () => {
                addPageModal.classList.add('hidden');
                location.reload();
            })
        //

        //editPageModal
            const editPageModal = document.getElementById('editPageModal');
            const closeEditPageModal = document.getElementById('closeEditPageModal');
            const editPage = document.getElementById('editPage');
            const editPageName = document.getElementById('editPageName');

            editPage.addEventListener('click', async (event) => {
                
                let id = parseInt(event.target.parentNode.parentNode.querySelector('input').value);

                let response = await fetch(`/pages/getPage/${id}`);
                let data = await response.json();

                editPageName.value = data.name;

                editPageModal.classList.remove('hidden');
            });

            closeEditPageModal.addEventListener('click', () => {
                editPageModal.classList.add('hidden');
                location.reload();
            })
        //

        //addPageModal
            const addArticleModal = document.getElementById('addArticleModal');
            const closeAddArticleModal = document.getElementById('closeAddArticleModal');
            const addArticle = document.getElementById('addArticle');

            addArticle.addEventListener('click', () => {
                addArticleModal.classList.remove('hidden');
            });

            closeAddArticleModal.addEventListener('click', () => {
                addArticleModal.classList.add('hidden');
                location.reload();
            })
        //

        //Suppression des messages existants
            const msg = Array.from(document.getElementsByClassName('message'));

            setTimeout(() => {
                msg.forEach((m) => {
                    m.remove();
                });
            }, 3000);
        //

        //Verification si image ou pas
            function verifyImage () {
                let addArticleImage = document.getElementById('addArticleImage');

                if (addArticleImage.files.length > 0) {
                    let file = addArticleImage.files[0]

                    if (file.type.startsWith('image/')) {
                        return true;
                    } else {
                        alert('Veuillez soumettre une image');
                        return false;
                    }
                }
            }
        //

        //Responsive 
            const sectionGaucheBoutton = document.getElementById('sectionGaucheBoutton');
            const sectionDroiteBoutton = document.getElementById('sectionDroiteBoutton');

            const sectionMilieuDroiteBoutton = document.getElementById('sectionMilieuDroiteBoutton');
            const sectionMilieuGaucheBoutton = document.getElementById('sectionMilieuGaucheBoutton');

            const sectionGauche = document.getElementById('sectionGauche');
            const subSectionGauche = document.getElementById('subSectionGauche');

            const sectionDroite = document.getElementById('sectionDroite');
            const subSectionDroite = document.getElementById('subSectionDroite');

            const sectionMilieu = document.getElementById('sectionDisplay');

            if (mediaQuery.matches) {
                sectionGauche.classList.add('hidden');
                sectionDroite.classList.add('hidden');
                sectionMilieu.classList.remove('w-[60%]');
                sectionMilieu.classList.add('w-full');

                sectionGaucheBoutton.classList.remove('hidden');
                sectionDroiteBoutton.classList.remove('hidden');
                sectionMilieuDroiteBoutton.classList.remove('hidden');
                sectionMilieuGaucheBoutton.classList.remove('hidden');
            } else {
                sectionGauche.classList.remove('hidden');
                sectionDroite.classList.remove('hidden');
                sectionMilieu.classList.add('w-[60%]');
                sectionMilieu.classList.remove('w-full');

                sectionGaucheBoutton.classList.add('hidden');
                sectionDroiteBoutton.classList.add('hidden');
                sectionMilieuDroiteBoutton.classList.add('hidden');
                sectionMilieuGaucheBoutton.classList.add('hidden');
            }

            //Milieu gauche
                sectionMilieuGaucheBoutton.addEventListener('click', () => {
                    sectionMilieu.classList.add('hidden');

                    sectionGauche.classList.remove('hidden', 'w-[20%]');
                    sectionGauche.classList.add('w-full');

                    subSectionGauche.classList.remove('hidden', 'w-[20%]');
                    subSectionGauche.classList.add('w-full');
                });
            //

            //Milieu droite
            sectionMilieuDroiteBoutton.addEventListener('click', () => {
                sectionMilieu.classList.add('hidden');

                sectionDroite.classList.remove('hidden', 'w-[20%]');
                sectionDroite.classList.add('w-full');

                subSectionDroite.classList.remove('hidden', 'w-[20%]');
                subSectionDroite.classList.add('w-full');
                });
            //

            //Section Gauche
            sectionGaucheBoutton.addEventListener('click', () => {
                sectionMilieu.classList.remove('hidden');

                sectionGauche.classList.add('hidden', 'w-[20%]');
                sectionGauche.classList.remove('w-full');

                subSectionGauche.classList.add('hidden', 'w-[20%]');
                subSectionGauche.classList.remove('w-full');
                });
            //

            //Section droite
            sectionDroiteBoutton.addEventListener('click', () => {
                sectionMilieu.classList.remove('hidden');

                sectionDroite.classList.add('hidden', 'w-[20%]');
                sectionDroite.classList.remove('w-full');

                subSectionDroite.classList.add('hidden', 'w-[20%]');
                subSectionDroite.classList.remove('w-full');
                });
            //

        //
    </script>
        @yield('scripts')

    </body>
</html>
