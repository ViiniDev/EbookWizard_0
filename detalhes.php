<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Ebook</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Detalhes do Ebook</h1>
        <p><a href="index.php">Voltar para a lista de ebooks</a></p>
        <div class="ebook-details">
            <?php
            $conexao = mysqli_connect("localhost:3305", "root", "admin", "ebooks");
            $id = $_GET['id'];
            $query = "SELECT * FROM ebooks WHERE id = $id";
            $result = mysqli_query($conexao, $query);
            $row = mysqli_fetch_assoc($result);

            echo "<h2>" . $row['titulo'] . "</h2>";
            echo "<p>Autor: " . $row['autor'] . "</p>";
            echo "<p>Preço: R$ " . number_format($row['preco'], 2, ',', '.') . "</p>";
            echo "<p>Descrição: " . $row['descricao'] . "</p>";

            mysqli_close($conexao);
            ?>
            <form action="carrinho.php" method="post">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <input type="submit" name="adicionar" value="Adicionar ao Carrinho">
            </form>
        </div>
    </div>
</body>
</html>
