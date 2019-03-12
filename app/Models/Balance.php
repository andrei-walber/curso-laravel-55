<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\Array_;

class Balance extends Model
{
    public $timestamps = false;

    public function deposit(float $value) : Array
    {
        $this->amount += $value;
        $deposit = $this->save();

        if ($deposit){
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
