<?php
require_once __DIR__ . "/../models/model.php";
require_once __DIR__ . "/../helpers/response.php";


class AlunoController
{
    private $model;

    public function __construct()
    {
        $this->model = new AlunoModel();
    }

    public function index()
    {
        $alunos = $this->model->listar();
        return response("success", "Lista de alunos", $alunos);
    }

    public function store($nome, $nota)
    {
        if (empty($nota) || !is_numeric($nota) || $nota < 0 || $nota > 10) {
            return response("error", "Dados inválidos.");
        }

        $this->model->criar($nome, $nota);
        return response("success", "Aluno criado.");
    }

    public function update($nome, $nota)
    {
        if (empty($nota) || !is_numeric($nota) || $nota < 0 || $nota > 10) {
            return response("error", "Dados inválidos.");
        }

        if(!$this->model->atualizar($nome, $nota)) {
            return response("error", "Aluno não encontrado.");
        }

        return response("success","Aluno atualizado.");
    }

    public function destroy($nome) {
        if(!$this->model->remover($nome)) {
            return response("error", "Aluno não encontrado.");
        }

        return response("success","Aluno removido.");
    }
}
?>