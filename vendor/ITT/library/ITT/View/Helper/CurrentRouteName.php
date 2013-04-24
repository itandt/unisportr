<?php
namespace ITT\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\HelperPluginManager;
use Zend\Mvc\Router\RouteMatch;

class CurrentRouteName extends AbstractHelper {
	
	protected $helperPluginManager;
	
	public function __construct(HelperPluginManager $serviceManager) {
		$this->helperPluginManager = $serviceManager;
	}
	
	public function __invoke() {
		$serviceLocator = $this->helperPluginManager->getServiceLocator();
		if($serviceLocator->get('Application')->getMvcEvent()->getRouteMatch() instanceof RouteMatch) {
			$currentRouteName = $serviceLocator->get('Application')->getMvcEvent()->getRouteMatch()->getMatchedRouteName();
		} else {
			$currentRouteName = null;
		}
		return $currentRouteName;
	}
	
}