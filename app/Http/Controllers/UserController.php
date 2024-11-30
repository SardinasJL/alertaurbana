<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware("can:user.index")->only("index");
        $this->middleware("can:user.create")->only("create","store");
        $this->middleware("can:user.edit")->only("edit","update");
        $this->middleware("can:user.delete")->only("destroy");
    }

    public function validarForm(Request $request, string $id = null)//Para el método create no se envía el argumento $id, para el método update sí se envía $id
    {
        $request->validate([
            "name" => isset($id) ? "required|string|min:3|max:100|unique:users,name,$id" : "required|string|min:3|max:100|unique:users,name,",
            "email" => isset($id) ? "required|email|unique:users,email,$id" : "required|email|unique:users,email",
            "password" => "required|string|min:3|max:100"
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view("users_index", ["users" => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view("users_create", ["roles" => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validarForm($request);
        $user = User::create($request->all());
        $user->syncRoles($request["roles"]);
        return redirect()->route("users.index")->with(["mensaje" => "Usuario creado"]);
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
            $user = User::findOrFail($id);
            $roles = Role::all();
            return view("users_edit", ["user" => $user, "roles" => $roles]);
        } catch (\Exception $e) {
            return redirect()->route("users.index")->with(["mensaje" => "No se encontró al usuario", "danger" => "danger"]);
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validarForm($request, $id);
        try {
            $user = User::findOrFail($id);
            if ($request->password == $user->password)//Si la contraseña es la misma, no se actualiza
                $user->update($request->except("password"));
            else
                $user->update($request->all());
            $user->syncRoles($request["roles"]);
            return redirect()->route("users.index")->with(["mensaje" => "Usuario actualizado"]);
        } catch (\Exception $e) {
            return redirect()->route("users.index")->with(["mensaje" => "No se encontró al usuario", "danger" => "danger"]);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);
            if ($user->relAlerta->count() > 0)
                return redirect()->route("users.index")->with(["mensaje" => "El usuario creó alertas urbanas. Borre las alertas primeramente antes de borrar al usuario", "danger" => "danger"]);
            $user->delete();
            return redirect()->route("users.index")->with(["mensaje" => "Usuario borrado"]);
        } catch (\Exception $e) {
            return redirect()->route("users.index")->with(["mensaje" => "No se encontró al usuario", "danger" => "danger"]);
        }
    }
}
