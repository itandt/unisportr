<?php
namespace ITT\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\HelperPluginManager;

class CurrentRouteName extends AbstractHelper {
	
	protected $helperPluginManager;
	
	public function __construct(HelperPluginManager $serviceManager) {
		$this->helperPluginManager = $serviceManager;
	}
	
	public function __invoke() {
		$serviceLocator =  $this->helperPluginManager->getServiceLocator();
		$currentRouteName = $serviceLocator->get('Application')->getMvcEvent()->getRouteMatch()->getMatchedRouteName();
		return $currentRouteName;
	}
	
}