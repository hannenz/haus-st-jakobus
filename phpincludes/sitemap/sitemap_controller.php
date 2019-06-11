<?php
namespace DataAL;

use Contentomat\PsrAutoloader;
use Contentomat\Contentomat;
use Contentomat\Controller;
use Contentomat\CmtPage;
use Contentomat\DBCex;

class SitemapController extends Controller {


	/**
	 * @var \Contentomat\CmtPage
	 */
	public $CmtPage;

	/**
	 * @var \Contentomat\DBCex
	 */
	public $db;


	public function init() {
		$this->CmtPage = new CmtPage();
		$this->db = new DBCex();
		$this->templatesPath = PATHTOWEBROOT . "templates/sitemap/";
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 */
	public function actionDefault() {
		$this->isAjax = true;

		$query = sprintf("SELECT * FROM cmt_pages_de WHERE cmt_showinnav = 1");
		$this->db->query($query);
		$pages = $this->db->getAll();

		$this->urls = [];
		foreach ($pages as $pageData) {
			if ($this->CmtPage->checkVisibility($pageData['id']) && !$pageData['cmt_protected'] && $pageData['cmt_type'] == 'page') {
				$CmtPage = new CmtPage();
				array_push($this->urls, [
					'loc' => sprintf('https://%s/%s%s', $_SERVER['SERVER_NAME'], $this->CmtPage->makePageFilePath($pageData['id']), $this->CmtPage->makePageFileName($pageData['id'])),
					'lastmod' => $pageData['cmt_lastmodified'],
					'changefreq' => 'monthly',
					'priority' => $pageData['cmt_isroot'] ? 1 : 0.15 * (7 - $CmtPage->getLevel($pageData['id']))
				]);
			}
		}

		$this->parser->setParserVar('urls', $this->urls);
		$this->content = $this->parser->parseTemplate($this->templatesPath . "sitemap.xml.tpl");

		$this->CmtPage->sendHeader('Content-Type: text/xml');
		die($this->content);
	}
}

$autoload = new PsrAutoloader();
$autoload->addNamespace('Contentomat', INCLUDEPATHTOADMIN . "classes");
$autoload->addNamespace('DataAL', PATHTOWEBROOT . "phpincludes/classes");

$ctl = new SitemapController();
$content - $ctl->work();
?>
