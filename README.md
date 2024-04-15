Para executar o site : 
Baixar XAMPP, para prover o servidor que roda o PHP;
Baixar o MySQL Workcbench para criar uma base de dados com o nome :
  ebooks
  tabela com o nome :
    ebooks
    com os seguintes atributos :
      titulo varchar(), autor varchar(), descricao varchar(200), preco float
      e conectar no codigo a sua base de dados, $conexao = mysqli_connect("localhost", "user_do_mysql", "senha", "ebooks");
logo em seguida apenas rode o apache no XAMP e digite no navegador :
http://localhost/nome_da_pasta/index.php
