<?php
require_once "controllers/controller.php";

$controller = new AlunoController();

while (true) {
    echo "1 - GET alunos\n";
    echo "2 - POST aluno\n";
    echo "3 - PUT aluno\n";
    echo "4 - DELETE aluno\n";
    echo "5 - Sair\n";

    $op = trim(fgets(STDIN));

    if ($op == 5) break;

    switch ($op) {
        case 1:
            echo json_encode($controller->index(), JSON_PRETTY_PRINT) . "\n";
            break;

        case 2:
            echo "Nome: ";
            $nome = trim(fgets(STDIN));
            echo "Nota: ";
            $nota = trim(fgets(STDIN));

            echo json_encode($controller->store($nome, $nota), JSON_PRETTY_PRINT) . "\n";
            break;

        case 3:
            echo "Nome: ";
            $nome = trim(fgets(STDIN));
            echo "Nova nota: ";
            $nota = trim(fgets(STDIN));

            echo json_encode($controller->update($nome, $nota), JSON_PRETTY_PRINT) . "\n";
            break;

        case 4:
            echo "Nome: ";
            $nome = trim(fgets(STDIN));

            echo json_encode($controller->destroy($nome), JSON_PRETTY_PRINT) . "\n";
            break;
    }
}
