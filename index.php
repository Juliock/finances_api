<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';
require_once 'Dao.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, GET, DELETE, PUT, OPTIONS");

$app = new \Slim\App;

/**
* Primeiro Exemplo
*/
$app->get('/', function (Request $request, Response $response) use ($app) {
	$response->getBody()->write("Teste de Serviço");
	return $response;
});

/**
* Retornando as movimentacoes pelo mes
*/
$app->get('/movimentacoes/mes/{mes}', function (Request $request, Response $response) use ($app) {

	$route = $request->getAttribute('route');

	$mes = $route->getArgument('mes');

	$movimentacoes = getMovimentacoesMes($mes);

	$return = $response->withHeader('Content-type','application/json')
	->write(json_encode($movimentacoes, JSON_UNESCAPED_UNICODE));

	return $return;
});

/**
*	Retorna movimentacao pelo ID
*/
$app->get('/movimentacoes/{id}', function (Request $request, Response $response) use ($app) {

	$route = $request->getAttribute('route');

	$id = $route->getArgument('id');

	$movimentacao = getMovimentacaoID($id);

	$return = $response->withHeader('Content-type','application/json')
	->write(json_encode($movimentacao, JSON_UNESCAPED_UNICODE));

	return $return;
});

/**
* Cadastra uma nova movimentacao
*/
$app->post('/movimentacoes/adicionar', function (Request $request, Response $response) use ($app) {

	$body = $request->getBody()->getContents();

	if (insertMovimentacao($body)) {
		$return = $response->withJson(['msg' => "Cadastro realizado com sucesso!"]);
		$return = $return->withHeader('Content-type', 'application/json');
	} else {
		$return = $response->withJson(['msg' => "Erro ao cadastrar movimentação."]);
		$return = $return->withHeader('Content-type', 'application/json');
	}

	return $return;
});

/**
* Deleta uma movimentacao pelo ID
*/
$app->delete('/movimentacoes/{id}', function (Request $request, Response $response) use ($app) {

	$route = $request->getAttribute('route');

	$id = $route->getArgument('id');

	if (deleteMovimentacao($id)) {
		$return = $response->withHeader('Content-type','application/json')
		->write(json_encode(['msg' => "Movimentação excluída com sucesso!"], JSON_UNESCAPED_UNICODE));
	} else {
		$return = $response->withHeader('Content-type','application/json')
		->write(json_encode(['msg' => "Erro ao excluir movimentação."], JSON_UNESCAPED_UNICODE));
	}

	return $return;
});

/**
* Deleta todas movimentacoes cadastradas
*/
$app->delete('/movimentacoes', function (Request $request, Response $response) use ($app) {

	// $route = $request->getAttribute('route');
	//
	// $id = $route->getArgument('id');

	if (deleteTodasMovimentacoes($id)) {
		$return = $response->withHeader('Content-type','application/json')
		->write(json_encode(['msg' => "Todas Movimentações excluídas!"], JSON_UNESCAPED_UNICODE));
	} else {
		$return = $response->withHeader('Content-type','application/json')
		->write(json_encode(['msg' => "Erro ao excluir movimentações."], JSON_UNESCAPED_UNICODE));
	}

	return $return;
});

/**
* Atualiza uma movimentacao
*/
$app->put('/movimentacoes/{id}', function (Request $request, Response $response) use ($app) {

	$route = $request->getAttribute('route');

	$id = $route->getArgument('id');

	$body = $request->getBody()->getContents();

	if (editMovimentacao($id, $body)) {
		$return = $response->withHeader('Content-type','application/json')
		->write(json_encode(['msg' => "Movimentação atualizada com sucesso!"], JSON_UNESCAPED_UNICODE));
	} else {
		$return = $response->withHeader('Content-type','application/json')
		->write(json_encode(['msg' => "Erro ao atualizar movimentação."], JSON_UNESCAPED_UNICODE));
	}

	return $return;
});

$app->run();

?>
