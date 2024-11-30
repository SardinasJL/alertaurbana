<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware("can:role.index")->only("index");
        $this->middleware("can:role.create")->only("create", "store");
        $this->middleware("can:role.edit")->only("edit", "update");
        $this->middleware("can:role.delete")->only("destroy");
    }

    /**
     * Valida un request.
     * @param Request $request
     * @return void
     */
    public function validarForm(Request $request)
    {
        $request->validate([
            "name" => "required|string|min:3|max:50"
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $roles = Role::all();
        return view("roles_index", ["roles" => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();
        return view("roles_create", ["permissions" => $permissions]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validarForm($request);
        $role = Role::create($request->all());
        $role->syncPermissions($request->permissions);
        return redirect()->route("roles.index")->with(["mensaje" => "Rol creado"]);
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
            $role = Role::findOrFail($id);
            $permissions = Permission::all();
            return view("roles_edit", ["role" => $role, "permissions" => $permissions]);
        } catch (\Exception $e) {
            return redirect()->route("roles.index")->with(["mensaje" => "Rol no encontrado", "danger" => "danger"]);
        }


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validarForm($request);
        try {
            $role = Role::findOrFail($id);
            $role->update($request->all());
            $role->syncPermissions($request->permissions);
            return redirect()->route("roles.index")->with(["mensaje" => "Rol actualizado"]);
        } catch (\Exception $e) {
            return redirect()->route("roles.index")->with(["mensaje" => "No se encontró el rol", "danger" => "danger"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $role = Role::findOrFail($id);
            $role->delete();
            return redirect()->route("roles.index")->with(["mensaje" => "Rol borrado"]);
        } catch (\Exception $e) {
            return redirect()->route("roles.index")->with(["mensaje" => "No se encontró el rol", "danger" => "danger"]);
        }

    }
}
