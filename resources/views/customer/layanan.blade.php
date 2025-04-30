@extends('layouts.app')

@section('title', 'Beranda')

@php
    use Illuminate\Support\Str;
@endphp

@section('content')
<div class="container mx-auto px-4 py-8 pt-20">
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($layanan as $item)
    <div x-data="{ open: false }"
         class="flex flex-col bg-white shadow-lg rounded-lg overflow-hidden">
      
      {{-- Gambar --}}
      <div class="flex h-48">
        <img src="{{ asset('uploads/' . $item->gambar) }}"
             alt="Gambar {{ $item->nama_layanan }}"
             class="w-1/2 object-cover">
        <img src="{{ asset('uploads/' . $item->gambar2) }}"
             alt="Gambar {{ $item->nama_layanan }}"
             class="w-1/2 object-cover">
      </div>

      {{-- Konten --}}
      <div class="p-4 flex-1 flex flex-col">
        <h5 class="text-xl font-semibold mb-2">{{ $item->nama_layanan }}</h5>
        <div class="text-gray-500 mb-2">
          Rp {{ number_format($item->harga,0,',','.') }}
        </div>
        <p class="text-sm mb-2">
          Durasi: {{ number_format($item->durasi,0,',','.') }} menit
        </p>
        <p class="text-gray-600 mb-4">
          {{ Str::words($item->deskripsi, 10, '...') }}
        </p>
        <button
          type="button"
          @click="open = true"
          class="mt-auto bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-lg transition"
        >
          Lihat Detail
        </button>
      </div>

      {{-- Modal --}}
      <div
        x-show="open"
        x-cloak
        x-transition
        @click.self="open = false"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
      >
        <div
          @click.stop
          class="bg-white rounded-lg overflow-hidden w-full max-w-2xl mx-4"
        >
          
          {{-- Header --}}
          <div class="flex justify-between items-center px-4 py-2 border-b">
            <h3 class="text-lg font-semibold">{{ $item->nama_layanan }}</h3>
            
          </div>
          
          {{-- Body --}}
          <div class="p-4 space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <img src="{{ asset('uploads/' . $item->gambar) }}"
                   alt=""
                   class="w-full h-48 object-cover rounded">
              <img src="{{ asset('uploads/' . $item->gambar2) }}"
                   alt=""
                   class="w-full h-48 object-cover rounded">
            </div>
            <h4 class="text-gray-700">
              Harga: <span class="font-semibold">Rp {{ number_format($item->harga,0,',','.') }}</span>
            </h4>
            <p class="text-gray-700">
              Durasi: {{ number_format($item->durasi,0,',','.') }} menit
            </p>
            <p class="text-gray-600">{{ $item->deskripsi }}</p>
            <a href="{{ route('booking.create', $item->id) }}"
               class="inline-block bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-lg transition"
            >
              Pesan Sekarang
            </a>
          </div>

        </div>
      </div>
    </div>
    @endforeach
  </div>
</div>
@endsection
