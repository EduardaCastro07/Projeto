<?php
 
 if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (isset($_POST["id"]) && $_POST["id"] != null) ? $_POST["id"] : "";
    $nome = (isset($_POST["nome"]) && $_POST["nome"] != null) ? $_POST["nome"] : "";
    $email = (isset($_POST["email"]) && $_POST["email"] != null) ? $_POST["email"] : "";
    $celular = (isset($_POST["celular"]) && $_POST["celular"] != null) ? $_POST["celular"] : NULL;
} else if (!isset($id)) {
    // Se não se não foi setado nenhum valor para variável $id
    $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
    $nome = NULL;
    $email = NULL;
    $celular = NULL;
}

try {
    $conexao = new PDO("pgsql:host=localhost; dbname=postgres", "postgres", "pabd");
    echo "deu certo";
} catch (PDOException $erro) {
    echo "Erro na conexão:" . $erro->getMessage();
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Agenda de contatos</title>
    </head>
    <body>
        <form action="?act=save" method="POST" name="form1" >
          <h1>Agenda de contatos</h1>
          <hr>
          Nome: 
          <input type="text" name="nome" />
          Senha: 
          <input type="password" name="senha" />
          <br>
         <input type="submit" value="Entrar" />
         <hr>
       </form>
    </body>
</html>