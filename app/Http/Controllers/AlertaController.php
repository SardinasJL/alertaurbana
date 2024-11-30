<?php

namespace App\Http\Controllers;

use App\Models\Alerta;
use App\Models\Estado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class AlertaController extends Controller
{
    public function __construct()
    {
        //$this->middleware("can:alerta.index")->only("index");
        $this->middleware("can:alerta.create")->only("create", "store");
        $this->middleware("can:alerta.edit")->only("edit", "update");
        $this->middleware("can:alerta.delete")->only("destroy");
    }

    /**
     * Valida un request
     * @param Request $request
     * @param bool $isUpdate
     * @return void
     */
    public function validarForm(Request $request, bool $isUpdate)
    {
        $request->validate([
            "descripcion" => "required|string|min:3|max:200",
            "direccion" => "required|string|min:3|max:100",
            "latitud" => "required|numeric",
            "longitud" => "required|numeric",
            "foto" => $isUpdate ? "image|mimes:jpg,jpeg,png|max:2048" : "required|image|mimes:jpg,jpeg,png|max:2048",
            "estados_id" => "required|integer|min:1",
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        session()->flashInput($request->input());
        if ($request->misAlertas)
            $alertas = Alerta::where("direccion", "like", "%$request->direccion%")->where("users_id", Auth::user()->id)->orderBy("created_at", "desc")->paginate(3);
        else
            $alertas = Alerta::where("direccion", "like", "%$request->direccion%")->orderBy("created_at", "desc")->paginate(3);
        return view("alertas_index", ["alertas" => $alertas]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $estados = Estado::all();
        return view("alertas_create", ["estados" => $estados]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validarForm($request, false);
        $request["users_id"] = Auth::user()->id;
        if ($foto = $request->file("foto")) {
            $input = $request->all();
            $fotoNombre = date("YmdHis") . "." . $foto->getClientOriginalExtension();
            $fotoRuta = "fotos";
            $foto->move($fotoRuta, $fotoNombre);
            $input["foto"] = $fotoNombre;
            Alerta::create($input);
        } else
            Alerta::create($request->all());
        return redirect()->route("alertas.index")->with(["mensaje" => "Se creó una nueva alerta urbana"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $estados = Estado::all();
            $alerta = Alerta::findOrFail($id);
            if (Auth::user()->hasRole("administrador") || Auth::id() == $alerta->users_id)
                return view("alertas_edit", ["alerta" => $alerta, "estados" => $estados]);
            else
                return redirect()->route("alertas.index")->with(["mensaje" => "Solamente el autor de la alerta urbana puede editarla o eliminarla","danger"=>"danger"]);
        } catch (\Exception $e) {
            return redirect()->route("alertas.index")
                ->with(["mensaje" => "No se encontró la alerta urbana", "danger" => "danger"]);
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validarForm($request, true);
        try {
            $alerta = Alerta::findOrFail($id);
            if ($foto = $request->file("foto")) {
                $archivoAEliminar = "fotos/$alerta->foto";
                if (file_exists($archivoAEliminar))
                    unlink($archivoAEliminar);
                $input = $request->all();
                $fotoNombre = date("YmdHis") . "." . $foto->getClientOriginalExtension();
                $fotoRuta = "fotos";
                $foto->move($fotoRuta, $fotoNombre);
                $input["foto"] = $fotoNombre;
                $alerta->update($input);
            } else
                $alerta->update($request->all());
            return redirect()->route("alertas.index")->with(["mensaje" => "Alerta urbana actualizada"]);
        } catch (\Exception $e) {
            return redirect()->route("alertas.index")
                ->with(["mensaje" => "No se encontró la alerta urbana", "danger" => "danger"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $alerta = Alerta::findOrFail($id);
            if (Auth::user()->hasRole("administrador") || Auth::id() == $alerta->users_id) {
                $archivoAEliminar = "fotos/$alerta->foto";
                if (file_exists($archivoAEliminar))
                    unlink($archivoAEliminar);
                $alerta->delete();
                return redirect()->route("alertas.index")->with(["mensaje" => "Alerta urbana borrada"]);
            } else
                return redirect()->route("alertas.index")->with(["mensaje" => "Solamente el autor de la alerta urbana puede editarla o eliminarla", "danger"=>"danger"]);
        } catch (\Exception $e) {
            return redirect()->route("alertas.index")->with(["mensaje" => "No fue posible borrar", "danger" => "danger"]);
        }
    }

    /**
     * Elabora un reporte en PDF
     * @return mixed
     */
    public function reporte()
    {
        $pdf = App::make("dompdf.wrapper");
        $alertas = Alerta::all();
        //return view("alertas_reporte", ["alertas" => $alertas]);
        $pdf->loadView("alertas_reporte", ["alertas" => $alertas]);
        $pdf->setPaper("letter", "portrait")->setWarnings(false);
        return $pdf->stream();
    }
}
