@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ __('Editar Evento') }}
                    <a style="float: right;" class="btn btn-outline-primary"  id="salvar_convite" href="#">Enviar Convite</a>
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
                    <form method="post" action="{{ route('salvarPessoa', $eventos[0]->id) }}" id="form_convidar_evento">
                        @csrf
                        <div class="form-group">
                            <label for="descricao">Descrição</label>
                            <input type="text" class="form-control" value="{{$evento->descricao}}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="data">Data do Evento</label>
                            <input type="datetime-local" class="form-control" value="{{$horario}}" disabled>
                        </div>

                        <br>
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        {{ __('Convidar para o Evento') }}
                                    </div>  
                                    <div class="card-body">                 
                                        <div id="div_pessoas">
                                            <div class="form-group">
                                                <?php 
                                                    if ($pessoas) {
                                                ?>
                                                        <select multiple class="form-control" id="pessoas" name="pessoas[]">
                                                            @foreach($pessoas as $pessoa)
                                                                <option value="{{$pessoa->id}}">{{$pessoa->email}}</option>
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
