<?php
header('Access-Control-Allow-Origin: *');
// Esse código serve para conectar o código ao banco de dados usando as informações do banco
$connect = new PDO("mysql:host=localhost;dbname=id20487027_aula2", "id20487027_victor_2", ")c3+oxCg<4l0rqU%");
//Pega uma cadeia codificade em Json e converte em PHP
$received_data = json_decode(file_get_contents("php://input"));

$data = array();

if($received_data->query != '')
{
	// Essa função seleciona o campo preenchido pelo usuário e busca no Banco de dados
	$query = "
	SELECT * FROM fatec_professores
	WHERE nome LIKE '%".$received_data->query."%' 
	OR endereco LIKE '%".$received_data->query."%' 
	OR curso LIKE '%".$received_data->query."%' 
	OR salario LIKE '%".$received_data->query."%' 
	ORDER BY salario DESC
	";
}
else
{
	// Caso a busca esteja vazia ele busca todas as informações no Banco de dados
	$query = "
	SELECT * FROM fatec_professores
	ORDER BY salario DESC
	";
}

// Conecta a quey no banco de dados para buscar as informações
$statement = $connect->prepare($query);

$statement->execute();

// Busca um conjunto de resultados associados ao PDO. O parâmentro determina como os valores retornaram. 
while($row = $statement->fetch(PDO::FETCH_ASSOC))
{
	$data[] = $row;
}

echo json_encode($data);

?>