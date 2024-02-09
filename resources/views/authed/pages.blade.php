@extends('layouts.publicLayouts')

@section('title', session('pagePublic')->name)

@section('content')
    <style>
        img {
            height: 150px;
            object-fit: cover;
        }

    </style>

    <canvas id="myCanvas" style="border: 1px solid black; border-radius: 25px;"></canvas>
    
    @if (session('pagePublic')->articles)
        @if (!session('pagePublic')->articles->isEmpty())
            <hr class="w-full border-b-2 my-10 border-[{{ $site->section_color }}]">

            <h1 class="text-center mb-10 text-2xl font-bold underline">{{ session('pagePublic')->name }}</h1>
        @endif
    @endif

    <section id="sectionArticle" class="sectionContent w-full flex justify-center space-x-5">
        @if (session('pagePublic')->articles)
            @if (!session('pagePublic')->articles->isEmpty())
                    <div class="flex items-center">
                        <i class="fa fa-arrow-left text-xl cursor-pointer p-1 bg-white rounded-full" id="arrowLeft"></i>
                    </div>
                @endif

                @foreach (session('pagePublic')->articles as $article)
                    <div class="flex flex-col images">
                        <div class="flex-1">
                            <img src="{{ asset('storage/' . $article->image->path) }}" class="rounded-lg rounded-b-none" width="200" height="50" alt="loup">
                        </div>
                        <div class="bg-gray-700 rounded-lg rounded-t-none text-white font-bold text-xl flex flex-col">
                            <p class="text-center">{{ $article->title }}</p>
                            <p class="text-end p-2"><a href="{{ route('articles.view', ['id' => $article->id]) }}" class="m-0 p-0"><i class="fa fa-arrow-circle-right cursor-pointer"></i></a></p>
                        </div>
                    </div>
                @endforeach

                @if (!session('pagePublic')->articles->isEmpty())
                    <div class="flex items-center">
                        <i class="fa fa-arrow-right text-xl cursor-pointer p-1 bg-white rounded-full" id="arrowRight"></i>
                    </div>
                @endif
        @endif
    </section>

    
@endsection

@section('scripts')
    <script>
        //Image du site
            const canvas = document.getElementById('myCanvas');
            const ctx = canvas.getContext('2d');
            function drawImage () {
                var img = new Image();
                img.onload = function () {
                    ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

                    // Ajouter du texte
                    ctx.font = "30px Arial";
                    ctx.fillStyle = "black";
                    ctx.textAlign = "center";
                    ctx.textBaseline = "middle";
                    ctx.fillText('{{ $site->name }}', canvas.width / 2, canvas.height / 2)
                }
                img.src = "{{ asset('images/site.jpg') }}";
            }

            window.onload = function () {
                drawImage();
            };
        //

        //Image Responsive
            if (mediaQuery.matches) {
                canvas.height = "75";
                canvas.width = "200";
            } else {
                canvas.height = "150";
                canvas.width = "400";
            }
        //

        //Pagination des articles
            const sectionArticle = document.getElementById('sectionArticle');
            const arrowLeft = document.getElementById('arrowLeft');
            const arrowRight = document.getElementById('arrowRight');

            let images = Array.from(document.getElementsByClassName('images'));

            let i = 1;
            images.forEach((image) => {
                if (i > 3) {
                    image.classList.add('hidden');
                }
                i++;
            });

            arrowLeft.addEventListener('click', () => {
                let i = 0;
                let positionActuel;
                images.forEach((image) => {
                    
                    if (!image.classList.contains('hidden')) {
                        positionActuel = i;
                        return;
                    }

                    i++
                });

                if (positionActuel >= 1) {
                    let positionAjouter = positionActuel - 1;
                    let positionEnlever = positionActuel + 2;

                    images[positionAjouter].classList.remove('hidden');
                    images[positionEnlever].classList.add('hidden');
                }

            });

            arrowRight.addEventListener('click', () => {
                let i = 0;
                let positionActuel = null;
                images.forEach((image) => {

                    if (i == 0) {
                        
                    } else {
                        if (image.classList.contains('hidden') && !images[i-1].classList.contains('hidden')) {
                            positionActuel = i;
                            return;
                        }
                    }
                    

                    i++
                });


                if (positionActuel) {
                    let positionEnlever = positionActuel - 3;


                    images[positionEnlever].classList.add('hidden');
                    images[positionActuel].classList.remove('hidden');
                }

            });
        //
    </script>
@endsection