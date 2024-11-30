@extends("layouts.app")

@section("content")

    <div class="container col-md-10">
        <div class="card">
            <div class="card-header">
                Roles
            </div>
            <div class="card-body">

                @if(session("mensaje"))
                    <div class="alert alert-{{session("danger")?"danger":"success"}}">
                        {{session("mensaje")}}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="text-center align-middle">
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th><a href="{{route("roles.create")}}" class="btn btn-primary">Nuevo rol</a></th>
                        </tr>
                        </thead>
                        <tbody class="align-middle">
                        @foreach($roles as $role)
                            <tr>
                                <td class="text-end">{{$role->id}}</td>
                                <td>{{$role->name}}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{route("roles.edit", $role)}}" class="btn btn-primary">Editar</a>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal{{$role->id}}">
                                            Eliminar
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <!-- Modal -->
                            <div class="modal fade" id="deleteModal{{$role->id}}" tabindex="-1"
                                 aria-labelledby="exampleModalLabel"
                                 aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Eliminar rol</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            ¿Desea eliminar el rol "{{$role->name}}"?
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{route("roles.destroy",$role)}}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Eliminar</button>
                                            </form>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                Cancelar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
