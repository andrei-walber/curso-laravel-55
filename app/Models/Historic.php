<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Historic extends Model
{
    protected $fillable = [
        'type',
        'amount',
        'total_before',
        'total_after',
        'user_id_transaction',
        'date'
    ];

    public function type($type = null)
    {
        $types = [
            'I' => 'Entrada',
            'O' => 'Saída',
            'T' => 'Transferência',
        ];

        if(!$type){
            return $types;
        } elseif ($this->user_id_transaction != null && $type == 'I') {
            return 'Recebido';
        } else{
            return $types[$type];
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function userSender()
    {
        return $this->belongsTo(User::class, 'user_ide_transaction');
    }

    public function getDateAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }
}
