<?php
/**
 * Created by PhpStorm.
 * User: paulo
 * Date: 30/11/2017
 * Time: 16:50
 */

namespace App\Controller;

use Aura\Intl\Exception;
use Cake\Event\Event;

class ArquivosController extends AppController
{
	public function visualizar($controlador = null, $campo = null, $arquivo = null)
	{
		$arquivo = \Arquivos::validar($controlador, $campo, $arquivo, true);

		$this->response->file($arquivo["arquivo"]);
		$this->response->header("Content-Disposition", "inline");
		return $this->response;
	}

	public function download($controlador = null, $campo = null, $arquivo = null, $nomeArquivo = null, $incluirExtensao = 1)
	{
		$arquivo = \Arquivos::validar($controlador, $campo, $arquivo);

		$nomeArquivo =
			base64_decode($nomeArquivo)
			.(
				$incluirExtensao == 1
					? ".".$arquivo["extensão"]
					: ""
			);

		$tamanho = filesize($arquivo["arquivo"]);

		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private", false);
		header("Content-Type:" . $arquivo["mime"]);
		header("Content-Disposition: attachment; filename=" . $nomeArquivo);
		header("Content-Transfer-Encoding: binary");
		header("Content-Length: " . $tamanho);

		$this->response->file($arquivo["arquivo"]);
		$this->response->header("Content-Disposition", "inline");
		echo $this->response;

		flush();
		ob_clean();

		die();
	}

	public function beforeFilter(Event $event)
	{
		parent::beforeFilter($event);

		if (headers_sent())
			throw new Exception("Cabeçalho enviado.");

		if (ini_get("zlib.output_compression"))
			ini_set("zlib.output_compression", "Off");

		$this->Auth->allow();
	}
}
