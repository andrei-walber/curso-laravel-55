@extends('adminlte::page')

@section('title', 'Novo Retirada')

@section('content_header')
    <h1>Fazer retirada</h1>

    <ol class="breadcrumb">
        <li><a href="">Dashboard</a></li>
        <li><a href="">Saldo</a></li>
        <li><a href="">Retirada</a></li>
    </ol>
@stop

@section('content')
    <div class="box">
        <div class="box-header">
            <p>Digite o valor que deseja retirar.</p>
        </div>
        <div class="box-body">
            @include('admin.includes.alerts')

            <form method="POST" action="{{ route('withdraw.store') }}">
                {!! csrf_field() !!}

                <div class="form-group">
                    <input class='form-control' name="value" type="text" placeholder="Valor Retirada">
                </div>
                <div class="form-group">
                    <button class='btn btn-success' type="submit">Sacar</button>
                </div>
            </form>
        </div>
    </div>
@stop