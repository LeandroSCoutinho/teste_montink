<?php
session_start();

$carrinho = $_SESSION['carrinho'] ?? [];
$cep = $_SESSION['cep'] ?? '';

// Processa o CEP enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cep'])) {
    $cep = preg_replace('/[^0-9]/', '', $_POST['cep']);
    $_SESSION['cep'] = $cep;
}

$subtotal = 0;
foreach ($carrinho as $item) {
    $subtotal += $item['preco'] * $item['quantidade'];
}

// Cálculo do frete
$frete = 20;
if ($subtotal >= 52 && $subtotal <= 166.59) {
    $frete = 15;
} elseif ($subtotal > 200) {
    $frete = 0;
}

$total = $subtotal + $frete;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Carrinho</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
  <h2 class="mb-4">🛒 Carrinho</h2>

  <?php if (empty($carrinho)): ?>
    <div class="alert alert-warning">Seu carrinho está vazio.</div>
  <?php else: ?>
    <table class="table table-bordered bg-white">
      <thead class="table-secondary">
        <tr>
          <th>Produto</th>
          <th>Variação</th>
          <th>Preço</th>
          <th>Quantidade</th>
          <th>Subtotal</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($carrinho as $index => $item): ?>
        <tr>
          <td><?= $item['nome'] ?></td>
          <td><?= $item['variacao'] ?></td>
          <td>R$<?= number_format($item['preco'], 2, ',', '.') ?></td>
          <td>
            <form action="../../controllers/CarrinhoController.php?action=update" method="post" class="d-flex">
              <input type="hidden" name="index" value="<?= $index ?>">
              <input type="number" name="quantidade" value="<?= $item['quantidade'] ?>" class="form-control me-2" style="width: 80px;" min="1">
              <button class="btn btn-sm btn-primary">Atualizar</button>
            </form>
          </td>
          <td>R$<?= number_format($item['preco'] * $item['quantidade'], 2, ',', '.') ?></td>
          <td>
            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete(<?= $index ?>)">Remover</button>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>

    <!-- CEP -->
    <form method="post" action="" class="row g-2 align-items-end">
      <div class="col-md-4">
        <label class="form-label">CEP para cálculo de frete:</label>
        <input type="text" name="cep" class="form-control" placeholder="Digite o CEP" pattern="\d{5}-?\d{3}" value="<?= htmlspecialchars($cep) ?>" required>
      </div>
      <div class="col-auto">
        <button type="submit" class="btn btn-warning">Calcular Frete</button>
      </div>
    </form>

    <!-- Totais -->
    <div class="mt-4">
      <p><strong>Subtotal:</strong> R$<?= number_format($subtotal, 2, ',', '.') ?></p>
      <p><strong>Frete:</strong> R$<?= number_format($frete, 2, ',', '.') ?></p>
      <p><strong>Total:</strong> R$<?= number_format($total, 2, ',', '.') ?></p>

      <?php if (!$cep): ?>
        <div class="alert alert-danger">Informe o CEP para continuar com a finalização do pedido.</div>
      <?php endif; ?>

      <a href="<?= $cep ? 'finalizar.php' : '#' ?>" class="btn btn-success <?= !$cep ? 'disabled' : '' ?>">Finalizar Pedido</a>
    </div>
  <?php endif; ?>
</div>

<!-- Modal de Confirmação -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="confirmDeleteForm" method="post" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Remoção</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        Tem certeza de que deseja remover este item do carrinho?
      </div>
      <input type="hidden" name="index" id="deleteIndexInput">
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-danger">Remover</button>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  const deleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
  const deleteForm = document.getElementById('confirmDeleteForm');
  const deleteInput = document.getElementById('deleteIndexInput');

  function confirmDelete(index) {
    deleteInput.value = index;
    deleteForm.action = '../../controllers/CarrinhoController.php?action=delete';
    deleteModal.show();
  }
</script>
</body>
</html>
