<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alerta extends Model
{
    protected $table = "alertas";
    protected $primaryKey = "id";
    protected $guarded = ["id"];

    public function relEstado()
    {
        return $this->belongsTo(Estado::class, "estados_id", "id");
    }
    public function relUser()
    {
        return $this->belongsTo(User::class, "users_id", "id");
    }
}
