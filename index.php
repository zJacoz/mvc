<?php
function menu($op)
{
    switch ($op) {
        case 1:
            echo json_encode(api_listar_aluno(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
            break;
        case 2:
            echo "Nome: ";
            $nome = trim(fgets(STDIN));

            echo "Nota: ";
            $nota = trim(fgets(STDIN));
            echo json_encode(api_criar_aluno($nome, $nota), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
            break;
        case 3:
            echo "Nome: ";
            $nome = trim(fgets(STDIN));

            echo "Nova nota: ";
            $nota = trim(fgets(STDIN));

            echo json_encode(
                api_atualizar_aluno($nome, $nota),
                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
            ) . "\n";

            break;
        case 4:
            echo "Nome: ";
            $nome = trim(fgets(STDIN));

            echo json_encode(api_remover_aluno($nome), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
            break;
    }
}

// BASE API
function response($status, $message, $data = null)
{
    return [
        "status" => $status,
        "message" => $message,
        "data" => $data,
    ];
}

// ENDPOINT => LISTAR

function api_listar_aluno()
{
    $alunos = carregarAluno();

    if (empty($alunos)) {
        return response("error", "Nenhum aluno encontrado.");
    }

    return response("success", "Alunos encontrados.", $alunos);
}

// ENDPOINT => CRIAR

function api_criar_aluno($nome, $nota)
{
    if (empty($nome) || !is_numeric($nota) || $nota < 0 || $nota > 10) {
        return response("error", "Dados inválidos.");
    }

    $alunos = carregarAluno();

    $situacao = ($nota >= 7) ? "Aprovado" : "Reprovado";

    $alunos[] = [
        "nome" => $nome,
        "nota" => $nota,
        "situacao" => $situacao,
    ];

    salvarAluno($alunos);

    return response("success", "Aluno cadastrado com sucesso.");
}

// ENDPOINT => ATUALIZAR

function api_atualizar_aluno($nome, $novaNota)
{
    if (empty($nome) || !is_numeric($novaNota) || $novaNota < 0 || $novaNota > 10) {
        return response("error", "Dados inválidos.");
    }

    $alunos = carregarAluno();
    $encontrado = false;

    foreach ($alunos as $i => $a) {
        if (strtolower($a["nome"]) === strtolower($nome)) {
            $alunos[$i]["nota"] = $novaNota;
            $alunos[$i]["situacao"] = ($novaNota > 7) ? "Aprovado" : "Reprovado";

            $encontrado = true;
            break;
        }
    }

    if (!$encontrado) {
        return response("error", "Aluno não encontrado.");
    }

    salvarAluno($alunos);

    return response("success", "Aluno atualizado com sucesso.");
}

// ENDPOINT => REMOVER ALUNO

function api_remover_aluno($nome)
{
    $alunos = carregarAluno();
    $encontrado = false;

    foreach ($alunos as $i => $a) {
        if (strtolower($a["nome"]) === strtolower($nome)) {
            unset($alunos[$i]);
            $encontrado = true;
            break;
        }
    }

    if (!$encontrado) {
        return response("error", "Aluno não encontrado.");
    }

    salvarAluno(array_values($alunos));
    return response("success", "Aluno removido.");
}

function salvarAluno($alunos)
{
    $json = json_encode($alunos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    file_put_contents("alunos.json", $json);
}

function carregarAluno()
{
    if (!file_exists("alunos.json")) {
        return [];
    }

    $json = file_get_contents("alunos.json");
    return json_decode($json, true) ?? [];
}

$op = 0;

while ($op != 5) {
    echo "1 - GET alunos.\n";
    echo "2 - POST aluno.\n";
    echo "3 - PUT aluno.\n";
    echo "4 - DELETE aluno.\n";
    echo "5 - Sair.\n";

    $op = trim(fgets(STDIN));

    if (!is_numeric($op) || $op < 1 || $op > 5 || empty($op)) {
        echo "Comando inválido.\n";
        continue;
    }

    if ($op == 5) {
        echo "Saindo...\n";
        break;
    }

    menu($op);

}
?>