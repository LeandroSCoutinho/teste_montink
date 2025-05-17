<?php
$produtos = Produto::all();
?>
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

  <div class="row">
    <?php foreach ($produtos as $produto): ?>
      <?php $modalId = 'comprarModal-' . $produto['id']; ?>
      <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title"><?= $produto['nome'] ?></h5>
            <?php if (!empty($produto['variacao'])): ?>
              <p class="text-muted mb-1">Variação: <?= $produto['variacao'] ?></p>
            <?php endif; ?>
            <p class="card-text">Preço: <strong>R$<?= number_format($produto['preco'], 2, ',', '.') ?></strong></p>
            <button type="button" class="btn btn-primary mt-auto" data-bs-toggle="modal" data-bs-target="#<?= $modalId ?>">
              Comprar
            </button>
          </div>
        </div>
      </div>

      <!-- Modal -->
      <div class="modal fade" id="<?= $modalId ?>" tabindex="-1" aria-labelledby="<?= $modalId ?>Label" aria-hidden="true">
        <div class="modal-dialog">
          <form action="controllers/CarrinhoController.php" method="post" class="modal-content">
            <input type="hidden" name="produto_id" value="<?= $produto['id'] ?>">
            <input type="hidden" name="preco" value="<?= $produto['preco'] ?>">

            <div class="modal-header">
              <h5 class="modal-title" id="<?= $modalId ?>Label">
                Comprar - <?= $produto['nome'] ?>
                <?php if (!empty($produto['variacao'])): ?>
                  <small class="text-muted"> (<?= $produto['variacao'] ?>)</small>
                <?php endif; ?>
              </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>

            <div class="modal-body">
              <p>Preço: R$<?= number_format($produto['preco'], 2, ',', '.') ?></p>

              <div class="mb-3">
                <label>Variação</label>
                <select name="variacao" class="form-select" required>
                  <?php
                  $estoques = Estoque::allByProduto($produto['id']);
                  foreach ($estoques as $estoque):
                    if ($estoque['quantidade'] > 0):
                  ?>
                    <option value="<?= $estoque['variacao'] ?>">
                      <?= $estoque['variacao'] ?> (<?= $estoque['quantidade'] ?> em estoque)
                    </option>
                  <?php
                    endif;
                  endforeach;
                  ?>
                </select>
              </div>

              <div class="mb-3">
                <label>Quantidade</label>
                <input type="number" name="quantidade" class="form-control" value="1" min="1" required>
              </div>
            </div>

            <div class="modal-footer">
              <button type="submit" class="btn btn-success">Adicionar ao Carrinho</button>
            </div>
          </form>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
