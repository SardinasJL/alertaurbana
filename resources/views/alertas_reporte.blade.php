<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte</title>
    <style>
        @page {
            margin: 1cm 1cm 1cm 1cm;
            font-family: 'Helvetica';
            font-size: 10px;
        }

        .contadorDePaginas::after {
            content: counter(page);
        }

        body {
            margin: 2.5cm 0;
        }

        header {
            position: fixed;
            top: 0cm;
            right: 0cm;
            left: 0cm;
            background-color: skyblue;
            text-align: center;
            height: 2cm;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            right: 0cm;
            left: 0cm;
            background-color: skyblue;
            text-align: center;
            height: 2cm;
        }

        main {
            width: 100%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid;
        }

        footer table td {
            height: 1.9cm;
            text-align: center;
        }

        header table td {
            height: 1.9cm;
            text-align: center;
        }

        tfoot td {
            font-weight: bold;
        }
    </style>
</head>
<body>
<header>
    <table>
        <tr>
            <td width="33%"><img src="{{public_path("fotos/tupiza.jpg")}}" height="50" alt=""></td>
            <td width="33%">ALERTAS EN LA CIUDAD DE TUPIZA</td>
            <td width="33%"><p class="contadorDePaginas">Página </p></td>
        </tr>
    </table>
</header>
<main>
    <table>
        <thead>
        <tr>
            <th>Id</th>
            <th>Descripcion</th>
            <th>Dirección</th>
            <th>Latitud</th>
            <th>Longitud</th>
            <th>Foto</th>
            <th>User</th>
            <th>Estado</th>
            <th>Creación</th>
        </tr>
        </thead>
        <tbody>
        @foreach($alertas as $alerta)
            <tr>
                <td style="text-align: right">{{$alerta->id}}</td>
                <td>{{$alerta->descripcion}}</td>
                <td>{{$alerta->direccion}}</td>
                <td style="text-align: right">{{$alerta->latitud}}</td>
                <td style="text-align: right">{{$alerta->longitud}}</td>
                <td style="text-align: center"><img src="{{public_path("fotos/$alerta->foto")}}" height="50"></td>
                <td>{{$alerta->relUser->name}}</td>
                <td>{{$alerta->relEstado->descripcion}}</td>
                <td style="text-align: center">{{date_format($alerta->created_at, "d-m-Y")}}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td colspan="9">Cantidad de alertas peligrosas: {{$alertas->where("estados_id",1)->count()}}</td>
        </tr>
        <tr>
            <td colspan="9">Cantidad de alertas parcialmente
                solucionadas: {{$alertas->where("estados_id",2)->count()}}</td>
        </tr>
        <tr>
            <td colspan="9">Cantidad de alertas resueltas: {{$alertas->where("estados_id",3)->count()}}</td>
        </tr>
        <tr>
            <td colspan="9">CANTIDAD TOTAL DE ALERTAS: {{$alertas->count()}}</td>
        </tr>
        </tfoot>
    </table>
</main>
<footer>
    <table>
        <tr>
            <td>{{now()}}</td>
        </tr>
    </table>
</footer>
</body>
</html>
