<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocacaoItem extends Model
{
    protected $table = 'locacao_item';

    protected $fillable = ['item_id', 'pessoa_id', 'location', 'inicio', 'fim', 'status'];

    protected $casts = [
        'inicio' => 'datetime',
        'fim' => 'datetime',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class);
    }
}
