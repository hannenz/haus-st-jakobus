<?php
namespace Jakobus;

use Contentomat\MLog\Posts;
use Contentomat\CmtPage;
use Contentomat\Contentomat;

class News extends Posts {


	/**
	 * @var Integer
	 */
	protected $detailPageId = 37;



	public function initPosts() {
		parent::initPosts();
		$this->CmtPage = new CmtPage();
	}



	public function getLatestPosts($params) {

		$posts = $this->getLastPosts($params);

		$posts = $this->afterRead($posts);

		return $posts;
	}



	protected function afterRead($posts) {
		foreach ($posts as &$post) {

			$post['postDetailUrl'] = sprintf("%s%s-%s,%u.html", 
				$this->CmtPage->makePageFilePath($this->detailPageId),
				strftime('%Y-%m-%d', strtotime($post['post_online_date'])),
				Contentomat::makeNameWebSave($post['post_title']),
				$post['id']
			);
		}
		return $posts;
	}
}
?>
