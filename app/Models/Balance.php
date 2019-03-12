<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\Array_;

class Balance extends Model
{
    public $timestamps = false;

    public function deposit(float $value) : Array
    {
        $totalBefore = $this->amount ? $this->amount : 0;
        $this->amount += $value;
        $deposit = $this->save();

        $historic = auth()->user()->historics()->create([
            'type'         => 'I',
            'amount'       => $value,
            'total_before' => $totalBefore,
            'total_after'  => $this->amount,
            'date'         => date('Ymd'),
        ]);

        if ($deposit && $historic){
            return [
                'success' => true,
                'message' => 'Depósito feito com sucesso'
            ];
        }

        return [
            'success' => false,
            'message' => 'Falha no depósito'
        ];
    }
}
