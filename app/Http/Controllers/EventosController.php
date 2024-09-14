<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Eventos;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;


class EventosController extends Controller
{
    //para mostrar a tela administrativa

    public function MostrarHome(){
        return view('homeadm');
    }

    //para mostrar tela de cadastro de eventos
    public function MostrarCadastroEVentos(){
        return view('cadastroevento');
    }

    //para salvar os registros na tabela eventos
    public function CadastrarEventos(Request $request){
        $registros = $request->validate([
            'nomeEvento'=>'string | required',
            'dataEvento'=>'date | required',
            'localEvento'=>'string | required',
            'imgEvento'=>'string | required',
        ]);

        Eventos::create($registros);
        return Redirect::route('home-adm');
    }

    //para apagar os registrsos na tabela de eventos
    public function Destroy(Eventos $id){
        $id->delete();
        return Redirect::route('home-adm');
    }

    //para alterar os registros na tabela de eventos
    public function update(Eventos $id, Request $request){
        $registros = $request->validate([
            'nomeEvento'=>'string | required',
            'dataEvento'=>'date | required',
            'localEvento'=>'string | required',
            'imgEvento'=>'string | required',
        ]);
        $id->fill($registros);
        $id->save();

        return Redirect::route('home-adm');
    }

    //para mostrar somente os eventos por código
    public function MostrarEventosCodigo(Eventos $id){
        return view('altera-evento',['registrosEvento'->$id]);
    }

    //para buscar os eventos por nome
    public function MostrarEventosNome(Request $request){
        $registros = Eventos::query();
        $registros->when($request->nomeEvento, function($query,$valor){
            $query->where('nomeEvento','like','%'.$valor.'$');
        });
        $todosRegistros = $registros->get();
        return view('listaEventos',['registroEvento'=>$todosRegistros]);
        
    }
}

