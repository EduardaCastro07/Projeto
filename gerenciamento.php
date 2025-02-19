<?php

// Verificar se foi enviando dados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = (isset($_POST["nome"]) && $_POST["nome"] != null) ? $_POST["nome"] : "";
    $setor = (isset($_POST["setor"]) && $_POST["setor"] != null) ? $_POST["setor"] : "";
    $senha = (isset($_POST["senha"]) && $_POST["senha"] != null) ? $_POST["senha"] : NULL;
} else if (!isset($id)) {
    // Se não se não foi setado nenhum valor para variável $id
    $id = (isset($_GET["nome"]) && $_GET["nome"] != null) ? $_GET["nome"] : "";
    $nome = NULL;
    $setor = NULL;
    $senha = NULL;
}
try {
    $conexao = new PDO("pgsql:host=localhost; dbname=20221214010008", "postgres", "pabd");
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $erro) {
    echo "Erro na conexão:" . $erro->getMessage();
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $nome != "") {
    try {
        $stmt = $conexao->prepare("INSERT INTO login (usuario, setor, senha) VALUES (?, ?, ?)");
        $stmt->bindParam(1, $nome);
        $stmt->bindParam(2, $setor);
        $stmt->bindParam(3, $senha);
         
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                echo "Dados cadastrados com sucesso!";
                $nome = null;
                $setor = null;
                $senha = null;
            } else {
                echo "Erro ao tentar efetivar cadastro";
            }
        } else {
               throw new PDOException("Erro: Não foi possível executar a declaração sql");
        }
    } catch (PDOException $erro) {
        echo "Erro: " . $erro->getMessage();
    }
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Gerenciamento de usuários</title>
    </head>
    <body>
        <form action="?act=save" method="POST" name="form1" >
          <h1>Gerenciamento de usuários</h1>
          <hr>
          <input type="hidden" name="id" />
          Usuário:
          <input type="text" name="nome" />
          Setor:
          <input type="text" name="email" />
          Senha:
         <input type="password" name="celular" />
         <input type="submit" value="salvar" />
         <input type="reset" value="Novo" />
         <hr>
       </form>

       <table style="border: solid 1px black;width:100%">
            <tr>
                <th>Nome</th>
                <th>Setor</th>
                <th>Senha</th>
            </tr>
        </table>
    </body>
</html>