<?php

namespace Src\Controllers;

use Src\Conexao;

class ClienteController 
{
	protected $clientes = [
		['id' => 1, 'nome' => 'Antônio Silva', 'telefone' => '119990000'],
		['id' => 2, 'nome' => 'João Silva', 'telefone' => '158999999'],
		['id' => 3, 'nome' => 'Maria Silva', 'telefone' => '119999001'],
		['id' => 4, 'nome' => 'Marta Santos', 'telefone' => '189990001'],
		['id' => 5, 'nome' => 'Paulo Moura', 'telefone' => '1799990002'],
	];

	public function index()
	{


		$data = array_map(function($row){

			return '<tr><td>' . $row['nome'] . '</td><td>' . $row['telefone'] . '</td><td><a href="' . route('clientes.show', $row['id'])  .'">Detalhes</a></td></tr>';

		}, $this->clientes);

		echo '<table align="center">' . implode('', $data) .'</table>';

	}

	public function show($id) 
	{

		foreach ($this->clientes as $row) {
			if($row['id'] == $id) {
				$cliente = $row;
				break;
			}
		}
		view("contato\\form",$this->clientes);

		// $data = 'nome: ' . $cliente['nome'] . '</br>telefone: ' . $cliente['telefone'];
		// $data .= "<br /><a href='" . route('clientes.index') . "'>Clique aqui para voltar para lista</a>";
		// echo $data;

	}

	public function teste(){
	 echo json_encode(['msg'=>'funcionou']);
	}
//------------------------ proximo -----------------------------
	
 
    /**
     * Lista os contatos
     */
    public function listar()
    {
        $contatos = Contato::all();
        return $this->view('grade', ['contatos' => $contatos]);
    }
 
    /**
     * Mostrar formulario para criar um novo contato
     */
    public function criar()
    {
        return $this->view('form');
    }
 
    /**
     * Mostrar formulário para editar um contato
     */
    public function editar($dados)
    {
        $id      = (int) $dados['id'];
        $contato = Contato::find($id);
 
        return $this->view('form', ['contato' => $contato]);
    }
 
    /**
     * Salvar o contato submetido pelo formulário
     */
    public function salvar()
    {
        $contato           = new Contato;
        $contato->nome     = $this->request->nome;
        $contato->telefone = $this->request->telefone;
        $contato->email    = $this->request->email;
        if ($contato->save()) {
            return $this->listar();
        }
    }
 
    /**
     * Atualizar o contato conforme dados submetidos
     */
    public function atualizar($dados)
    {
        $id                = (int) $dados['id'];
        $contato           = Contato::find($id);
        $contato->nome     = $this->request->nome;
        $contato->telefone = $this->request->telefone;
        $contato->email    = $this->request->email;
        $contato->save();
 
        return $this->listar();
    }
 
    /**
     * Apagar um contato conforme o id informado
     */
    public function excluir($dados)
    {
        $id      = (int) $dados['id'];
        $contato = Contato::destroy($id);
        return $this->listar();
	}
	
}
