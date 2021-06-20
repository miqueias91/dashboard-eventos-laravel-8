@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ __('Editar Evento') }}
                    <a style="float: right;" class="btn btn-outline-primary"  id="editar_evento" href="#">Salvar Evento</a>
                </div>  
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif                  
                    <?php 
                        $evento = $eventos[0];
                        $horario = date("Y-m-d\TH:i:s", strtotime($evento->datahora));
                    ?>                
                    <form method="post" action="{{ route('editar', $eventos[0]->id) }}" id="form_editar_evento">
                        @csrf
                        <div class="form-group">
                            <label for="descricao">Descrição</label>
                            <input type="text" class="form-control" id="descricao" name="descricao" placeholder="Descrição" value="{{$evento->descricao}}">
                        </div>
                        <div class="form-group">
                            <label for="data">Data do Evento</label>
                            <input type="datetime-local" class="form-control" id="data" name="data" value="{{$horario}}">
                        </div>

                        <br>
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        {{ __('Convidados Pendentes') }}
                                    </div>  
                                    <div class="card-body">                 
                                        <div id="div_pessoas">
                                            <div class="form-group">
                                                <?php 
                                                    if ($eventos) {
                                                ?>
                                                        <select multiple class="form-control" disabled>
                                                            @foreach($eventos as $pessoa)
                                                                @if ($pessoa->status_pessoa == 'pendente')
                                                                    <option value="{{$pessoa->id_pessoa}}">{{$pessoa->email}}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                <?php 
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        {{ __('Convidados Confirmados') }}
                                    </div>  
                                    <div class="card-body">                 
                                        <div id="div_pessoas">
                                            <div class="form-group">
                                                <?php 
                                                    if ($eventos) {
                                                ?>
                                                        <select multiple class="form-control" disabled>
                                                            @foreach($eventos as $pessoa)
                                                                @if ($pessoa->status_pessoa == 'confirmado')
                                                                    <option value="{{$pessoa->id_pessoa}}">{{$pessoa->email}}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                <?php 
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        {{ __('Convidados Recusados') }}
                                    </div>  
                                    <div class="card-body">                 
                                        <div id="div_pessoas">
                                            <div class="form-group">
                                                <?php 
                                                    if ($eventos) {
                                                ?>
                                                        <select multiple class="form-control" disabled>
                                                            @foreach($eventos as $pessoa)
                                                                @if ($pessoa->status_pessoa == 'recusado')
                                                                    <option value="{{$pessoa->id_pessoa}}">{{$pessoa->email}}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                <?php 
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
