<footer class="bg-gray-400 p-10 flex w-screen gap-5 justify-between">
    <div class="flex gap-5">
        <ul >
            <p class="font-bold text-white text-start">Yours Beauty</p>
            <li>Jam Operasional	 : 10.00 - 20.00</li>
            <li>Alamat			 : {{$perusahaan->alamat}}.</li>
        </ul>
        <ul>
            Hubungi Kami 
            <li> No Tlp			 : {{$perusahaan->telepon}}</li>
            <li> Instagram		 : @yoursbeautyy_</li>
            <li> email           : {{$perusahaan->email}}</li>
        </ul>
    </div>
    
    <p class="justify-end">&copy; 2025 YourBeauty. All rights reserved.</p>
</footer>