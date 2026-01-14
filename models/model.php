<?php
require_once __DIR__ . "/../config/database.php";

class Aluno
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function listar()
    {
        $sql = "SELECT * FROM alunos";
        return $this->db->query($sql)->fetchAll();
    }

    public function criar($nome, $nota)
    {
        $situacao = ($nota >= 7) ? "Aprovado" : "Reprovado";

        $sql = "INSERT INTO alunos (nome, nota, situacao)
                VALUES (:nome, :nota, :situacao)";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ":nome" => $nome,
            ":nota" => $nota,
            ":situacao" => $situacao
        ]);
    }

    public function atualizar($nome, $nota)
    {
        $situacao = ($nota >= 7) ? "Aprovado" : "Reprovado";

        $sql = "UPDATE alunos
                SET nota = :nota, situacao = :situacao
                WHERE nome = :nome";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ":nota" => $nota,
            ":situacao" => $situacao,
            ":nome" => $nome
        ]);
    }

    public function remover($nome)
    {
        $sql = "DELETE FROM alunos WHERE nome = :nome";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([":nome" => $nome]);
    }
}
