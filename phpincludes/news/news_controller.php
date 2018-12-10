<?php
namespace Jakobus;

use Contentomat\Contentomat;
use Contentomat\PsrAutoloader;
use Contentomat\Controller;
use Contentomat\Paging;
use Contentomat\CmtPage;
use Jakobus\News;


if (class_exists('\Jakobus\NewsController') === false) {

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
			$this->CmtPage = new CmtPage();
			$this->News = new News();
			$this->templatesPath = $this->templatesPath . 'news/';
			$contentData = Contentomat::getContentomat()->getVar('cmtContentData');
			$this->params = [
				$contentData['head1'],
				$contentData['head2'],
				$contentData['head3'],
				$contentData['head4'],
				$contentData['head5']
			];
		}



		public function initActions($action = 'default') {

			if (!empty($this->params[0])) {
				$this->action = trim($this->params[0]);
				return;
			}

			// Detail:   .{category},{page},{postid}.html
			// Overview: .{category}.{page}.html
			if (preg_match('/,(\d+),(\d+),(\d+)\.html$/', $_SERVER['REQUEST_URI'], $matches)) {
				$this->News->setCurrentCategoryId((int)$matches[1]);
				$this->News->setCurrentPage((int)$matches[2]);
				$this->action = 'detail';
				$this->postId = (int)$matches[3];
			}
			else if (preg_match('/,(\d+),(\d+)\.html$/', $_SERVER['REQUEST_URI'], $matches)) {
				$this->News->setCurrentCategoryId((int)$matches[1]);
				$this->News->setCurrentPage((int)$matches[2]);
				$this->action = 'default';
			}
			else {
				$this->action = $action;
			}
		}



		public function actionDefault() {

			$currentPage = $this->News->getCurrentPage();
			$categoryId = $this->News->getCurrentCategoryId();

			if (preg_match('/,(\d+),(\d+)\.html$/', $_SERVER['REQUEST_URI'], $matches)) {
				$category = $matches[1];
				$currentPage = $matches[2];
			}

			$posts = $this->News->getPosts([
				'postsPerPage' => 10,
				'categoryID' => $categoryId,
				'currentPage' => $currentPage
			]);

			$totalPosts = (int)$this->News->getTotalPosts();
			$countPages = ($totalPosts - 1) / 3 + 1;

			$nextPageUrl = $currentPage >= $countPages ? null : sprintf('%s/%s,%u,%u.html',
				$this->CmtPage->makePageFilePath(),
				$this->CmtPage->makePageFileName(),
				$categoryId,
				$currentPage + 1
			);

			$prevPageUrl = $currentPage <= 1 ? null : sprintf('%s/%s,%u,%u.html',
				$this->CmtPage->makePageFilePath(),
				$this->CmtPage->makePageFileName(),
				$categoryId,
				$currentPage - 1
			);

			for ($i = 1; $i <= $countPages; $i++) {
				$pagingLinks[] = [
					'pagingLink' => sprintf('%s/%s,%u,%u.html',
						$this->CmtPage->makePageFilePath(),
						$this->CmtPage->makePageFileName(),
						$categoryId,
						$i),
					'iter' => $i,
					'isCurrent' => $i == $currentPage ? 1 : 0
				];
			}

			$this->parser->setMultipleParserVars([
				'posts' => $posts,
				'prevPageUrl' => $prevPageUrl,
				'nextPageUrl' => $nextPageUrl,
				'pagingLinks' => $pagingLinks
			]);

			$this->content = $this->parser->parseTemplate($this->templatesPath . 'latest.tpl');
		}



		public function actionDetail() {

			if ($this->postId < 1) {
				return;
			}

			$post = $this->News->getPost([
				'postID' => $this->postId
			]);

			define('POSTTITLE', $post['post_title']);
			define('MOODIMAGE', '/media/mlog/static/'.$post['post_image']);


			if ($post['hasMedia']) {
				if ($post['hasMedia']['hasimage']) {
					$this->parser->setMultipleParserVars([
						'hasImage' => $post['hasMedia']['hasimage'],
						'images' => $post['postMedia']['image']
					]);
				}
				// ..
			}

			$this->parser->setMultipleParserVars($post);
			$this->content = $this->parser->parseTemplate($this->templatesPath . 'detail.tpl');
		}


		public function actionSidebarTeasers() {
			$posts = $this->News->getLatestPosts([
				'posts' => 3,
				'categoryID' => $this->News->getDefaultCategoryId()
			]);
			$this->parser->setParserVar('posts', $posts);
			$this->content = $this->parser->parseTemplate($this->templatesPath . 'sidebar_teasers.tpl');
		}
	}
}


$autoload = new PsrAutoloader();
$autoload->addNamespace('Contentomat', PATHTOADMIN . 'classes');
$autoload->addNamespace('Contentomat\MLog', PATHTOADMIN . 'classes/app_mlog');
$autoload->addNamespace('Jakobus', PATHTOWEBROOT . 'phpincludes/classes');

$ctl = new NewsController();
$content = $ctl->work();
?>
