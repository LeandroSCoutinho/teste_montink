<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/Produto.php';
require_once __DIR__ . '/../models/Estoque.php';

$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'store':
        $nome = $_POST['nome'] ?? '';
        $preco = floatval($_POST['preco'] ?? 0);
        $variacao = $_POST['variacao'] ?? '';
        $quantidade = intval($_POST['quantidade'] ?? 0);

        if (isset($_POST['id']) && is_numeric($_POST['id'])) {
            Produto::update($_POST['id'], $nome, $preco);
        
        } else {
            $id = Produto::create($nome, $preco);
            Estoque::create($id, $variacao, $quantidade);
        }

        header("Location: ../index.php");
        exit;

    case 'index':
    default:
        $produtos = Produto::all();
        include __DIR__ . '/../views/produtos/form.php';
        break;
}
