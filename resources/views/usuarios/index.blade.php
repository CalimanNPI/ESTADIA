@extends('dashboard')

@section('content')

<div class="container w-full md:w-4/5 xl:w-4/5  mx-auto px-2">
    <a href="{{route('usuarios.create')}}" class="shadow bg-purple-500 hover:bg-purple-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded">Nuevo</a>
    <div id='recipients' class="p-8 mt-6 lg:mt-0 rounded shadow bg-white">

        <table id="table" class="stripe hover" style="width: 100%; padding-top: 1em; padding-button:1em;">
            <thead>
                <tr class="bg-indigo-400 bg-opacity-100 text-white">
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($usuarios as $usuario)
                <tr>
                    <td>{{$usuario->id}}</td>
                    <td>{{$usuario->name}}</td>
                    <td>{{$usuario->email}}</td>
                    <td>
                        @if (!empty($usuario->getRoleNames()))
                        @foreach ($usuario->getRoleNames() as $rolName)
                        <h5><span>{{$rolName}}</span></h5>
                        @endforeach
                        @endif
                    </td>
                    <td>
                        <a href="{{route('usuarios.edit', $usuario->id)}}" class="shadow bg-green-500 hover:bg-green-400 focus:shadow-outline focus:outline-none text-white font-bold py-1 px-2 rounded">Editar</a>

                        {!! Form::open(['method'=>'DELETE', 'route'=> ['usuarios.destroy', $usuario->id], 'style'=>'display:inline']) !!}
                        {!! Form::submit('Borrar', ['class'=>'shadow bg-red-500 hover:bg-red-400 focus:shadow-outline focus:outline-none text-white font-bold py-1 px-2 rounded']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


@endsection