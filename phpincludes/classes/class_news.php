<?php
namespace Jakobus;

use Contentomat\MLog\Posts;
use Contentomat\CmtPage;
use Contentomat\Contentomat;

class News extends Posts {


	/**
	 * @var Integer
	 */
	protected $detailPageId = 59; //37;

	/**
	 * @var Integer
	 */
	protected $overviewPageId = 36;

	/**
	 * @var Integer;
	 */
	protected $defaultCategoryId = 0;


	/**
	 * @var Integer;
	 */
	protected $currentCategoryId;


	/**
	 * @var Integer;
	 */
	protected $currentPage;




	public function __construct() {
		parent::__construct();
	}

	public function initPosts() {
		parent::initPosts();

		$this->CmtPage = new CmtPage();

		// Make first available category the default category
		$categories = $this->getPostsCategories();
		$defaultCategory = array_shift($categories);
		if ($defaultCategory != null && !empty($defaultCategory['id'])) {
			$this->defaultCategoryId = (int)$defaultCategory['id'];
		}
		$this->currentPage = 1;
		$this->currentCategoryId = $this->defaultCategoryId;
	}



	public function getLatestPosts($params) {

		$posts = $this->getLastPosts($params);
		foreach ($posts as $n => $post) {
			$posts[$n] = $this->afterRead($post);
		}
		return $posts;
	}


	public function getPosts($params) {

		$posts = $this->search($params);
		foreach ($posts as $n => $post) {
			$posts[$n] = $this->afterRead($post);
		}
		return $posts;
	}


	// public function getPost($id) {
	// 	$post = parent::getPost($id);
	// 	return $this->afterRead($post);
	// }


	protected function afterRead($post) {
		$post['postDetailUrl'] = sprintf("%s%s-%s,%u,%u,%u.html", 
			$this->CmtPage->makePageFilePath($this->detailPageId),
			strftime('%Y-%m-%d', strtotime($post['post_online_date'])),
			Contentomat::makeNameWebSave($post['post_title']),
			$this->currentCategoryId,
			$this->currentPage,
			$post['id']
		);
		$post['postOverviewUrl'] = sprintf("%s%s", 
			$this->CmtPage->makePageFilePath($this->overviewPageId),
			$this->CmtPage->makePageFileName($this->overviewPageId)
		);

		$post['post_date_fmt_date'] = strftime('%a. %d. %b %Y', strtotime($post['post_online_date']));
		$post['post_date_fmt_datetime'] = strftime('%d.%m.%Y %H:%M', strtotime($post['post_online_date']));
		$post['post_time_fmt_time'] = strftime('%H:%M', strtotime($post['post_online__date']));

		$post['post_categories_fmt'] = '';
		$categories = [];
		foreach ($post['post_categories'] as $category) {
			$categories[] = $category['category_title_de'];
		}
		$post['post_categories_fmt'] = join(', ', $categories);

		return $post;
	}



	/**
	 * Getter for defaultCategoryId
	 *
	 * @return integer
	 */
	public function getDefaultCategoryId() {
	    return $this->defaultCategory;
	}



	/**
	 * Setter for defaultCategoryId
	 *
	 * @param integer $defaultCategoryId
	 */
	public function setDefaultCategoryId($defaultCategoryId) {
	    $this->defaultCategoryId = $defaultCategoryId;
	}

	/**
	 * Getter for currentCategoryId
	 *
	 * @return integer
	 */
	public function getCurrentCategoryId() {
	    return $this->currentCategoryId;
	}
	
	/**
	 * Setter for currentCategoryId
	 *
	 * @param integer $currentCategoryId
	 */
	public function setCurrentCategoryId($currentCategoryId) {
	    $this->currentCategoryId = $currentCategoryId;
	
	}



	/**
	 * Getter for currentPage
	 *
	 * @return integer
	 */
	public function getCurrentPage() {
	    return $this->currentPage;
	}
	
	/**
	 * Setter for currentPage
	 *
	 * @param Integer $currentPage
	 */
	public function setCurrentPage($currentPage) {
	    $this->currentPage = $currentPage;
	}
}
?>
