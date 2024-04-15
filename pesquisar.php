<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado da Pesquisa</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <!-- Aqui você pode adicionar o local pequeno para a logo -->
        <div class="logo">
            <img src="logo.png" alt="Logo">
        </div>
        <!-- Barra de pesquisa -->
        <form action="pesquisar.php" method="GET" class="search-form">
            <input type="text" name="q" placeholder="Pesquisar...">
            <button type="submit">Buscar</button>
        </form>
        <!-- Formulário de login -->
        <form action="login.php" method="POST" class="login-form">
            <input type="text" name="usuario" placeholder="Usuário">
            <input type="password" name="senha" placeholder="Senha">
            <button type="submit">Login</button>
        </form>
        <!-- Botão para se cadastrar -->
        <a href="cadastro.php" class="cadastro-link">Cadastrar</a>
        <!-- Carrinho -->
        <a href="carrinho.php" class="carrinho-link">Carrinho</a>
    </header>

    <div class="container">
        <h1>Resultado da Pesquisa</h1>
        <div class="ebook-list">
            <?php
            // Verifica se o parâmetro "q" está presente na URL
            if (isset($_GET['q'])) {
                $conexao = mysqli_connect("localhost:3305", "root", "admin", "ebooks");
                // Limpa e protege contra injeção de SQL
                $termo_pesquisa = mysqli_real_escape_string($conexao, $_GET['q']);
                $query = "SELECT * FROM ebooks WHERE titulo LIKE '%$termo_pesquisa%'";
                $result = mysqli_query($conexao, $query);

                // Verifica se há resultados
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<div class='ebook'>";
                        echo "<h2>" . $row['titulo'] . "</h2>";
                        echo "<p>Autor: " . $row['autor'] . "</p>";
                        echo "<p>Preço: R$ " . number_format($row['preco'], 2, ',', '.') . "</p>";
                        echo "<p><a href='detalhes.php?id=" . $row['id'] . "'>Ver Detalhes</a></p>";
                        echo "<form action='carrinho.php' method='post'>";
                        echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
                        echo "<input type='submit' name='adicionar' value='Adicionar ao Carrinho'>";
                        echo "</form>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>Nenhum resultado encontrado para '" . $termo_pesquisa . "'</p>";
                }

                mysqli_close($conexao);
            } else {
                echo "<p>Nenhum termo de pesquisa fornecido.</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>
