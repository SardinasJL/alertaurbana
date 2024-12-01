@extends("layouts.app")

@section("content")

    <div class="container col-md-10">
        <div class="card">
            <div class="card-header">
                Editar usuario
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

                <form action="{{route("users.update", $user)}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label">Name (nombre)</label>
                        <input type="text" id="name" name="name" value="{{old("name",$user->name)}}"
                               class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" id="email" name="email" value="{{old("email",$user->email)}}"
                               class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password (contraseña)</label>
                        <input type="text" id="password" name="password" value="{{old("password",$user->password)}}"
                               class="form-control">
                    </div>
                    <div class="mb-3">
                        <div class="row mx-0">
                            @foreach($roles as $role)
                                <div class="form-check col-3">
                                    <label for="{{$role->name}}" class="form-check-label">{{$role->name}}</label>
                                    <input type="checkbox" name="roles[]" id="{{$role->name}}" value="{{$role->name}}"
                                           class="form-check-input" {{$user->hasRole($role)?"checked":""}}>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <a href="{{route("users.index")}}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
