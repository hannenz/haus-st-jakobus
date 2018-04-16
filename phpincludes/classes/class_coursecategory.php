<?php
namespace Jakobus;

class CourseCategory extends Model {

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
	}
}
