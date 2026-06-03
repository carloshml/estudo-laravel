<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = ['nome', 'idade', 'documento', 'foto'];

    public function locacoes()
    {
        return $this->hasMany(LocacaoItem::class);
    }
}
