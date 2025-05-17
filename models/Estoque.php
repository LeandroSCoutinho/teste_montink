<?php
class Estoque {
    public static function allByProduto($produto_id) {
        $stmt = DB::getConnection()->prepare("SELECT * FROM estoques WHERE produto_id = ?");
        $stmt->execute([$produto_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($produto_id, $variacao, $quantidade) {
        $stmt = DB::getConnection()->prepare("INSERT INTO estoques (produto_id, variacao, quantidade) VALUES (?, ?, ?)");
        $stmt->execute([$produto_id, $variacao, $quantidade]);
    }

    public static function update($id, $quantidade) {
        $stmt = DB::getConnection()->prepare("UPDATE estoques SET quantidade = ? WHERE id = ?");
        $stmt->execute([$quantidade, $id]);
    }

    public static function getByProdutoAndVariacao($produto_id, $variacao) {
        $stmt = DB::getConnection()->prepare("SELECT * FROM estoques WHERE produto_id = ? AND variacao = ?");
        $stmt->execute([$produto_id, $variacao]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}