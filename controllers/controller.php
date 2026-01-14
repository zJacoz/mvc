<?php
require_once __DIR__ . "/../models/Aluno.php";
require_once __DIR__ . "/../helpers/response.php";

class AlunoController
{
    private Aluno $model;

    public function __construct()
    {
        $this->model = new Aluno();
    }

    public function index()
    {
        $alunos = $this->model->listar();

        if (empty($alunos)) {
            return response("error", "Nenhum aluno encontrado");
        }

        return response("success", "Alunos encontrados", $alunos);
    }

    public function store($nome, $nota)
    {
        if (empty($nome) || !is_numeric($nota) || $nota < 0 || $nota > 10) {
            return response("error", "Dados inválidos");
        }

        $this->model->criar($nome, $nota);
        return response("success", "Aluno criado com sucesso");
    }

    public function update($nome, $nota)
    {
        if (empty($nome) || !is_numeric($nota)) {
            return response("error", "Dados inválidos");
        }

        $this->model->atualizar($nome, $nota);
        return response("success", "Aluno atualizado");
    }

    public function destroy($nome)
    {
        $this->model->remover($nome);
        return response("success", "Aluno removido");
    }
}
