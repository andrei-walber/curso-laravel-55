@extends('adminlte::page')

@section('title', 'Transferir Saldo')

@section('content_header')
    <h1>Transferir</h1>

    <ol class="breadcrumb">
        <li><a href="">Dashboard</a></li>
        <li><a href="">Saldo</a></li>
        <li><a href="">Transferir</a></li>
    </ol>
@stop

@section('content')
    <div class="box">
        <div class="box-header">
            <p>Transferir saldo, informe o destinatário: </p>
        </div>

        <div class="box-body">
            @include('admin.includes.alerts')

            <form method="POST" action="{{ route('confirm.transfer') }}">
                {!! csrf_field() !!}

                <div class="form-group">
                    <input class='form-control' name="sender" type="text" placeholder="Nome ou e-mail do destinatário">
                </div>

                <div class="form-group">
                    <button class='btn btn-success' type="submit">Próxima etapa</button>
                </div>
            </form>
        </div>
    </div>
@stop