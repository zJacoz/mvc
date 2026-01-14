<?php
require_once "views/view.php";
require_once "controllers/controller.php";
require_once "helpers/response.php";

function responses($status, $message, $data = null)
{
    return [
        "status" => $status,
        "message" => $message,
        "data" => $data
    ];
}

$controller = new AlunoController();

echo "1 - GET\n";
echo "2 - POST\n";
echo "3 - PUT\n";
echo "4 - DELETE\n";
echo "5 - Sair\n";

$op = trim(fgets(STDIN));

switch ($op) {
    case 1:
        render($controller->index());
        break;
    case 2:
        echo "Nome: ";
        $nome = trim(fgets(STDIN));

        echo "Nota: ";
        $nota = trim(fgets(STDIN));

        render($controller->store($nome, $nota));
        break;
    case 3:
        echo "Nome: ";
        $nome = trim(fgets(STDIN));

        echo "Nova nota: ";
        $nota = trim(fgets(STDIN));

        render($controller->update($nome, $nota));
        break;
    case 4:
        echo "Nome: ";
        $nome = trim(fgets(STDIN));
        render($controller->destroy($nome));
        break;
}
?>