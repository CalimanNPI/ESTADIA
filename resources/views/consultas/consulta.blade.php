@extends('dashboard')

@section('content')
<div class="container w-full md:w-4/5 xl:w-4/5  mx-auto px-2">
    <div id='recipients' class="p-8 mt-6 lg:mt-0 rounded shadow bg-white">
        @if ($errors->any())
        <div class="bg-red-100 p-5 w-full sm:w-1/2">
            <div class="flex space-x-3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="flex-none fill-current text-red-500 h-4 w-4">
                    <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm4.597 17.954l-4.591-4.55-4.555 4.596-1.405-1.405 4.547-4.592-4.593-4.552 1.405-1.405 4.588 4.543 4.545-4.589 1.416 1.403-4.546 4.587 4.592 4.548-1.403 1.416z" />
                </svg>

                <div class="leading-tight flex flex-col space-y-2">
                    <div class="text-sm font-medium text-red-700">Errors</div>
                    @foreach ($errors->all() as $error)
                    <div class="flex-1 leading-snug text-sm text-red-600">{{ $error }}</div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
        <form class="w-full max-w-lg" method="POST" action="{{route('consulta.sat')}}">
            @csrf
            @method('POST')
            <div class="flex flex-wrap -mx-3 mb-6">

                <div class="w-full px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="titulo">
                        Fecha inicial
                    </label>
                    <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="fechaInicio" name="fechaInicio" type="date" require>
                    <p class="text-gray-600 text-xs italic"></p>
                </div>

               
                <div class="w-full px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="rfc">
                        Fecha final
                    </label>
                    <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="fechaFin" name="fechaFin" type="date" placeholder="90210">
                </div>


                <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-zip">
                        Recibidos
                    </label>
                    <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="datos" name="datos" type="radio" value="recibidos">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-zip">
                        Emitidos
                    </label>
                    <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="datos" name="datos" type="radio" value="emitidos">
                </div>
                <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-zip">
                        CFDI
                    </label>
                    <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="descarga" name="descarga" type="radio" value="CFDI">

                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-zip">
                        Metadata
                    </label>
                    <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="descarga" name="descarga" type="radio" value="metadata">
                </div>
            </div>

            @yield('content_consulta')

            <button class="shadow bg-purple-500 hover:bg-purple-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded" type="submit">
                Generar Solicitud
            </button>
        </form>
    </div>
</div>
@endsection