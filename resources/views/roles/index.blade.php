@extends('dashboard')

@section('content')
<div class="container w-full md:w-4/5 xl:w-4/5  mx-auto px-2">

    @can('crear-rol')
    <a href="{{route('roles.create')}}" class="shadow bg-purple-500 hover:bg-purple-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded">Nuevo</a>
    @endcan
    <div id='recipients' class="p-8 mt-6 lg:mt-0 rounded shadow bg-white">

        <table id="table" class="stripe hover" style="width: 100%; padding-top: 1em; padding-button:1em;">
            <thead class="bg-indigo-400 bg-opacity-100 text-white">
                <tr>
                    <th class="w-1/2">Rol</th>
                    <th class="w-1/2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $role)
                <tr>
                    <td>{{$role->name}}</td>
                    <td>
                        @can('editar-rol')
                        <a href="{{route('roles.edit', $role->id)}}" class="shadow bg-green-500 hover:bg-green-400 focus:shadow-outline focus:outline-none text-white font-bold py-1 px-2 rounded">Editar</a>
                        @endcan

                        @can('borrar-rol')
                        {!! Form::open(['method'=>'DELETE', 'route'=> ['roles.destroy', $role->id], 'style'=>'display:inline']) !!}
                        {!! Form::submit('Borrar', ['class'=>'shadow bg-red-500 hover:bg-red-400 focus:shadow-outline focus:outline-none text-white font-bold py-1 px-2 rounded']) !!}
                        {!! Form::close() !!}
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


@endsection