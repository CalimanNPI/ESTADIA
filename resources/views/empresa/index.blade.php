@extends('dashboard')

@section('content')
<div class="container">
    <a href="{{route('empresa.create')}}" class="shadow bg-purple-500 hover:bg-purple-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded">Nuevo</a>

    @foreach ($empresas as $empresa)

    <div class="relative w-64">
        <!-- yellow background -->
        <div class="absolute -right-4 -bottom-4 bg-purple-500 h-full w-full rounded-xl"></div>

        <div class="relative bg-blue-700 text-gray-50 rounded-xl p-8 space-y-7">
            <!-- yellow line -->
            <div class="h-2 w-20 bg-purple-500"></div>

            <!-- percentage -->
            <div class="text-5xl font-extrabold text-heliotrope">{{$empresa->nombre}}</div>

            <!-- description -->
            <p class="leading-snug text-heliotrope-400">{{$empresa->razonsocial}}.</p>

            <!-- learn more -->
            <a href="{{route('empresa.show', $empresa->idempresa)}}" class="block text-purple-500 font-bold tracking-wide flex">
                <span>Seleccionar Empresa</span>
                <svg class="w-4 h-4 ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg></a>
        </div>
    </div>
    @endforeach

</div>
@endsection