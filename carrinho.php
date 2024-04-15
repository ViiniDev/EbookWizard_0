<?php
session_start();

$total = 0;

$conexao = mysqli_connect("localhost:3305", "root", "admin", "ebooks");

if (isset($_POST['adicionar'])) {
    $id = $_POST['id'];
    if (!isset($_SESSION['carrinho'])) {
        $_SESSION['carrinho'] = [];
    }
    if (isset($_SESSION['carrinho'][$id]) && is_numeric($_SESSION['carrinho'][$id])) {
        $_SESSION['carrinho'][$id] ++;
    } else {
        $_SESSION['carrinho'][$id] = 1;
    }
}

if (isset($_GET['remover'])) {
    $id = $_GET['remover'];
    unset($_SESSION['carrinho'][$id]);
}

if (isset($_POST['atualizar'])) {
    foreach ($_POST['quantidade'] as $id => $quantidade) {
        if ($quantidade <= 0) {
            unset($_SESSION['carrinho'][$id]);
        } else {
            $_SESSION['carrinho'][$id] = $quantidade;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho de Compras</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Carrinho de Compras</h1>
        <p><a href="index.php">Voltar para a lista de ebooks</a></p>
        <div class="carrinho">
            <form action="" method="post">
                <table>
                    <tr>
                        <th>Ebook</th>
                        <th>Preço</th>
                        <th>Quantidade</th>
                        <th>Total</th>
                        <th>Remover</th>
                    </tr>
                    <?php foreach ($_SESSION['carrinho'] as $id => $quantidade): ?>
    <?php
    $query = "SELECT * FROM ebooks WHERE id = $id";
    $result = mysqli_query($conexao, $query);

    // Verifica se a consulta foi bem-sucedida e se há resultados
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Calcula o subtotal apenas se o preço for numérico
        if (is_numeric($quantidade) && is_numeric($row['preco'])) {
            $subtotal = floatval($row['preco']) * intval($quantidade);
            $total += $subtotal;

            // Exibe os detalhes do ebook
            ?>
            <tr>
                <td><?php echo $row['titulo']; ?></td>
                <td>R$ <?php echo number_format($row['preco'], 2, ',', '.'); ?></td>
                <td><input type="number" name="quantidade[<?php echo $id; ?>]" value="<?php echo $quantidade; ?>" min="1"></td>
                <td>R$ <?php echo number_format($subtotal, 2, ',', '.'); ?></td>
                <td><a href="carrinho.php?remover=<?php echo $id; ?>">Remover</a></td>
            </tr>
            <?php
        } else {
            // Se não for possível calcular o subtotal, você pode exibir uma mensagem de erro ou lidar com isso de outra maneira.
            echo "Erro ao calcular o subtotal.";
        }
    } else {
        // Se a consulta falhar ou não houver resultados, exiba uma mensagem ou trate de outra forma
        echo "Erro ao obter detalhes do ebook.";
    }
    ?>
<?php endforeach; ?>

                </table>
                <input type="submit" name="atualizar" value="Atualizar Carrinho">
            </form>
            <p>Total: R$ <?php echo number_format($total, 2, ',', '.'); ?></p>
            <p><a href="index.php">Continuar Comprando</a></p>
            <p><a href="checkout.php">Finalizar Compra</a></p>
        </div>
    </div>
</body>
</html>

<?php
mysqli_close($conexao);
?>
