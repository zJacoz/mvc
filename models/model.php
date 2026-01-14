<?php
class AlunoModel
{
    private $arquivo = __DIR__ . "/../storage/alunos.json";

    public function listar()
    {
        if (!file_exists($this->arquivo)) {
            return [];
        }

        $json = file_get - contents($this->arquivo);
        return json_decode($json, true) ?? [];
    }

    public function salvar($alunos)
    {
        $json = json_encode($alunos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        file_put_contents($this->arquivo, $json);
    }

    public function criar($nome, $nota)
    {
        $alunos = $this->listar();

        $alunos[] = [
            "nome"=> $nome,
            "nota"=> $nota,
            "situacao" => ($nota >= 7) ? "Aprovado" : "Reprovado"
        ];

        $this->salvar($alunos);
    }

    public function atualizar($nome, $nota) {
        $alunos = $this->listar();
    } 
}
?>