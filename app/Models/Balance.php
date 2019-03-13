<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\Array_;
use DB;

class Balance extends Model
{
    public $timestamps = false;

    public function deposit(float $value) : Array
    {
        DB::beginTransaction();

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
            DB::commit();

            return [
                'success' => true,
                'message' => 'Depósito feito com sucesso'
            ];
        } else {
            DB::rollback();

            return [
                'success' => false,
                'message' => 'Falha no depósito'
            ];
        }
    }

    public function withdraw(float $value) : Array
    {
        if($this->amount < $value) {
            return [
                'success' => false,
                'message' => 'Saldo insuficiente.',
            ];
        }

        DB::beginTransaction();

        $totalBefore = $this->amount ? $this->amount : 0;
        $this->amount -= $value;
        $withdraw = $this->save();

        $historic = auth()->user()->historics()->create([
            'type'         => 'O',
            'amount'       => $value,
            'total_before' => $totalBefore,
            'total_after'  => $this->amount,
            'date'         => date('Ymd'),
        ]);

        if ($withdraw && $historic){
            DB::commit();

            return [
                'success' => true,
                'message' => 'Saque feito com sucesso'
            ];
        } else {
            DB::rollback();

            return [
                'success' => false,
                'message' => 'Falha na retirada'
            ];
        }
    }
}
