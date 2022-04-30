<?php
namespace Jakobus;

use Contentomat\PsrAutoloader;
use Contentomat\Controller;
use Contentomat\CmtPage;

class TopbarnavController extends Controller {

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

					if ($child['cmt_showinnav'] == 1) {
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

		if ($pageData['cmt_showinnav']) {
			$this->parser->setParserVar('current', $pageData['cmt_title']);
		}
		$this->content = $this->parser->parseTemplate($this->templatesPath . 'topbarnav.tpl');
	}

}

$autoload = new PsrAutoloader ();
$autoload->addNamespace ('Contentomat', PATHTOADMIN . 'classes');
$ctl = new TopbarnavController ();
$content = $ctl->work ();
?>
