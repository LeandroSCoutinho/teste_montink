<?php
class Produto {
    public static function all() {
        return DB::getConnection()->query("SELECT * FROM produtos")->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id) {
        $stmt = DB::getConnection()->prepare("SELECT * FROM produtos WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($nome, $preco) {
        $stmt = DB::getConnection()->prepare("INSERT INTO produtos (nome, preco) VALUES (?, ?)");
        $stmt->execute([$nome, $preco]);
        return DB::getConnection()->lastInsertId();
    }

    public static function update($id, $nome, $preco) {
        $stmt = DB::getConnection()->prepare("UPDATE produtos SET nome = ?, preco = ? WHERE id = ?");
        $stmt->execute([$nome, $preco, $id]);
    }
}