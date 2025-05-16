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
  <form method="POST" action="#">
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

</div>
</body>
</html>