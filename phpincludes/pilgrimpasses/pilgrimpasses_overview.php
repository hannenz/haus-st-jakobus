<?php
namespace Jakobus;

use Contentomat\PsrAutoloader;
use Contentomat\ApplicationController;
use Jakobus\Pilgrimpass;
use \Exception;

$autoLoader = new PsrAutoloader();
$autoLoader->addNamespace('Jakobus', PATHTOWEBROOT . 'phpincludes/classes');
$autoLoader->addNamespace('Contentomat', INCLUDEPATHTOADMIN . 'classes');


class PilgrimpassOverviewController extends ApplicationController {

	/**
	 * @var \Jakobus\Pilgrimpass
	 */
	protected $Pilgrimpass;



	/**
	 * Init
	 *
	 * @return void
	 */
	public function init() {
		$this->Pilgrimpass = new Pilgrimpass();
		$this->parser->setUserTemplateBasePath(PATHTOWEBROOT . "templates/pilgrimpasses/");
	}

	

	/**
	 * Init actions / routing
	 *
	 * @return void
	 */
	public function initActions($action = '') {
		if (isset($_REQUEST['cmtAction'])) {
			$this->action = $_REQUEST['cmtAction'];
			return;
		}

		parent::initActions($action);
	}



	/**
	 * Default action: Render an "export" button
	 *
	 * @return void
	 */
	public function actionDefault() {
		$this->parser->setMultipleParserVars([
			'defaultBegin' => sprintf('%04u-01-01', date('Y')),
			'defaultEnd' => sprintf('%04u-12-31', date('Y')),
		]);

		$this->content = $this->parser->parseTemplate("pilgrimpasses_overview.tpl");
	}



	/**
	 * Export action: Export pilgrimpasses of a given range as CSV file
	 *
	 * @return void
	 */
	public function actionExportCsv() {
		$begin = trim($_REQUEST['export_range_begin']);
		$end = trim($_REQUEST['export_range_end']);

		try {
			if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $begin)) {
				throw new Exception(sprintf("Illegal format for begin date: %s", $begin));
			}

			if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $end)) {
				throw new Exception(sprintf("Illegal format for end date: %s", $end));
			}

			$this->Pilgrimpass->exportCsv($begin, $end);
		}
		catch (Exception $e) {
			$this->parser->setParserVar('cmtErrorMessage', $e->getMessage());
		}

		$this->parser->setMultipleParserVars([
			'defaultBegin' => $begin,
			'defaultEnd' => $end
		]);

		$this->changeAction('default');
	}
}

$ctl = new PilgrimpassOverviewController();
$content = $ctl->work();
?>
