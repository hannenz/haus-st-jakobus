<?php
namespace Jakobus;

use Contentomat\Contentomat;
use Contentomat\Gallery\Gallery;
use Contentomat\Controller;
use Contentomat\PsrAutoloader;

if (!class_exists('Jakobus\FotoalbumController')) {
	class FotoalbumController extends Controller {

		/**
		 * @var Array
		 */
		protected $params;


		/**
		 * @var \Contentomat\Gallery\Gallery
		 */
		protected $Gallery;



		public function init() {
			$this->Gallery = new Gallery();
			$this->cmt = Contentomat::getContentomat();
			$this->templatesPath = $this->templatesPath . 'gallery/';

			$contentData = $this->cmt->getVar('cmtContentData');
			$this->params = array(
				$contentData['head1'],
				$contentData['head2'],
				$contentData['head3'],
				$contentData['head4'],
				$contentData['head5']
			);
		}

		public function actionDefault() {

			$categoryId = $this->params[0];

			$images = $this->Gallery->getImagesInCategory($categoryId, []);
			$this->parser->setParserVar('images', $images);
			$this->content = $this->parser->parseTemplate($this->templatesPath . 'fotoalbum.tpl');
		}
	}
}

$autoload = new PsrAutoloader();
$autoload->addNamespace('Jakobus', PATHTOWEBROOT . 'classes');
$autoload->addNamespace('Contentomat', PATHTOADMIN . 'classes');
$autoload->addNamespace('Contentomat\Gallery', PATHTOADMIN . 'classes/app_gallery');

$ctl = new FotoalbumController();
$content .= $ctl->work();
?>
