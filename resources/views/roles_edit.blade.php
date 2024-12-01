@extends("layouts.app")

@section("content")

    <div class="container col-md-10">
        <div class="card">
            <div class="card-header">
                Editar rol
            </div>
            <div class="card-body">

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{route("roles.update", $role)}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label">Name (nombre del rol) </label>
                        <input type="text" id="name" name="name" value="{{old("name",$role->name)}}"
                               class="form-control">
                    </div>
                    <div class="mb-3">
                        <div class="row mx-0">
                            @foreach($permissions as $permission)
                                <div class="form-check col-md-3">
                                    <label for="{{$permission->id}}"
                                           class="form-check-label">{{$permission->name}}</label>
                                    <input type="checkbox" id="{{$permission->id}}" name="permissions[]"
                                           value="{{$permission->name}}" class="form-check-input"
                                        {{$role->hasPermissionTo($permission)?"checked":""}}>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <a href="{{route("roles.index")}}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection
