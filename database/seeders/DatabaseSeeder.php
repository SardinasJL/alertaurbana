<?php

namespace Database\Seeders;

use App\Models\Alerta;
use App\Models\Estado;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $unAdmin = User::create(["name" => "admin", "email" => "admin@admin.com", "password" => "12345678"]);
        $unCiudadano = User::create(["name" => "ciudadano", "email" => "ciudadano@ciudadano.com", "password" => "12345678"]);

        Estado::insert([
            ["descripcion" => "Peligroso", "color" => "#dc3545"],
            ["descripcion" => "Parcialmente solucionado", "color" => "#6c757d"],
            ["descripcion" => "Solucionado", "color" => "#198754"],
        ]);
        Alerta::create([
            "descripcion" => "Agujero muy peligroso",
            "direccion" => "Calle Beni",
            "latitud" => -21.449352,
            "longitud" => -65.716342,
            "foto" => "1.jpg",
            "users_id" => 2,
            "estados_id" => 2,
        ]);
        Alerta::create([
            "descripcion" => "Derrumbe",
            "direccion" => "Avenida San Juan",
            "latitud" => -21.447446,
            "longitud" => -65.712941,
            "foto" => "2.jpg",
            "users_id" => 1,
            "estados_id" => 1,
        ]);
        Alerta::create([
            "descripcion" => "Bache",
            "direccion" => "Avenida Chichas",
            "latitud" => -21.443283,
            "longitud" => -65.718842,
            "foto" => "3.jpg",
            "users_id" => 1,
            "estados_id" => 1,
        ]);
        Alerta::create([
            "descripcion" => "Canaleta a punto de caer",
            "direccion" => "Avenida Diego de Almagro",
            "latitud" => -21.433659,
            "longitud" => -65.719560,
            "foto" => "4.jpg",
            "users_id" => 2,
            "estados_id" => 2,
        ]);

        Permission::create(["name" => "alerta.index"]);
        Permission::create(["name" => "alerta.create"]);
        Permission::create(["name" => "alerta.edit"]);
        Permission::create(["name" => "alerta.delete"]);

        Permission::create(["name" => "user.index"]);
        Permission::create(["name" => "user.create"]);
        Permission::create(["name" => "user.edit"]);
        Permission::create(["name" => "user.delete"]);

        Permission::create(["name" => "role.index"]);
        Permission::create(["name" => "role.create"]);
        Permission::create(["name" => "role.edit"]);
        Permission::create(["name" => "role.delete"]);

        $rolAdministrador = Role::create(["name" => "administrador"]);
        $rolCiudadano = Role::create(["name" => "ciudadano"]);

        $rolAdministrador->syncPermissions([
            "alerta.index","alerta.create", "alerta.edit", "alerta.delete",
            "user.index", "user.create", "user.edit", "user.delete",
            "role.index", "role.create", "role.edit", "role.delete"
        ]);

        $rolCiudadano->syncPermissions([
            "alerta.index","alerta.create", "alerta.edit", "alerta.delete",
        ]);

        $unAdmin->syncRoles(["administrador"]);
        $unCiudadano->syncRoles(["ciudadano"]);

    }
}
