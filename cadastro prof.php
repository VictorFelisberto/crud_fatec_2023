<?php
header('Access-Control-Allow-Origin: *');

$connect = new PDO("mysql:host=localhost;dbname=id20487027_aula2", "id20487027_victor_2", ")c3+oxCg<4l0rqU%");
$received_data = json_decode(file_get_contents("php://input"));
$data = array();
// Seleciona todos os cadastros já existentes 
if ($received_data->action == 'fetchall') {
    $query = "
 SELECT * FROM fatec_professores
 ORDER BY id DESC
 ";
    // Fazendo conexão com o banco de daos
    $statement = $connect->prepare($query);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
    echo json_encode($data);
}
// Se o botão INSERT for precionado, o primero dado será enviado para a coluna fist name e a segunda entrara na coluna last name
// Usando os nomes first name e last names como variáveis para salvar as informações inseridas pelo usuário 
if ($received_data->action == 'insert') {
    $data = array(
        ':nome' => $received_data->nome,
        ':endereco' => $received_data->endereco,
        ':curso' => $received_data->curso,
        ':salario' => $received_data->salario
    );

    // Assim que identificados os dados essas informações vão ser inseridas no banco 
    $query = "
 INSERT INTO fatec_professores
 (nome, endereco, curso, salario) 
 VALUES (:nome, :endereco, :curso, :salario)
 ";

    $statement = $connect->prepare($query);

    $statement->execute($data);


    // Caso retorne a informação que cadastro foi feito aparece a mensagem Aluno Adicionado
    $output = array(
        'message' => 'Professor Adicionado'
    );

    echo json_encode($output);
}

if ($received_data->action == 'fetchSingle') {
    $query = "
 SELECT * FROM fatec_professores
 WHERE id = '" . $received_data->id . "'
 ";

    $statement = $connect->prepare($query);

    $statement->execute();

    $result = $statement->fetchAll();

    foreach ($result as $row) {
        $data['id'] = $row['id'];
        $data['nome'] = $row['nome'];
        $data['endereco'] = $row['endereco'];
        $data['curso'] = $row['curso'];
        $data['salario'] = $row['salario'];
    }

    echo json_encode($data);
}

// Faz um função para dar um update ao banco de dados
if ($received_data->action == 'update') {
    $data = array(
        ':nome' => $received_data->nome,
        ':endereco' => $received_data->endereco,
        ':curso' => $received_data->curso,
        ':salario' => $received_data->salario,
        ':id' => $received_data->hiddenId
    );

    $query = "
 UPDATE fatec_professores
 SET nome = :nome, 
 endereco = :endereco, 
 curso = :curso, 
 salario = :salario  
 WHERE id = :id
 ";

    $statement = $connect->prepare($query);

    $statement->execute($data);

    $output = array(
        'message' => 'Professor Atualizado'
    );

    echo json_encode($output);
}


// Faz um função para dar um delete ao banco de dados
if ($received_data->action == 'delete') {
    $query = "
 DELETE FROM fatec_professores 
 WHERE id = '" . $received_data->Id . "'
 ";

    $statement = $connect->prepare($query);

    $statement->execute();

    $output = array(
        'message' => 'Professor Deletado'
    );

    echo json_encode($output);
}

?>