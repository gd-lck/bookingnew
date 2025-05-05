 
 @extends('layouts.app')

 @section('title', 'Welcome')
 
 @section('content')
    <section id="section1" class="flex flex-col h-screen bg-pink-400 p-0">
        <div style="background-image: url({{ asset('assets/image/web/2148299590.jpg') }});"
             class="bg-cover bg-center w-screen flex-1 flex items-center p-40">
                <div>
                    <h1 class="font-bold text-5xl">Style Your Nail</h1>
                    <h1 class="text-3xl">Express Your beauty</h1>
                    <button class="bg-white text-black py-1 px-2 rounded-2xl mt-5">BOOK NOW</button>
                </div>
        </div>
        <div class="bg-white w-screen flex-none h-50 flex justify-between px-5 gap-3 text-black">
            <div class="flex-1 border border-4 border-white flex flex-row gap-2">
                <div style="background-image: url( {{ asset('assets/image/web/kukuTangan1.jpg') }});" class="flex-1 bg-cover flex-col ">
                    
                </div>
                <div class="flex-1 flex flex-col justify-center  gap-2">
                <p class=" font-bold ">Style Your Hand Nail</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi.</p>
                </div>
            </div>
            <div class="flex-1 border border-4 border-white flex flex-row gap-2">
                <div style="background-image: url('{{asset('assets/image/web/kukuKaki1.png')}}');"class="flex-1 bg-cover flex-col ">
                    
                </div>
                <div class="flex-1 flex flex-col justify-center  gap-2">
                <p class=" font-bold ">Style Your Toe Nail</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi.</p>
                </div>
            </div>
            <div class="flex-1 border border-4 border-white flex flex-row gap-2">
                <div style="background-image: url('{{asset('assets/image/web/nail-art-professional-working-client-nails.jpg')}}');"class="flex-1 bg-cover flex-col ">
                    
                </div>
                <div class="flex-1 flex flex-col justify-center  gap-2">
                <p class=" font-bold ">Handled By Our Professional Nail Styler</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi.</p>
                </div>
            </div>
        </div>
    </section>
    <section id="section2" class="flex flex-row h-screen w-screen bg-pink-200 p-0 ">
        <div class="h-screen flex-1 bg-white px-5  flex flex-row p-0">
            <div class=" h-screen w-100 flex flex-col justify-around font-bold text-black pt-10">
                <p class="text-center self-center p-3">"Studio kecantikan terpercaya yang menghadirkan layanan profesional dan inovatif, serta memberikan pengalaman terbaik bagi setiap pelanggan dalam mengekspresikan kecantikan mereka"</p>
                <div class="bg-pink-200 flex flex-col justify-between h-60 pt-10">
                    <p class="font-bold text-white w-full flex justify-center">Find Us!</p>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3791.3329552794216!2d115.2858329286466!3d-8.552442292062539!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd2178b380886a3%3A0x826a8aa805d5207e!2sYours%20Beauty!5e1!3m2!1sid!2sid!4v1745910970680!5m2!1sid!2sid"
                        class="w-full h-40 border-0 shadow-md" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
                
            </div>
            <div class="h-screen flex flex-col ">
                <div class=" flex flex-col h-60  my-10 pt-10">
                    <img src="{{asset('assets/image/web/24225.jpg')}}" class=" pt-30 h-60 w-50 object-cover">
                </div>
                <div class="text-black flex-1 h-400 px-10 pb-10">
                    <p>Misi :</p>
                    <ul class="list-disc"> 
                        <li>Menyediakan layanan nail art dan perawatan kecantikan berkualitas tinggi dengan teknik dan produk terbaik.</li>
                        <li>Menciptakan pengalaman pelanggan yang nyaman, aman, dan memuaskan dengan pelayanan profesional.</li>
                        <li>Menciptakan pengalaman pelanggan yang nyaman, aman, dan memuaskan dengan pelayanan profesional.</li>
                        <li>Mengikuti tren kecantikan terbaru untuk selalu memberikan inovasi dalam setiap layanan.</li>
                        <li>Membangun hubungan jangka panjang dengan pelanggan melalui kepercayaan dan kepuasan layanan.</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="flex flex-col w-100 justify-center items-center gap-4 px-5 bg-pink-200 h-screen">            
            <img src="{{asset('assets/image/web/logo.png')}}" class="h-20">
            <p class="text-5 font-bold ">Your's Beauty 
                Studio</p>
        </div>

    </section>
@endsection    
