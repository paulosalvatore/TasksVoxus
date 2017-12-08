<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.8
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

/*
 * Configure paths required to find CakePHP + general filepath constants
 */
require __DIR__ . "/paths.php";

/*
 * Bootstrap CakePHP.
 *
 * Does the various bits of setup that CakePHP needs to do.
 * This includes:
 *
 * - Registering the CakePHP autoloader.
 * - Setting the default application paths.
 */
require CORE_PATH . "config" . DS . "bootstrap.php";

use Cake\Cache\Cache;
use Cake\Console\ConsoleErrorHandler;
use Cake\Core\App;
use Cake\Core\Configure;
use Cake\Core\Configure\Engine\PhpConfig;
use Cake\Core\Plugin;
use Cake\Database\Type;
use Cake\Datasource\ConnectionManager;
use Cake\Error\ErrorHandler;
use Cake\Filesystem\File;
use Cake\Http\ServerRequest;
use Cake\I18n\FrozenTime;
use Cake\Log\Log;
use Cake\Mailer\Email;
use Cake\Utility\Inflector;
use Cake\Utility\Security;

/**
 * Uncomment block of code below if you want to use `.env` file during development.
 * You should copy `config/.env.default to `config/.env` and set/modify the
 * variables as required.
 */
// if (!env("APP_NAME") && file_exists(CONFIG . ".env")) {
//     $dotenv = new \josegonzalez\Dotenv\Loader([CONFIG . ".env"]);
//     $dotenv->parse()
//         ->putenv()
//         ->toEnv()
//         ->toServer();
// }

/*
 * Read configuration file and inject configuration into various
 * CakePHP classes.
 *
 * By default there is only one configuration file. It is often a good
 * idea to create multiple configuration files, and separate the configuration
 * that changes from configuration that does not. This makes deployment simpler.
 */
try {
    Configure::config("default", new PhpConfig());
    Configure::load("app", "default", false);
} catch (\Exception $e) {
    exit($e->getMessage() . "\n");
}

/*
 * Load an environment local configuration file.
 * You can use a file like app_local.php to provide local overrides to your
 * shared configuration.
 */
//Configure::load("app_local", "default");

/*
 * When debug = true the metadata cache should only last
 * for a short time.
 */
if (Configure::read("debug")) {
    Configure::write("Cache._cake_model_.duration", "+2 minutes");
    Configure::write("Cache._cake_core_.duration", "+2 minutes");
}

/*
 * Set server timezone to UTC. You can change it to another timezone of your
 * choice but using UTC makes time calculations / conversions easier.
 * Check http://php.net/manual/en/timezones.php for list of valid timezone strings.
 */
date_default_timezone_set("America/Sao_Paulo");

/*
 * Configure the mbstring extension to use the correct encoding.
 */
mb_internal_encoding(Configure::read("App.encoding"));

/*
 * Set the default locale. This controls how dates, number and currency is
 * formatted and sets the default language to use for translations.
 */
ini_set("intl.default_locale", Configure::read("App.defaultLocale"));

/*
 * Register application error and exception handlers.
 */
$isCli = PHP_SAPI === "cli";
if ($isCli) {
    (new ConsoleErrorHandler(Configure::read("Error")))->register();
} else {
    (new ErrorHandler(Configure::read("Error")))->register();
}

/*
 * Include the CLI bootstrap overrides.
 */
if ($isCli) {
    require __DIR__ . "/bootstrap_cli.php";
}

/*
 * Set the full base URL.
 * This URL is used as the base of all absolute links.
 *
 * If you define fullBaseUrl in your config file you can remove this.
 */
if (!Configure::read("App.fullBaseUrl")) {
    $s = null;
    if (env("HTTPS")) {
        $s = "s";
    }

    $httpHost = env("HTTP_HOST");
    if (isset($httpHost)) {
        Configure::write("App.fullBaseUrl", "http" . $s . "://" . $httpHost);
    }
    unset($httpHost, $s);
}

Cache::setConfig(Configure::consume("Cache"));
ConnectionManager::setConfig(Configure::consume("Datasources"));
Email::setConfigTransport(Configure::consume("EmailTransport"));
Email::setConfig(Configure::consume("Email"));
Log::setConfig(Configure::consume("Log"));
Security::setSalt(Configure::consume("Security.salt"));

/*
 * The default crypto extension in 3.0 is OpenSSL.
 * If you are migrating from 2.x uncomment this code to
 * use a more compatible Mcrypt based implementation
 */
//Security::engine(new \Cake\Utility\Crypto\Mcrypt());

/*
 * Setup detectors for mobile and tablet.
 */
ServerRequest::addDetector("mobile", function ($request) {
    $detector = new \Detection\MobileDetect();

    return $detector->isMobile();
});
ServerRequest::addDetector("tablet", function ($request) {
    $detector = new \Detection\MobileDetect();

    return $detector->isTablet();
});

/*
 * Enable immutable time objects in the ORM.
 *
 * You can enable default locale format parsing by adding calls
 * to `useLocaleParser()`. This enables the automatic conversion of
 * locale specific date formats. For details see
 * @link https://book.cakephp.org/3.0/en/core-libraries/internationalization-and-localization.html#parsing-localized-datetime-data
 */
Type::build("time")
    ->useImmutable();
Type::build("date")
    ->useImmutable();
Type::build("datetime")
    ->useImmutable();
Type::build("timestamp")
    ->useImmutable();

/*
 * Custom Inflector rules, can be set to correctly pluralize or singularize
 * table, model, controller names or whatever other string is passed to the
 * inflection functions.
 */
//Inflector::rules("plural", ["/^(inflect)or$/i" => "\1ables"]);
//Inflector::rules("irregular", ["red" => "redlings"]);
//Inflector::rules("uninflected", ["dontinflectme"]);
//Inflector::rules("transliteration", ["/å/" => "aa"]);

/*
 * Plugins need to be loaded manually, you can either load them one by one or all of them in a single call
 * Uncomment one of the lines below, as you need. make sure you read the documentation on Plugin to use more
 * advanced ways of loading plugins
 *
 * Plugin::loadAll(); // Loads all plugins at once
 * Plugin::load("Migrations"); //Loads a single plugin named Migrations
 *
 */

/*
 * Only try to load DebugKit in development mode
 * Debug Kit should not be installed on a production system
 */
if (Configure::read("debug")) {
    Plugin::load("DebugKit", ["bootstrap" => true]);
}

class UploadException extends Exception
{
	public function __construct($code) {
		$mensagem = $this->codeToMessage($code);
		parent::__construct($mensagem, $code);
	}

	private function codeToMessage($code)
	{
		switch ($code)
		{
			case UPLOAD_ERR_INI_SIZE:
				$mensagem = __("The uploaded file exceeds the upload_max_filesize directive in php.ini");
				break;
			case UPLOAD_ERR_FORM_SIZE:
				$mensagem = __("The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form");
				break;
			case UPLOAD_ERR_PARTIAL:
				$mensagem = __("The uploaded file was only partially uploaded");
				break;
			case UPLOAD_ERR_NO_FILE:
				$mensagem = __("No file was uploaded");
				break;
			case UPLOAD_ERR_NO_TMP_DIR:
				$mensagem = __("Missing a temporary folder");
				break;
			case UPLOAD_ERR_CANT_WRITE:
				$mensagem = __("Failed to write file to disk");
				break;
			case UPLOAD_ERR_EXTENSION:
				$mensagem = __("File upload stopped by extension");
				break;

			default:
				$mensagem = __("Unknown upload error");
				break;
		}

		return $mensagem;
	}
}

class Arquivos
{
	public static $imagens = [
		"jpg",
		"jpeg",
		"png",
		"tif",
		"tiff"
	];

	public static $formatos = [
		"doc" => [
			"visualizar" => false,
			"mime" => "application/msword"
		],
		"docx" => [
			"visualizar" => false,
			"mime" => "application/msword"
		],
		"rtf" => [
			"visualizar" => false,
			"mime" => "application/rtf"
		],
		"odt" => [
			"visualizar" => false,
			"mime" => "application/odt"
		],
		"pdf" => [
			"visualizar" => true,
			"mime" => "application/pdf"
		],
		"jpg" => [
			"visualizar" => true,
			"mime" => "image/jpg"
		],
		"jpeg" => [
			"visualizar" => true,
			"mime" => "image/jpeg"
		],
		"png" => [
			"visualizar" => true,
			"mime" => "image/png"
		],
		"tif" => [
			"visualizar" => false,
			"mime" => "application/tiff"
		],
		"tiff" => [
			"visualizar" => false,
			"mime" => "application/tiff"
		],
		"rar" => [
			"visualizar" => false,
			"mime" => "application/rar"
		],
		"zip" => [
			"visualizar" => false,
			"mime" => "application/zip"
		]
	];

	public static $definicoes = [
		"Tasks" => [
			"tasks_arquivos" => [
				"formatos" => [
					"doc",
					"docx",
					"rtf",
					"odt",
					"pdf",
					"jpg",
					"jpeg",
					"png",
					"tif",
					"tiff",
					"rar",
					"zip"
				],
				"img" => false
			]
		]
	];

	public static function download($controlador, $diretorio, $arquivo)
	{
		return \Arquivos::validar($controlador, $diretorio, $arquivo, false, false);
	}

	public static function visualizar($controlador, $diretorio, $arquivo)
	{
		return \Arquivos::validar($controlador, $diretorio, $arquivo, true, false);
	}

	public static function pegarFormatosAceitos($controlador, $campo, $agrupar = false, $transformarExtensao = false)
	{
		$formatosAceitos = Arquivos::$definicoes[$controlador][$campo]["formatos"];

		$formatosAceitos =
			$agrupar
				? implode("; ", $formatosAceitos)
				: $formatosAceitos;

		$formatosAceitos =
			$transformarExtensao
				? "." . str_replace("; ", ", .", $formatosAceitos)
				: $formatosAceitos;

		return $formatosAceitos;
	}

	public static function pegarExtensao($arquivo)
	{
		if (is_array($arquivo))
			$arquivo = $arquivo["name"];

		return
			strtolower(
				pathinfo(
					$arquivo,
					PATHINFO_EXTENSION
				)
			);
	}

	public static function validar($controlador, $campo, $arquivo, $visualizar = false, $throw = true)
	{
		$formatosAceitos = Arquivos::pegarFormatosAceitos($controlador, $campo);

		$extensao = Arquivos::pegarExtensao($arquivo);

		if (in_array($extensao, $formatosAceitos))
		{
			$formato = Arquivos::$formatos[$extensao];

			if ($visualizar && !$formato["visualizar"])
			{
				if ($throw)
					throw new Exception(__("This file cannot be visualized."));

				return false;
			}

			$arquivo =
				strtolower($controlador)
				."/"
				.$arquivo;

			if (isset(Arquivos::$definicoes[$controlador][$campo]["img"]) &&
				Arquivos::$definicoes[$controlador][$campo]["img"])
				$arquivo = "img/" . $arquivo;

			if (is_file($arquivo))
				return [
					"arquivo" => $arquivo,
					"extensão" => $extensao,
					"mime" => $formato["mime"]
				];
			elseif ($throw)
				throw new Exception(__("File missing."));
		}
		elseif ($throw)
			throw new Exception(__("File type invalid."));

		return false;
	}

	public static function validarExtensao($controlador, $campo, $arquivo)
	{
		$formatosAceitos = Arquivos::pegarFormatosAceitos($controlador, $campo);

		$extensao = Arquivos::pegarExtensao($arquivo);

		if (in_array($extensao, $formatosAceitos))
			return true;

		return false;
	}

	public static function upload($controlador, $campo, $arquivo)
	{
		$diretorio =
			WWW_ROOT
			."/";

		if (isset(Arquivos::$definicoes[$controlador][$campo]["img"]) &&
			Arquivos::$definicoes[$controlador][$campo]["img"])
			$diretorio .= "img/";

		$diretorio =
			$diretorio
			.strtolower($controlador)
			."/";

		if (!is_dir($diretorio))
			mkdir($diretorio);

		$retorno = [
			"erro" => true,
			"mensagem" => __("Some error occurred when uploading this file."),
			"nomeOriginal" => $arquivo["name"]
		];

		if ($arquivo["error"] != UPLOAD_ERR_OK)
			$retorno["mensagem"] = new UploadException($arquivo["error"]);
		elseif (!\Arquivos::validarExtensao($controlador, $campo, $arquivo))
			$retorno["mensagem"] = __("Invalid file type. Upload a valid file within the file types") . ": '" . \Arquivos::pegarFormatosAceitos($controlador, $campo, true) . "'.";
		else
		{
			$arquivo["extensão"] = Arquivos::pegarExtensao($arquivo);

			$nomeArquivo =
				md5(
					$controlador
					.$campo
					.$arquivo["name"]
					.$arquivo["tmp_name"]
					.FrozenTime::now()
				)
				."."
				.$arquivo["extensão"];

			$arquivo = new File($arquivo["tmp_name"]);
			$arquivo->copy($diretorio . $nomeArquivo);
			$arquivo->close();

			$retorno["erro"] = false;
			$retorno["mensagem"] = __("File uploaded successfully.");
			$retorno["arquivo"] = $arquivo;
			$retorno["arquivoNome"] = $nomeArquivo;
		}

		return $retorno;
	}

	public static function deletar($controlador, $campo, $arquivo)
	{
		$diretorio =
			WWW_ROOT
			."/";

		if (isset(Arquivos::$definicoes[$controlador][$campo]["img"]) &&
			Arquivos::$definicoes[$controlador][$campo]["img"])
			$diretorio .= "img/";

		$arquivo =
			$diretorio
			.strtolower($controlador)
			."/"
			.$arquivo;

		if (is_file($arquivo))
			unlink($arquivo);
	}
}

class Utils
{
	public static function human_filesize($bytes, $decimals = 2)
	{
		$sz = "BKMGTP";
		$factor = floor((strlen($bytes) - 1) / 3);
		return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
	}

	/*
	 * Esse método limpa todos os caracteres especiais e espaços de uma string
	 * preservando traços e underlines.
	 */
	public static function limparString($string)
	{
		$string = str_replace(" ", "-", $string);

		return preg_replace("/[^A-Za-z0-9\-\_]/", "", $string);
	}
}
