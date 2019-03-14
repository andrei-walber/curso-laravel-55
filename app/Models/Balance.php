<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\Array_;
use DB;
use App\User;

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

    public function transfer(float $value, User $sender) : Array
    {
        if($this->amount < $value) {
            return [
                'success' => false,
                'message' => 'Saldo insuficiente.',
            ];
        }

        DB::beginTransaction();

        /******************************************************
         * Atualiza o próprio saldo
         ******************************************************/
        $totalBefore = $this->amount ? $this->amount : 0;
        $this->amount -= $value;
        $transfer = $this->save();

        $historic = auth()->user()->historics()->create([
            'type'                => 'T',
            'amount'              => $value,
            'total_before'        => $totalBefore,
            'total_after'         => $this->amount,
            'date'                => date('Ymd'),
            'user_id_transaction' => $sender->id
        ]);

        /******************************************************
         * Atualiza o saldo do recebedor
         ******************************************************/
        $senderBalance = $sender->balance()->firstOrCreate([]);
        $totalBeforeSender = $senderBalance->amount ? $senderBalance->amount : 0;
        $senderBalance->amount += $value;
        $transferSender = $senderBalance->save();

        $historicSender = $sender->historics()->create([
            'type'                => 'I',
            'amount'              => $value,
            'total_before'        => $totalBeforeSender,
            'total_after'         => $senderBalance->amount,
            'date'                => date('Ymd'),
            'user_id_transaction' => auth()->user()->id
        ]);

        if( $transfer && $historic && $transferSender && $historicSender ) {
            DB::commit();

            return [
                'success' => true,
                'message' => 'Sucesso ao transferir!'
            ];
        } else {
            DB::rollback();

            return [
                'success' => false,
                'message' => 'Falha ao transferir!'
            ];
        }
    }
}
