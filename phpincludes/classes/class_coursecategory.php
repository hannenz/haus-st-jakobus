<?php
namespace Jakobus;

use Contentomat\CmtPage;
use Jakobus\Course;
use Jakobus\Event;

class CourseCategory extends Model {

	protected $CmtPage;

	protected $Course;

	protected $Event;



	protected $hasMany = [
		[
			'name' => 'Courses',
			'className' => 'Jakobus\Course',
			'foreignKeyField' => 'course_category_id',
			'foreignKey' => 'id',
			'order' => 'course_pos ASC'
		]
	];

	public function init () {
		$this->setTableName ('jakobus_course_categories');
		$this->CmtPage = new CmtPage();
		$this->Course = new Course();
		$this->Event = new Event();
	}

	public function afterRead($category) {

		$category['course_overview_url'] = sprintf('%s%s',
			$this->CmtPage->makePageFilePath($this->Course->getOverviewPageId(), $this->language),
			$this->CmtPage->makePageFileName($this->Course->getOverviewPageId(), $this->language)
		);
		// 2022-04-30: Refactoring to using only events
		$category['event_overview_url'] = sprintf('%s%s',
			$this->CmtPage->makePageFilePath($this->Event->getOverviewPageId(), $this->language),
			$this->CmtPage->makePageFileName($this->Event->getOverviewPageId(), $this->language)
		);

		return $category;

	}
}
