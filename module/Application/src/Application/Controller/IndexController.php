<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link	  http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController {
	
	public function indexAction() {
		return $this->forward()->dispatch('Application\Controller\Index', array('action' => 'about'));
	}
	
	public function mustheadAction() {
		return new ViewModel();
	}
	
	public function aboutAction() {
		return new ViewModel(array(
			'universities' => $this->getServiceLocator()->get('Cache\Model\UniversityStorage')->getUniversities(),
			'cities' => $this->getServiceLocator()->get('Cache\Model\CityStorage')->getCities(),
		));
	}
	
	public function sitemapAction() {
		return new ViewModel();
	}
	
}
