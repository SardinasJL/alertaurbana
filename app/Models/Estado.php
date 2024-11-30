<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    protected $table = "estados";
    protected $primaryKey = "id";
    protected $guarded = ["id"];

    public function relAlerta()
    {
        return $this->hasMany(Alerta::class, "estados_id", "id");
    }
}
