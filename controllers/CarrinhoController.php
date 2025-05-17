<?php
session_start();
require_once '../config/db.php';
require_once '../models/Produto.php';
require_once '../models/Estoque.php';

$action = $_GET['action'] ?? 'add';

switch ($action) {
    case 'add':
        $produto_id = $_POST['produto_id'];
        $variacao = $_POST['variacao'];
        $quantidade = $_POST['quantidade'];

        $produto = Produto::find($produto_id);
        $estoque = Estoque::getByProdutoAndVariacao($produto_id, $variacao);

        if ($estoque && $estoque['quantidade'] >= $quantidade) {
            $_SESSION['carrinho'][] = [
                'produto_id' => $produto_id,
                'nome' => $produto['nome'],
                'preco' => $produto['preco'],
                'variacao' => $variacao,
                'quantidade' => $quantidade,
                'subtotal' => $produto['preco'] * $quantidade
            ];
            header('Location: ../views/carrinho/index.php');
        } else {
            echo "Estoque insuficiente";
        }
        break;

    case 'update':
        $index = $_POST['index'];
        $nova_qtd = (int)$_POST['quantidade'];

        if (isset($_SESSION['carrinho'][$index])) {
            $item = $_SESSION['carrinho'][$index];

            // Verifica estoque
            $estoque = Estoque::getByProdutoAndVariacao($item['produto_id'], $item['variacao']);
            if ($estoque && $estoque['quantidade'] >= $nova_qtd) {
                $_SESSION['carrinho'][$index]['quantidade'] = $nova_qtd;
                $_SESSION['carrinho'][$index]['subtotal'] = $item['preco'] * $nova_qtd;
            } else {
                echo "Estoque insuficiente para atualização.";
                exit;
            }
        }

        header('Location: ../views/carrinho/index.php');
        break;

    case 'delete':
        $index = $_POST['index'];
        if (isset($_SESSION['carrinho'][$index])) {
            unset($_SESSION['carrinho'][$index]);
            $_SESSION['carrinho'] = array_values($_SESSION['carrinho']); // Reindexar
        }
        header('Location: ../views/carrinho/index.php');
        break;
}
