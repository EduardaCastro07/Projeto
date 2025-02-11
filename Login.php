<?php

// Verificar se foi enviando dados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = (isset($_POST["nome"]) && $_POST["nome"] != null) ? $_POST["nome"] : "";
    $senha = (isset($_POST["senha"]) && $_POST["senha"] != null) ? $_POST["senha"] : "";
    
} else if (!isset($nome)) {
    // Se não se não foi setado nenhum valor para variável $id
    $nome = (isset($_GET["nome"]) && $_GET["nome"] != null) ? $_GET["nome"] : "";
    $nome = NULL;
    $senha = NULL;
    
}

try {
    $conexao = new PDO("pgsql:host=localhost; dbname=Mukados", "postgres", "eduar26");
} catch (PDOException $erro) {
    echo "Erro na conexão:" . $erro->getMessage();
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $nome != "") {
    try {
        $stmt = $conexao->prepare("SELECT * FROM login WHERE usuario = :nome AND senha = :senha");
        $stmt->bindParam(1, $nome);
        $stmt->bindParam(2, $senha);
        $stmt->execute();
         
        // Verifica se encontrou um usuário com as credenciais fornecidas
        if ($stmt->rowCount() > 0) {
            // Usuário autenticado com sucesso
            $_SESSION['usuario'] = $nome;
            header("Location: pagina_protegida.php"); // Redireciona para a página desejada
            exit();
        } else {
            // Credenciais inválidas
            $erro = "Usuário ou senha incorretos.";
        }
    } catch (PDOException $erro) {
        echo "Erro na conexão: " . $erro->getMessage();
    }
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
          <?php
        // Exibe a mensagem de erro, se houver
            if (isset($erro)) {
                echo "<p style='color:red;'>$erro</p>";
            }
          ?>
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