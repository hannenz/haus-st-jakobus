<?php
namespace Jakobus;

use Contentomat\PsrAutoloader;
use Contentomat\Controller;
use Contentomat\CmtPage;

class BreadcrumbsController extends Controller {

	/**
	 * @var Object
	 */
	protected $CmtPage;



	public function init () {
		parent::init ();
		$this->CmtPage = new CmtPage ();
		$this->templatesPath .= '/navigation/';
	}

	public function actionDefault() {
		$level = $this->CmtPage->getLevel($this->pageId);

		switch ($level) {
			case 3:
				$parentId = $this->CmtPage->getParentID($this->pageId, $this->pageLang);
				$pageData = $this->CmtPage->getPageData($parentId);
				$children = $this->CmtPage->getChildren($parentId, $this->pageLang);
				$siblings = [];
				foreach ($children as $child) {

					if ($child['cmt_showinnav']) {
						$child['linkUrl'] = sprintf('%s%s', $this->CmtPage->makePageFilePath($child['id'], $this->pageLang), $this->CmtPage->makePageFileName($child['id'], $this->pageLang));
						$siblings[] = $child;
					}
				}
				$this->parser->setParserVar('siblings', $siblings);
				break;

			default:
				$pageData = $this->CmtPage->getPageData($this->pageId);
				break;
		}

		$this->parser->setParserVar('current', $pageData['cmt_title']);
		$this->content = $this->parser->parseTemplate($this->templatesPath . 'breadcrumbs.tpl');
	}

	public function __actionDefault () {

		$breadcrumbs = array_reverse ($this->CmtPage->getAncestors (PAGEID));

		// If POSTTITLE is set, it must be a news article, so we insert it's
		// title as PAGETITLE
		if (defined('POSTTITLE')) {
			$breadcrumbs[count($breadcrumbs) - 1]['cmt_title'] = POSTTITLE;
		}

		array_shift ($breadcrumbs);

		foreach ($breadcrumbs as &$crumb) {
			$crumb['url'] = sprintf("/%s/%u/%s", PAGELANG, $crumb['id'], $this->CmtPage->makePageFileName ($crumb['id']));
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
