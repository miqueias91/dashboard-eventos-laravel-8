<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Evento;
use App\Models\Pessoa;
use App\Notifications\NotificacaoEventos;
use Illuminate\Support\Facades\Notification;
use Auth;



class EventosController extends Controller{
    public function index(){
      $id = Auth::user()->id;
      $eventos = DB::select("SELECT 
                                ev.id,
                                ev.user_id,
                                ev.descricao,
                                ev.datahora, 
                                ev.status AS 'status_evento',
                                IF(p_conv.total_convidados,p_conv.total_convidados,0) AS 'total_convidados',
                                IF(p_conf.total_confirmados,p_conf.total_confirmados,0) AS 'total_confirmados'

                              FROM eventos ev

                              LEFT JOIN (
                                SELECT 
                                  COUNT(*) total_convidados,
                                  id_evento
                                FROM pessoas
                                WHERE status LIKE  'pendente'
                                GROUP BY id_evento
                              ) p_conv ON p_conv.id_evento = ev.id

                              LEFT JOIN (
                                SELECT 
                                  COUNT(*) total_confirmados,
                                  id_evento
                                FROM pessoas
                                WHERE status LIKE  'confirmado'
                                GROUP BY id_evento
                              ) p_conf ON p_conf.id_evento = ev.id

                              WHERE ev.user_id = '$id'
                              ORDER BY ev.status
                            ");
      return view('eventos', ['eventos' => $eventos]);
    }

    public function adicionar(){
      $pessoas = $this->listarPessoa();
		  return view('eventos_adicionar', ['pessoas' => $pessoas]);
    }

    public function salvar(Request $req){
      $id = Auth::user()->id;
      $dados = $req->all();
      $dado['user_id'] = $id;
      $dado['descricao'] = $dados['descricao'];
      $dado['datahora'] = $dados['data'];
      $dado['status'] = 'ativo';
      $id_evento = Evento::create($dado)->id;

      if ($dados['pessoas'][0]) {
        foreach ($dados['pessoas'] as $key => $value) {
          $dado_pessoa['id_pessoa'] = $value;
          $dado_pessoa['id_evento'] = $id_evento;
          $dado_pessoa['status'] = 'pendente';
          Pessoa::create($dado_pessoa)->id;
        }
      }
      return redirect()->route('eventos')->with('status','Evento cadastrado com sucesso!');
    }

    public function listarPessoa(){
      $pessoas = DB::select('SELECT * FROM users');
      return $pessoas;
    }

    public function cancelarEvento($id_evento){
      $id = Auth::user()->id;
      DB::update("UPDATE eventos SET status = 'inativo', updated_at = now() WHERE user_id = ? AND id = ?",[$id, $id_evento]);
      return redirect()->route('eventos')->with('status','Evento cancelado com sucesso!');
    }

    public function ativarEvento($id_evento){
      $id = Auth::user()->id;
      DB::update("UPDATE eventos SET status = 'ativo', updated_at = now() WHERE user_id = ? AND id = ?",[$id, $id_evento]);
      return redirect()->route('eventos')->with('status','Evento ativado com sucesso!');
    }

    public function exibirEvento($id_evento){
      $id = Auth::user()->id;
      $eventos = DB::select("SELECT 
                                ev.id,
                                ev.user_id,
                                ev.descricao,
                                ev.datahora, 
                                ev.status AS 'status_evento',
                                pe.id_pessoa,
                                pe.status AS 'status_pessoa',
                                us.name,
                                us.email

                              FROM eventos ev

                              LEFT JOIN pessoas pe ON pe.id_evento = ev.id
                              LEFT JOIN users us ON us.id = pe.id_pessoa

                              WHERE ev.user_id = '$id' AND ev.id = '$id_evento'
                            ");
      return view('eventos_editar', ['eventos' => $eventos]);
    }

    public function exibirEventosConvidado(){
      if (Auth::user()) {
        $id = Auth::user()->id;
        $eventos = DB::select("SELECT 
                                  ev.id,
                                  ev.user_id,
                                  ev.descricao,
                                  ev.datahora, 
                                  ev.status AS 'status_evento',
                                  pe.id_pessoa,
                                  pe.status AS 'status_pessoa',
                                  us.name,
                                  us.email

                                FROM eventos ev

                                INNER JOIN pessoas pe ON pe.id_evento = ev.id
                                INNER JOIN users us ON us.id = pe.id_pessoa

                                WHERE pe.id_pessoa = '$id' AND ev.datahora >= now()
                              ");
        return view('home', ['eventos' => $eventos]);
      }
      else{
        return view('login');
      }
    }

    public function editarEvento(Request $req, $id_evento){
      $id = Auth::user()->id;
      $dados = $req->all();
      $descricao = $dados['descricao'];
      $datahora = $dados['data'];
      DB::update("UPDATE eventos SET descricao = '$descricao', datahora = '$datahora', updated_at = now() WHERE user_id = ? AND id = ?",[$id, $id_evento]);
      return redirect()->route('eventos')->with('status','Evento alterado com sucesso!');
    }

    public function convidarPessoa($id_evento){
      $id = Auth::user()->id;
      $eventos = DB::select("SELECT 
                                ev.id,
                                ev.user_id,
                                ev.descricao,
                                ev.datahora, 
                                ev.status AS 'status_evento',
                                pe.id_pessoa,
                                pe.status AS 'status_pessoa',
                                us.name,
                                us.email

                              FROM eventos ev

                              LEFT JOIN pessoas pe ON pe.id_evento = ev.id
                              LEFT JOIN users us ON us.id = pe.id_pessoa

                              WHERE ev.user_id = '$id' AND ev.id = '$id_evento'
                            ");

      
      $pessoas = $this->listarPessoa();
      return view('eventos_convidar', ['eventos' => $eventos,'pessoas' => $pessoas]);
    }

    public function salvarPessoa(Request $req, $id_evento){
      $id = Auth::user()->id;
      $dados = $req->all();

      if (isset($dados['pessoas'][0])) {
        foreach ($dados['pessoas'] as $key => $value) {
          $dado_pessoa['id_pessoa'] = $value;
          $dado_pessoa['id_evento'] = $id_evento;
          $dado_pessoa['status'] = 'pendente';
          Pessoa::create($dado_pessoa)->id;
        }
        return redirect()->route('eventos')->with('status','Convite enviado com sucesso!');

      }
      else{
        return redirect()->route('eventos')->with('error','Você não seleciou nenhuma pessoa para o evento!');
      }
    }

    public function confirmarPessoa($id_evento){
      $id = Auth::user()->id;
      DB::update("UPDATE pessoas SET status = 'confirmado', updated_at = now() WHERE id_pessoa = ? AND id_evento = ?",[$id, $id_evento]);
      return redirect()->route('home')->with('status','Participação confirmada com sucesso!');
    }

    public function recusarPessoa($id_evento){
      $id = Auth::user()->id;
      DB::update("UPDATE pessoas SET status = 'recusado', updated_at = now() WHERE id_pessoa = ? AND id_evento = ?",[$id, $id_evento]);
      return redirect()->route('home')->with('status','Participação recusada com sucesso!');
    }
}
