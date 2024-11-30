@extends("layouts.app")

@section("content")

    <div class="container col-md-10">
        <div class="card">
            <div class="card-header">
                Nueva alerta urbana
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

                <form action="{{route("alertas.store")}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección:</label>
                        <input type="text" id="direccion" name="direccion" value="{{old("direccion")}}"
                               class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción:</label>
                        <textarea id="descripcion" name="descripcion"
                                  class="form-control">{{old("descripcion")}}</textarea>
                    </div>
                    <div class="mb-3">
                        <div id="map" style="height: 400px"></div>
                        <div class="row">
                            <div class="col-6">
                                <label for="latitud:" class="form-label">Latitud:</label>
                                <input type="text" id="latitud" name="latitud" value="{{old("latitud")}}"
                                       class="form-control" readonly>
                            </div>
                            <div class="col-6">
                                <label for="longitud:" class="form-label">Longitud:</label>
                                <input type="text" id="longitud" name="longitud" value="{{old("longitud")}}"
                                       class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estados_id" class="form-label">Estado</label>
                        <select name="estados_id" id="estados_id" class="form-select">
                            @foreach($estados as $estado)
                                <option value="{{$estado->id}}" {{$estado->id==old("estados_id")?"selected":""}}>
                                    {{$estado->descripcion}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto:</label>
                        <input type="file" id="foto" name="foto" class="form-control">
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <a href="{{route("alertas.index")}}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section("script")
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        var map = L.map('map').setView([{{old("latitud","-21.444171267761174")}}, {{old("longitud","-65.72070837020874")}}], 17);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(map);
        var marker = L.marker([{{old("latitud","-21.444171267761174")}}, {{old("longitud","-65.72070837020874")}}]).addTo(map);
        map.on('move', function () {
            var center = map.getCenter(); // Obtiene el centro del mapa
            marker.setLatLng(center); // Establece la posición del marcador en el centro
            let markerCoordinate = marker._latlng;
            document.getElementById("latitud").value = markerCoordinate.lat;
            document.getElementById("longitud").value = markerCoordinate.lng;
        });
        map.fire('move');
    </script>
@endsection
