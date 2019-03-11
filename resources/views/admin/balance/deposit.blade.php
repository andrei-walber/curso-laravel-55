@extends('adminlte::page')

@section('title', 'Nova Recarga')

@section('content_header')
    <h1>Fazer depósito</h1>

    <ol class="breadcrumb">
        <li><a href="">Dashboard</a></li>
        <li><a href="">Saldo</a></li>
        <li><a href="">Depositar</a></li>
    </ol>
@stop

@section('content')
    <div class="box">
        <div class="box-header">
            <p>Digite o valor que deseja depositar.</p>
        </div>
        <div class="box-body">
            <form method="POST" action="{{ route('deposit.store') }}">
                {!! csrf_field() !!}
                <div class="form-group">
                    <input class='form-control' type="text" placeholder="Valor Recarga">
                </div>
                <div class="form-group">
                    <button class='btn btn-success' type="submit">Recarregar</button>
                </div>
            </form>
        </div>
    </div>
@stop