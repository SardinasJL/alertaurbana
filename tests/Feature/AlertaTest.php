<?php

namespace Tests\Feature;

use App\Models\Alerta;
use App\Models\User;
use FontLib\Table\Type\post;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AlertaTest extends TestCase
{
    public function puedo_autenticarme()
    {
        return User::where("email", "admin@admin.com")->first();
    }

    public function test_index()
    {
        $admin = $this->puedo_autenticarme();
        $this->actingAs($admin);
        $response = $this->get(route("alertas.index"));
        $response->assertStatus(200);
    }

    public function test_create()
    {
        $admin = $this->puedo_autenticarme();
        $this->actingAs($admin);
        $response = $this->get(route("alertas.create"));
        $response->assertStatus(200);
    }

    public function test_store()
    {
        $admin = $this->puedo_autenticarme();
        $this->actingAs($admin);
        $foto = UploadedFile::fake()->image("foto.jpg");
        $response=$this->post(route("alertas.store"),[
            "descripcion"=>"prueba descripcion",
            "direccion"=>"prueba dirección",
            "latitud"=>-21,
            "longitud"=>-65,
            "foto"=>$foto,
            "estados_id"=>1
        ]);
        $this->assertDatabaseHas("alertas",["descripcion"=>"prueba descripcion"]);
        $response->assertRedirect(route("alertas.index"));
        Alerta::where("descripcion","prueba descripcion")->first()->delete();
    }
}
