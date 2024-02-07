@extends('layouts.publicLayouts')

@section('title', session('pagePublic')->name)

@section('content')
    <canvas id="myCanvas" class="mb-16" style="border: 1px solid black; border-radius: 25px;"></canvas>

    <hr class="w-[80%] border-b-2 border-[{{ $user->site->section_color }}]">

    @if (is_array(session('pagePublic')->sections))
        @foreach (session('pagePublic')->sections as $section)
            <section class="sectionContent w-full flex justify-center">
            </section>
        @endforeach
    @endif
    
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
    </script>
@endsection