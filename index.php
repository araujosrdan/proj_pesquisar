<?php
    try {
        $pdo = new PDO("mysql:dbname=proj_pesquisa;host=localhost", "root", "");
    } catch (PDOExpection $e) {
        echo "Erro: " . $e->getMessage();
        exit();
    }
?>

<h1>Digite email ou cpf do usuário:</h1>
<form action="" method="get">
    <input type="text" name="busca" />
    <input type="submit" value="Pesquisar">
</form>

<hr />

<?php 
    if (!empty($_GET['busca'])) {
        $busca = htmlspecialchars($_GET['busca']);

        $query = "SELECT * FROM usuarios WHERE email LIKE '%{$busca}%' OR cpf LIKE '%{$busca}%'";
        $query = $pdo->prepare($query);
        $query->execute();

        if ($query->rowCount() > 0) {
            $dados = "";
            $query = $query->fetchAll();
            $dados .= '<table style="width:100%">'; 
            $dados .= '<thead>'; 
            $dados .= '<tr>'; 
            $dados .= '<th>Nome:<th>'; 
            $dados .= '<th>Email:<th>'; 
            $dados .= '<th>CPF:<th>'; 
            $dados .= '</tr>'; 
            $dados .= '</thead>'; 
            $dados .= '<tbody>'; 
            foreach ($query as $row) {
                $dados .= '<tr>';
                $dados .= '<td>' . $row['nome'] . '<td>';
                $dados .= '<td>' . $row['email'] . '<td>';
                $dados .= '<td>' . $row['cpf'] . '<td>';
                $dados .= '</tr>';
            }
            $dados .= '</tbody>'; 
            $dados .= '</table>'; 
            flush();
        } else {
            $dados = ""; 
            $dados .= '<table style="width:100%">'; 
            $dados .= '<thead>'; 
            $dados .= '<tr>'; 
            $dados .= '<th>Nome:<th>'; 
            $dados .= '<th>Email:<th>'; 
            $dados .= '<th>CPF:<th>'; 
            $dados .= '</tr>'; 
            $dados .= '</thead>'; 
            $dados .= '<tbody>'; 
            $dados .= '<tr>';
            $dados .= '<td>---<td>';
            $dados .= '<td>---<td>';
            $dados .= '<td>---<td>';
            $dados .= '</tr>';
            $dados .= '<tr>';
            $dados .= '<td>Nada encontrado!<td>';
            $dados .= '</tr>';
            $dados .= '</tbody>'; 
            $dados .= '</table>'; 
            flush();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Busca dinâmica multi-dados</title>
</head>
<body>
    <?php 
    if (!empty($dados)) {
        echo $dados;
    }
    ?>
</body>
</html>