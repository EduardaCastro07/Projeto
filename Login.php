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
         
        if ($stmt->rowCount() > 0) {
            $_SESSION['usuario'] = $nome;
            header("Location: pagina_protegida.php"); 
            exit();
        } else {
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
        <title>Mukados</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <form style="width: 40%;margin:auto;margin-top:10%" action="?act=save" method="POST" name="form1" >
          <h1 style="font-style: normal;">Login</h1>
          <?php

            if (isset($erro)) {
                echo "<p style='color:red;'>$erro</p>";
            }
          ?>
          <div style="display: flex;">
            Usuário:    
            <div><input type="text" name="nome" /> <br></div>
          </div>
          <div style="display:flex">
            Senha: 
            <div><input type="password" name="Senha" /></div>
            <br>
          </div>
         <input class="entrar" type="submit" value="Entrar" />
       </form>
    </body>
</html>