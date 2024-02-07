@extends('layouts.adminLayouts')

@section('title', 'Configuration du site')

@section('content')

    <canvas id="myCanvas" style="border: 1px solid black; border-radius: 25px;"></canvas>

    <hr class="w-[80%] border-b-2 my-10 border-[{{ $user->site->section_color }}]">


    <section class="sectionContent w-full">
        @if (session('pageConfig')->articles)
            @foreach (session('pageConfig')->articles as $article)
                <div class="flex flex-col w-1/5">
                    <div class="flex-1">
                        <img src="{{ asset('storage/' . $article->image->path) }}" class="rounded-lg rounded-b-none" width="200" height="100" alt="loup">
                    </div>
                    <div class="bg-gray-700 rounded-lg rounded-t-none text-white font-bold text-xl flex flex-col">
                        <p class="text-center">{{ $article->title }}</p>
                        <p class="text-end p-2"><a href="{{ route('articles.configArticles', ['id' => $article->id]) }}" class="m-0 p-0"><i class="fa fa-arrow-circle-right cursor-pointer"></i></a></p>
                    </div>
                </div>
            @endforeach
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
                    ctx.fillText('{{ $user->site->name }}', canvas.width / 2, canvas.height / 2)
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
            
        //
    </script>
@endsection