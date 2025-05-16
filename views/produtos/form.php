<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Mini ERP</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
  <h2>Cadastro de Produto</h2>
  <form method="POST" action="controllers/ProdutoController.php?action=store">
    <div class="mb-3">
      <label>Nome</label>
      <input type="text" name="nome" class="form-control">
    </div>
    <div class="mb-3">
      <label>Preço</label>
      <input type="text" name="preco" class="form-control">
    </div>
    <div class="mb-3">
      <label>Variação</label>
      <input type="text" name="variacao" class="form-control">
    </div>
    <div class="mb-3">
      <label>Estoque</label>
      <input type="number" name="quantidade" class="form-control">
    </div>
    <button type="submit" class="btn btn-success">Salvar</button>
  </form>

  <h3 class="mt-5">Produtos</h3>
  <ul class="list-group">
    <?php foreach ($produtos as $p): ?>
      <li class="list-group-item">
        <?php echo $p['nome']. " - R$:". number_format($p['preco'], 2, ',', '.') ?>
      </li>
    <?php endforeach; ?>
  </ul>
</div>
</body>
</html>