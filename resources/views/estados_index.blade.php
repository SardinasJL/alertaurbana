@extends("layouts.app")

@section("content")

    <div class="container col-md-10">
        <div class="card">
            <div class="card-header">
                Configuración de los estados de las alertas urbanas
            </div>
            <div class="card-body">

                @if(session("mensaje"))
                    <div class="alert alert-{{session("danger")?"danger":"success"}}">
                        {{session("mensaje")}}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-striped table-hover text-center">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Descripcion</th>
                            <th>Color</th>
                            <th><a href="{{route("estados.create")}}" class="btn btn-primary">Nuevo</a></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($estados as $estado)
                            <tr>
                                <td class="text-end">{{$estado->id}}</td>
                                <td class="text-start">{{$estado->descripcion}}</td>
                                <td>{{$estado->color}}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{route("estados.edit", $estado)}}" class="btn btn-primary">Editar</a>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal{{$estado->id}}">
                                            Eliminar
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <!-- Modal -->
                            <div class="modal fade" id="deleteModal{{$estado->id}}" tabindex="-1"
                                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Eliminar estado</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            ¿Desea eliminar el estado "{{$estado->descripcion}}"? Esta acción no puede
                                            deshacerse.
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{route("estados.destroy", $estado)}}" method="post">
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
