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
        <form class="w-full max-w-lg" method="POST" action="{{route('roles.update', $role->id)}}">
            @csrf
            @method('PUT')
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="name">
                        Nombre del Rol
                    </label>
                    <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="name" name="name" value="{{$role->name}}" type="text" required>
                    <p class="text-gray-600 text-xs italic">Make it as long and as crazy as you'd like</p>
                </div>
            </div>

            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full px-3">
                    <div class="md:w-1/3">Permisos para este Rol</div>
                    @foreach ($permission as $value)

                    <label class="md:w-2/3 block text-gray-500 font-bold">
                        {{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermission), array('class'=>'name mr-2 leading-tight')) }}
                        <span class="text-sm">{{$value->name}}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <button class="shadow bg-purple-500 hover:bg-purple-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded" type="submit">
                Editar
            </button>
        </form>
    </div>
</div>
@endsection