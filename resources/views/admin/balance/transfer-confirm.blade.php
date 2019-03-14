@extends('adminlte::page')

@section('title', 'Confirmar Transferência')

@section('content_header')
    <h1>Confirmar transferência.</h1>

    <ol class="breadcrumb">
        <li><a href=""> Dashboard </a></li>
        <li><a href=""> Saldo </a></li>
        <li><a href=""> Transferir </a></li>
        <li><a href=""> Confirmação </a></li>
    </ol>
@stop

@section('content')
    <div class="box">
        <div class="box-header">
            <p> Confirmar transferência de saldo: </p>
        </div>

        <div class="box-body">
            @include('admin.includes.alerts')

            <p> Recebedor: <strong> {{ $sender->name }} </strong> </p>
            <p> Saldo atual: <strong> R$ {{ number_format($balance->amount, '2', ',', '.') }} </strong> </p>

            <form method="POST" action="{{ route('transfer.store') }}">
                {!! csrf_field() !!}

                <input name="sender_id" type="hidden" value="{{ $sender->id }}">

                <div class="form-group">
                    <input class='form-control' name="value" type="text" placeholder="Valor de transferência">
                </div>

                <div class="form-group">
                    <button class='btn btn-success' type="submit">Transferir</button>
                </div>
            </form>
        </div>
    </div>
@stop