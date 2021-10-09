@extends('consultas.peticion')

@section('content_verificar')

<div class="p-10 flex flex-col space-y-3">

    <div class="bg-blue-100 p-5 w-full sm:w-1/2 border-l-4 border-blue-500">
        <div class="flex space-x-3">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="flex-none fill-current text-blue-500 h-4 w-4">
                <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-.001 5.75c.69 0 1.251.56 1.251 1.25s-.561 1.25-1.251 1.25-1.249-.56-1.249-1.25.559-1.25 1.249-1.25zm2.001 12.25h-4v-1c.484-.179 1-.201 1-.735v-4.467c0-.534-.516-.618-1-.797v-1h3v6.265c0 .535.517.558 1 .735v.999z" />
            </svg>
           
            @foreach ($packagesIds as $packageId)
            <div class="flex-1 leading-tight text-sm text-blue-700">{{$packageId}}</div>
            @endforeach
        </div>
    </div>

</div>
<a href="{{route('consulta.descargar',['packagesIds' => $packagesIds])}}" class="shadow bg-purple-500 hover:bg-purple-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded">Actualizar Solicitud</a>

@yield('content_descargar')
@endsection