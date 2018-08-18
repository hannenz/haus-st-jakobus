<?php
namespace Jakobus;

use Contentomat\PsrAutoloader;
use Contentomat\Controller;
use Contentomat\CmtPage;

class BreadcrumbsController extends Controller {

	/**
	 * @var Object
	 */
	protected $Page;



	public function init () {
		parent::init ();
		$this->Page = new CmtPage ();
		$this->templatesPath .= '/navigation/';
	}


	public function actionDefault () {

		$breadcrumbs = array_reverse ($this->Page->getAncestors (PAGEID));
		foreach ($breadcrumbs as &$crumb) {
			$crumb['url'] = sprintf("/%s/%u/%s", PAGELANG, $crumb['id'], $this->Page->makePageFileName ($crumb['id']));
		}
		$this->parser->setParserVar ('breadcrumbs', $breadcrumbs);
		$this->content = $this->parser->parseTemplate ($this->templatesPath . 'breadcrumbs.tpl');
	}

}

$autoload = new PsrAutoloader ();
$autoload->addNamespace ('Contentomat', PATHTOADMIN . 'classes');
$ctl = new BreadcrumbsController ();
$content = $ctl->work ();
?>
