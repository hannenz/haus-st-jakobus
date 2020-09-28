<?php
/**
 * content-o-mat: Website Seitenausgabe
 * 
 * Datei gibt angeforderte Seite einer Website zurück.
 * 
 * @author J.Hahn <info@content-o-mat.de>, J.Braun <info@content-o-mat.de>
 * @version 2020-07-21
 */
use \Contentomat\PsrAutoloader;
use \Contentomat\Contentomat;
use \Contentomat\Parser;
use \Contentomat\AppParser;
use \Contentomat\CmtPage;
use \Contentomat\SessionHandler;
use \Contentomat\DBCex;
use \Contentomat\CLIUtils;
use \Contentomat\CLIColors;
// use \Exception;


/**
 * @class Bootstrap
 * @author Johannes Braun <j.braun@agentur-halma.de>
 * @package cmt
 * @version 2020-07-21
 *
 * Refactored to Bootstrap class on 2020-07-21,
 * Execution either by HTTP / Web Server or CLI (command line interface)
 */
class Bootstrap {


	/**
	 * @var \Contentomat\PsrAutoloader
	 */
	protected $AutoLoader;

	/**
	 * @var \Contentomat\Contentomat
	 */
	protected $Contentomat;

	/**
	 * @var \Contentomat\CmtPage
	 */
	protected $CmtPage;

	/**
	 * @var \Contentomat\Session
	 */
	protected $Session;

	/**
	 * @var \Contentomat\DBcex
	 */
	protected $db;


	// For CLI only

	/**
	 * @var Array 		The arguments passed from command line
	 */
	protected $argv;

	/**
	 * @var string 		The name of the controller to run
	 */
	protected $controllerName;

	/**
	 * @var string 		The name of the action to execute
	 */
	protected $actionName = 'default';

	/**
	 * @var Contentomat\CLIUtils
	 */
	protected $CLIUtils;


	/**
	 * Constructor
	 */
	public function __construct() {

		/*
		 * Common intialisation
		 */
		try {
			require ('cmt_constants.inc');
			require (PATHTOADMIN . 'classes/class_psrautoloader.inc');
			if (file_exists(PATHTOADMIN . 'vendor/autoload.php')) {
				require(PATHTOADMIN . 'vendor/autoload.php');
			}
			require (PATHTOADMIN . 'cmt_functions_website.inc');

			$this->AutoLoader = new PsrAutoloader();
			$this->AutoLoader->addNamespace('Contentomat', PATHTOWEBROOT . 'phpincludes/classes/');
			$this->AutoLoader->addNamespace('Contentomat', PATHTOADMIN . 'classes/');

			// Session überprüfen
			$this->Contentomat = Contentomat::getContentomat();
			$this->CmtPage = new cmtPage();
			$this->Session = SessionHandler::getSession();
			$this->db = new DBCex();

			setlocale(LC_ALL, 'de_DE.utf8');

			if (php_sapi_name() == "cli") {
				$this->bootstrapCli();
			}
			else {
				$this->bootstrapHttp();
			}
		}
		catch (Exception $e) {
			die ("Content-o-mat Bootstrap Error: " . $e->getMessage());
		}
	}


	/*
	 * Bootstrap the application if called through HTTP Request ("Web")
	 */
	public function bootstrapHttp() {
		/* --------------------------------------------------
			Sichtbarkeit- und Domainüberprüfung
			-------------------------------------------------- */
		// Seitendaten und Seiten-Quelltext auslesen
		// Zuerst getPageToDisplay() da dort auch $page->initPage() aufgerufen wird
		$pageSource = $this->CmtPage->getPageToDisplay();
		$pageData = $this->CmtPage->getPageData();	

		// werden Cookies verwendet?
		// checken, ob SID in der URL mitgegeben werden muss
		$cc = $this->Session->checkSidCookie();
		if (!$cc && CMT_FORCECOOKIES != '1') {
			define ('ADDSID', 'sid='.SID);
			$addSid = '&amp;sid='.SID;
			$addSidJs = '&sid='.SID;
		} else {
			define ('ADDSID', '');
		}

		// vorherige Seite holen
		$refering_page = $this->Session->GetSessionVar('cmt_refering_page');
		$current_page = $this->Session->GetSessionVar('cmt_current_page');

		/*
		 * weitere Konstanten definieren
		 */

		/* 
		 * SELFURL: verwenden, wenn Mod Rewrite nicht aktiviert!
		 * SELFURL entspricht SELF, ggf mit Session-ID
		 */
		$pid = $this->CmtPage->getPageID();
		$lang = $this->CmtPage->getPageLang();

		$selfURL = SELF;
		if (CMT_FORCECOOKIES == '0') {
			$selfURL .= '?sid='.SID;
		}
		define('SELFURL', $selfURL);

		/* neu: PAGEURL und JSPAGEURL */
		// 2015-12-10: Was this ever used???
		if (CMT_USECOOKIES == '1') {
			$pageURL = $this->CmtPage->makePageFilePath().$this->CmtPage->makePageFileName();

			define('PAGEURL', $pageURL);
			// OUTDATED
			define('JSPAGEURL', SELF.'?pid='.$pid.'&lang='.$lang);
		} else {
			define('PAGEURL', SELF.'?pid='.$pid.'&amp;lang='.$lang.$addSid);
			// OUTDATED
			define('JSPAGEURL', SELF.'?pid='.$pid.'&lang='.$lang.$addSidJs);
		}

		define ('PAGEID', $pid);
		define ('PAGELANG', $lang);
		define ('PAGETITLE', $pageData['cmt_title']);
		// ??? define ('PAGEFILENAME', $pageFilename);
		define ('PARENTID', $pageData['cmt_parentid']);
		define ('CMT_MODE', 'view');
		define ('REQUEST_URI', $_GET['requestURI']);

		// TODO 2.0: Auf Globale verzichten, stattdessen $cmt->settings
		$pagesTable = $this->CmtPage->getPagesTable();
		$contentsTable = $this->CmtPage->getContentsTable();
		$linksTable = $this->CmtPage->getLinksTable();

		define ('CMT_PAGES', $pagesTable);
		define ('CMT_CONTENT', $contentsTable);
		define ('CMT_LINKS', $linksTable);

		// init parser class here, because some constants are needed for i18n!
		$this->parser = new AppParser();

		// Seitendaten an Parser übergeben
		$this->parser->setPageVars($pageData);
		$this->parser->setPageId($pageData['id']);
		$this->parser->setParentId($pageData['cmt_parentid']);
		$this->parser->setPageLanguage($lang);

		$this->parser->setPagesTable($pagesTable);
		$this->parser->setContentsTable($contentsTable);
		$this->parser->setLinksTable($linksTable);
		$this->parser->setPathToWebroot(PATHTOWEBROOT);

		// aktuelle Seiten-ID noch als Sessionvariable speichern
		if ($current_page != $pid) {
			$this->Session->setSessionVar('cmt_refering_page', $current_page);
			$this->Session->setSessionVar('cmt_current_page', $pid);
			$refering_page = $current_page;
		} else {
			$this->Session->setSessionVar('cmt_current_page', $pid);
		}

		$this->Session->saveSessionVars();

		$parser->pagevars['refering_page'] = $refering_page; 
		define ('REFERINGPAGE', $refering_page);

		ob_start_gzipped();
		echo $this->parser->parse(stripslashes($pageSource));
		ob_end_flush();

		// If this is of any interest?
		$this->executionTime = microtime(true) - (int)$_SERVER['REQUEST_TIME_FLOAT'];
	}


	/*
	 * Bootstrap the application if called by CLI (command line interface)
	 */
	public function bootstrapCli() {
		$this->argv = $GLOBALS['argv'];
		$this->CLIUtils = new CLIUtils();

		try {
			if (false) {
				$this->CLIUtils->out ('Initializing …', 'info');
				$this->CLIUtils->out ('ROOT:               ' . ROOT);
				$this->CLIUtils->out ('INCLUDEPATH:        ' . INCLUDEPATH);
				$this->CLIUtils->out ('INCLUDEPATHTOADMIN: ' . INCLUDEPATHTOADMIN);
				$this->CLIUtils->out ('PATHTOWEBROOT:      ' . PATHTOWEBROOT);
				$this->CLIUtils->out ('PATHTOADMIN:        ' . PATHTOADMIN);
				$this->CLIUtils->out ('DOWNLOADPATH:       ' . DOWNLOADPATH);
			}

			// Discard first arg
			array_shift($this->argv);

			if (count($this->argv) == 0) {
				throw new Exception ('No controller specified');
			}

			$this->controllerName = array_shift($this->argv);

			if (count($this->argv) > 0) {
				$this->actionName = array_shift($this->argv);
			}

			if (false) {
				$this->CLIUtils->out('Controller: ' . $this->controllerName);
				$this->CLIUtils->out('Action:     ' . $this->actionName);
				$this->CLIUtils->out('Remaining arguments');
				print_r($this->argv);
			}

			// Try to load controller
			$className = $this->controllerName . 'Controller';
			$actionName = 'action' . ucwords($this->actionName);

			$filename = strtolower ($this->controllerName) . '_controller.php';
			$filepath = INCLUDEPATH . 'phpincludes' . DIRECTORY_SEPARATOR . $filename;

			if (!file_exists($filepath)) {
				$filepath = INCLUDEPATH . 'phpincludes' . DIRECTORY_SEPARATOR . strtolower($this->controllerName) . DIRECTORY_SEPARATOR . $filename;
				if (!file_exists($filepath)) {
					throw new Exception ('Could not load controller from file: ' . $filepath);
				}
			}

			if (!preg_match ('/namespace (.*)\;/', file_get_contents($filepath), $matches)) {
				throw new Exception ('Could not determine namespace from file: ' . $filepath);
			}

			// Workaround, for we cannot call the action directly: Pass action
			// and args as Contentomat vars and eact to these in initActions method
			$this->Contentomat->setVar('cliAction', $this->actionName);
			$this->Contentomat->setVar('cliArgs', $this->argv);

			if (!require_once($filepath)) {
				throw new Exception ('Could not load controller from file: ' . $filepath);
			}
		}
		catch (Exception $e) {
			$this->CLIUtils->out('CLI init: ERROR: ' . $e->getMessage(), 'error');
		}
	}
}

new Bootstrap();
?>
