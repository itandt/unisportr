<?php
namespace ITT\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\HelperPluginManager as ServiceManager;

class DisplayAnalytics extends AbstractHelper {
	
	protected $serviceManager;
	
	public function __construct(ServiceManager $serviceManager) {
		$this->serviceManager = $serviceManager;
	}
	
	public function __invoke() {
		$breakpoint = null;
		if ($this->serviceManager->getServiceLocator()->get('Config')['environment'] == 'development') {
			$return = $this->view->render('partials/piwik.phtml');
		}
		return $return;
	}
	
}