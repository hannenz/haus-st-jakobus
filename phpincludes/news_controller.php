<?php
namespace Jakobus;

use Contentomat\PsrAutoloader;
use Contentomat\Controller;
use Jakobus\News;


class NewsController extends Controller {

	/**
	 * @var \Jakobus\News
	 */
	protected $News;


	/**
	 * @var Integer
	 */
	protected $postId = 0;



	public function init() {
		$this->News = new News();
		$this->templatesPath = $this->templatesPath . 'news/';
	}



	public function initActions($action = 'default') {
		if (preg_match('/,(\d+)\.html$/', $_SERVER['REQUEST_URI'], $matches)) {
			$this->postId = (int)$matches[1];
			$this->action = 'detail';
		}
		else {
			$this->action = $action;
		}
	}


	public function actionDefault() {
		$posts = $this->News->getLatestPosts([
			'posts' => 3,
			'categoryID' => 1
		]);
		// var_dump($posts); 
		// var_dump($posts[0]['postMedia']); die();

		$this->parser->setParserVar('posts', $posts);
		$this->content = $this->parser->parseTemplate($this->templatesPath . 'latest.tpl');
	}



	public function actionDetail() {

		if ($this->postId < 1) {
			return;
		}

		$post = $this->News->getPost([
			'postID' => $this->postId
		]);
		$this->parser->setMultipleParserVars($post);
		$this->content = $this->parser->parseTemplate($this->templatesPath . 'detail.tpl');
	}
}

$autoload = new PsrAutoloader();
$autoload->addNamespace('Contentomat', PATHTOADMIN . 'classes');
$autoload->addNamespace('Contentomat\MLog', PATHTOADMIN . 'classes/app_mlog');
$autoload->addNamespace('Jakobus', PATHTOWEBROOT . 'phpincludes/classes');

$ctl = new NewsController();
$content = $ctl->work();
?>
