<?php

require_once 'Connection.php';

function getMovimentacoesMes($mes) {
  $connection = getConnection();

  $sql = 'select t1.id, t1.data, t1.valor, t1.descricao, t2.tipo, t3.categoria from movimentacoes t1 left join tipos_movimentacao t2 on t1.tipo = t2.id
          left join categorias t3 on t1.categoria = t3.id where month(data) = ' . $mes;

  mysqli_set_charset($connection, 'utf8');

	$result = mysqli_query($connection, $sql);

	$movimentacoes = array();

	while ($item = mysqli_fetch_assoc($result)) {
		array_push($movimentacoes, $item);
	}

	return $movimentacoes;
}

function getMovimentacaoID($id) {
  $connection = getConnection();

  $sql = 'select t1.id, t1.data, t1.valor, t1.descricao, t2.tipo, t3.categoria from movimentacoes t1 left join tipos_movimentacao t2 on t1.tipo = t2.id
          left join categorias t3 on t1.categoria = t3.id where t1.id = ' . $id;

  mysqli_set_charset($connection, 'utf8');

	$result = mysqli_query($connection, $sql);

	$movimentacao = array();

	while ($item = mysqli_fetch_assoc($result)) {
		array_push($movimentacao, $item);
	}

	return $movimentacao;
}

function insertMovimentacao($movimentacao) {
  $movimentacao = json_decode($movimentacao, true);

	$tipo = $movimentacao['tipo'];
	$categoria = $movimentacao['categoria'];
  $data = $movimentacao['data'];
	$valor = $movimentacao['valor'];
	$descricao = $movimentacao['descricao'];

	$connection = getConnection();

	$sql = "insert into movimentacoes (tipo, categoria, data, valor, descricao) values ('$tipo', '$categoria', '$data', '$valor', '$descricao')";

	mysqli_set_charset($connection, 'utf8');

	if (mysqli_query($connection, $sql)) {
		return true;
	} else {
		return false;
	}
}

function deleteMovimentacao($id) {
  $connection = getConnection();

  $sql = 'delete from movimentacoes where id = ' . $id;

  mysqli_set_charset($connection, 'utf8');

	if (mysqli_query($connection, $sql)) {
		return true;
	} else {
		return false;
	}
}

function deleteTodasMovimentacoes() {
  $connection = getConnection();

  $sql = 'truncate movimentacoes';

  mysqli_set_charset($connection, 'utf8');

	if (mysqli_query($connection, $sql)) {
		return true;
	} else {
		return false;
	}
}

function editMovimentacao($id, $movimentacao) {
  $connection = getConnection();

  $movimentacao = json_decode($movimentacao, true);

  $tipo = $movimentacao['tipo'];
	$categoria = $movimentacao['categoria'];
  $data = $movimentacao['data'];
	$valor = $movimentacao['valor'];
	$descricao = $movimentacao['descricao'];

  $sql = "update movimentacoes set tipo = '$tipo', categoria = '$categoria', data = '$data', valor = '$valor', descricao = '$descricao' where id = " . $id;

  mysqli_set_charset($connection, 'utf8');

  if (mysqli_query($connection, $sql)) {
		return true;
	} else {
		return false;
	}
}


?>
