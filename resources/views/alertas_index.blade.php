@extends("layouts.app")

@section("content")

    <div class="container col-md-10">
        <div class="card">
            <div class="card-header">
                Alertas urbanas
            </div>
            <div class="card-body">

                @if(session("mensaje"))
                    <div class="alert alert-{{session("danger")?"danger":"success"}}">
                        {{session("mensaje")}}
                    </div>
                @endif

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="btn-group">
                            <a href="{{route("alertas.create")}}" class="btn btn-primary">Nueva alerta</a>
                            <a href="{{route("alertas.reporte")}}" class="btn btn-info" target="_blank">Reporte de las
                                alertas</a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <form action="{{route("alertas.index")}}" method="get" class="mb-3">
                            <div class="row align-items-center justify-content-end">
                                @auth
                                    <div class="col-auto">
                                        <div class="form-check form-switch">
                                            <label class="form-check-label" for="misAlertas">
                                                Mostrar únicamente mis alertas
                                            </label>
                                            <input type="checkbox" id="misAlertas" name="misAlertas"
                                                   class="form-check-input" role="switch"
                                                   value="true" {{old("misAlertas")?"checked":""}} >
                                        </div>
                                    </div>
                                @endauth
                                <div class="col-auto">
                                    <input type="text" name="direccion" id="direccion" class="form-control"
                                           value="{{old("direccion")}}" placeholder="Buscar por dirección">
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary">Buscar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="row row-cols-1 row-cols-md-3 g-4">
                    @foreach($alertas as $alerta)
                        <div class="col">
                            <div class="card h-100">
                                <div class="card-header text-white"
                                     style="background-color: {{$alerta->relEstado->color}}">
                                    {{$alerta->relEstado->descripcion}}
                                </div>
                                <img src="{{url("fotos/$alerta->foto")}}" class="card-img-top object-fit-contain"
                                     alt="{{$alerta->relEstado->descripcion}}" height="200" style="background-color: #eeeeee">
                                <div class="card-body">
                                    <b>Descripción:</b><br>
                                    {{$alerta->descripcion}}<br>
                                    <b>Dirección:</b><br>
                                    {{$alerta->direccion}}<br>
                                    <b>Usuario:</b><br>
                                    {{$alerta->relUser->name}}<br>
                                </div>
                                <div class="text-center mb-3">
                                    <div class="btn-group">
                                        <a href="https://www.openstreetmap.org/export/embed.html?bbox={{$alerta->longitud-0.0034}}%2C{{$alerta->latitud-0.0016}}%2C{{$alerta->longitud+0.0034}}%2C{{$alerta->latitud+0.0016}}&layer=mapnik&marker={{$alerta->latitud}}%2C{{$alerta->longitud}}"
                                           class="btn btn-primary" target="_blank">Ubicación</a>
                                        @can("alerta.edit")
                                            <a href="{{route("alertas.edit", $alerta)}}" class="btn btn-info">Editar</a>
                                        @endcan
                                        @can("alerta.delete")
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#eliminarModal{{$alerta->id}}">
                                            Eliminar
                                        </button>
                                        @endcan
                                    </div>
                                </div>
                                <div class="card-footer text-center">
                                    {{date_format($alerta->created_at, "d-m-Y H:i:s")}}<br>
                                </div>
                            </div>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="eliminarModal{{$alerta->id}}" tabindex="-1"
                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger text-white">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Eliminar una alerta
                                            urbana</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        ¿Desea eliminar la alerta urbana seleccionada? Esta acción no puede deshacerse.
                                    </div>
                                    <div class="modal-footer">
                                        <form action="{{route("alertas.destroy", $alerta)}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Eliminar</button>
                                        </form>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <br>
                {{$alertas->links("pagination::bootstrap-4")}}
            </div>
        </div>
    </div>

@endsection
