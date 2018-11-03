<?php
namespace Jakobus;

use Contentomat\CmtPage;
use Jakobus\Course;

class CourseCategory extends Model {

	protected $CmtPage;

	protected $Course;



	protected $hasMany = [
		[
			'name' => 'Courses',
			'className' => 'Jakobus\Course',
			'foreignKeyField' => 'course_category_id',
			'foreignKey' => 'id'
		]
	];

	public function init () {
		$this->setTableName ('jakobus_course_categories');
		$this->CmtPage = new CmtPage();
		$this->Course = new Course();
	}

	public function afterRead($category) {

		$category['course_overview_url'] = sprintf('%s%s',
			$this->CmtPage->makePageFilePath($this->Course->getOverviewPageId(), $this->language),
			$this->CmtPage->makePageFileName($this->Course->getOverviewPageId(), $this->language)
		);

		return $category;

	}
}
