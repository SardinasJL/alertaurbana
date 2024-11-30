@extends("layouts.app")

@section("content")

    <div class="container col-md-10">
        <div class="card">
            <div class="card-header">
                Editar un estado (tipo) de alerta
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

                <form action="{{route("estados.update", $estado)}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <input type="text" id="descripcion" name="descripcion" value="{{old("descripcion",$estado->descripcion)}}"
                               class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="color" class="form-label">Color</label>
                        <input type="color" id="color" name="color" value="{{old("color",$estado->color)}}" class="form-control form-control-color">
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <a href="{{route("estados.index")}}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
