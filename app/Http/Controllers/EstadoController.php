<?php

namespace App\Http\Controllers;

use App\Models\Estado;
use Illuminate\Http\Request;

class EstadoController extends Controller
{
    public function __construct()
    {
        $this->middleware("can:estado.index")->only("index");
        $this->middleware("can:estado.create")->only("create", "store");
        $this->middleware("can:estado.edit")->only("edit", "update");
        $this->middleware("can:estado.delete")->only("destroy");
    }

    public function validarForm(Request $request)
    {
        $request->validate([
            "descripcion" => "required|string|min:3|max:30",
            "color" => "required|string|min:3|max:10"
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $estados = Estado::all();
        return view("estados_index", ["estados" => $estados]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("estados_create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validarForm($request);
        Estado::create($request->all());
        return redirect()->route("estados.index")->with(["mensaje" => "Estado creado"]);

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
            $estado = Estado::findOrFail($id);
            return view("estados_edit", ["estado" => $estado]);
        } catch (\Exception $e) {
            return redirect()->route("estados.index")->with(["mensaje" => "Recurso no encontrado", "danger" => "danger"]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validarForm($request);
        try {
            $estado = Estado::findOrFail($id);
            $estado->update($request->all());
            return redirect()->route("estados.index")->with(["mensaje" => "Estado actualizado"]);
        } catch (\Exception $e) {
            return redirect()->route("estados.index")->with(["mensaje" => "No se encontró el registro", "danger" => "danger"]);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $estado = Estado::findOrFail($id);
            if ($estado->relAlerta->count() > 0)
                return redirect()->route("estados.index")->with(["mensaje" => "Este estado tiene alertas asociadas. Primero debe eliminar las alertas del tipo \"$estado->descripcion\"", "danger" => "danger"]);
            $estado->delete();
            return redirect()->route("estados.index")->with(["mensaje" => "Estado borrado"]);
        } catch (\Exception $e) {
            return redirect()->route("estados.index")->with(["mensaje" => "No se encontró el registro", "danger" => "danger"]);
        }
    }
}
