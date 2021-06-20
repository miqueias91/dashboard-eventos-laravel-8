@extends('layouts.app')

@section('content')
<div class="container">
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
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Eventos Pendentes') }}</div>

                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Ação</th>
                                <th scope="col">Descrição</th>
                                <th scope="col">Horário do evento</th>
                            </tr>
                        </thead>
                        @if (!empty($eventos[0]))
                            <tbody>
                            @foreach($eventos as $evento)
                                @if ($evento->status_pessoa == 'pendente')
                                    <tr>
                                        <th align="center" scope="row">{{$evento->id}}</th>
                                        <td align="center">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <a class="btn btn-outline-primary confirmar_evento" href="#" id_evento="{{$evento->id}}">Confirmar</a>
                                                
                                                <a class="btn btn-outline-secondary recusar_evento" id_evento="{{$evento->id}}" href="#">Recusar</a>
                                            </div>
                                        </td>
                                        <td>{{$evento->descricao}}</td>
                                        <td>{{$evento->datahora}}</td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        @else
                            <tbody>
                                <tr>
                                    <td align="center" colspan="4">Você não possui eventos pendentes.</td>
                                </tr>
                            </tbody>
                        @endif
                    </table>

                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Eventos Confirmados') }}</div>

                <div class="card-body">               
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Ação</th>
                                <th scope="col">Descrição</th>
                                <th scope="col">Horário do evento</th>
                            </tr>
                        </thead>
                        @if (!empty($eventos[0]))
                            <tbody>
                            @foreach($eventos as $evento)
                                @if ($evento->status_pessoa == 'confirmado')
                                    <tr>
                                        <th align="center" scope="row">{{$evento->id}}</th>
                                        <td align="center">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <a class="btn btn-outline-secondary recusar_evento" id_evento="{{$evento->id}}" href="#">Recusar</a>
                                            </div>
                                        </td>
                                        <td>{{$evento->descricao}}</td>
                                        <td>{{$evento->datahora}}</td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        @else
                            <tbody>
                                <tr>
                                    <td align="center" colspan="4">Você não possui eventos confirmados.</td>
                                </tr>
                            </tbody>
                        @endif
                    </table>

                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Eventos Recusados') }}</div>

                <div class="card-body">               
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Ação</th>
                                <th scope="col">Descrição</th>
                                <th scope="col">Horário do evento</th>
                            </tr>
                        </thead>
                        @if (!empty($eventos[0]))
                            <tbody>
                            @foreach($eventos as $evento)
                                @if ($evento->status_pessoa == 'recusado')
                                    <tr>
                                        <th align="center" scope="row">{{$evento->id}}</th>
                                        <td align="center">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <a class="btn btn-outline-primary confirmar_evento" href="#" id_evento="{{$evento->id}}">Confirmar</a>
                                            </div>
                                        </td>
                                        <td>{{$evento->descricao}}</td>
                                        <td>{{$evento->datahora}}</td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        @else
                            <tbody>
                                <tr>
                                    <td align="center" colspan="4">Você não possui eventos recusados.</td>
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
