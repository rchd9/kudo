<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Kudo;

class KudoCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'kudo_id',
        'subject',
        'comment'
    ];

    public function kudo()
    {
        return $this->belongsTo(Kudo::class);
    }
}
