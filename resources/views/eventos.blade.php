@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ __('Meus Eventos') }}
                    <a style="float: right;" class="btn btn-outline-primary" href="{{ route('adicionar') }}">Adicionar Novo Evento</a>
                </div>  
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif  

                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif                
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Ação</th>
                                <th scope="col">Status</th>
                                <th scope="col">Descrição</th>
                                <th scope="col">Horário do evento</th>
                                <th scope="col">Total de Convidados</th>
                                <th scope="col">Total de Confirmados</th>
                            </tr>
                        </thead>
                        @if (!empty($eventos[0]))
                            <tbody>
                            @foreach($eventos as $evento)
                                <tr>
                                    <th align="center" scope="row">{{$evento->id}}</th>
                                    <td align="center">
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <a class="btn btn-outline-primary" href="{{ route('exibir', $evento->id) }}" id_evento="{{$evento->id}}">Editar</a>
                                            @if ($evento->status_evento == 'ativo')
                                                <a class="btn btn-outline-danger cancelar_evento" descricao="{{$evento->descricao}}" id_evento="{{$evento->id}}" href="#">Cancelar</a>
                                            @else
                                                <a class="btn btn-outline-danger ativar_evento" descricao="{{$evento->descricao}}" id_evento="{{$evento->id}}" href="#">Ativar</a>
                                            @endif
                                            <a class="btn btn-outline-secondary convidar_evento" status_evento="{{$evento->status_evento}}" id_evento="{{$evento->id}}" href="#">Convidar</a>
                                        </div>
                                    </td>
                                    <td>{{strtoupper($evento->status_evento)}}</td>
                                    <td>{{$evento->descricao}}</td>
                                    <td>{{$evento->datahora}}</td>
                                    <td align="center">{{$evento->total_convidados}}</td>
                                    <td align="center">{{$evento->total_confirmados}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        @else
                            <tbody>
                                <tr>
                                    <td align="center" colspan="7">Nenhum evento cadastrado por você.</td>
                                </tr>
                            </tbody>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
