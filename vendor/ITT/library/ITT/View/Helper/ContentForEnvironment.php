<?php
namespace ITT\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\HelperPluginManager as ServiceManager;

class ContentForEnvironment extends AbstractHelper {
	
	protected $serviceManager;
	
	public function __construct(ServiceManager $serviceManager) {
		$this->serviceManager = $serviceManager;
	}
	
	/**
	 * Returns rendered partial $partial,
	 * IF the current environment IS IN $whiteList AND NOT IN $blackList,
	 * ELSE NULL.
	 * Usage examples:
	 * Partial for every environment (equivalent to echo $this->view->render($partial)):
	 * 	echo $this->contentForEnvironment('path/to/partial.phtml');
	 * Partial for 'live' environment only:
	 * 	echo $this->contentForEnvironment('path/to/partial.phtml', ['live']);
	 * Partial for every environment except 'development':
	 * 	echo $this->contentForEnvironment('path/to/partial.phtml', [], ['development', 'staging']);
	 * @param string $partial
	 * @param array $whiteList
	 * @param array $blackList optional
	 * @return string rendered partial $partial or NULL.
	 */
	public function __invoke($partial, array $whiteList, array $blackList = []) {
		$currentEnvironment = $this->serviceManager->getServiceLocator()->get('Config')['environment'];
		$content = null;
		if (!empty($whiteList)) {
			$content = in_array($currentEnvironment, $whiteList) && !in_array($currentEnvironment, $blackList)
				? $this->view->render($partial)
				: null
			;
		} else {
			$content = !in_array($currentEnvironment, $blackList)
				? $this->view->render($partial)
				: null
			;
		}
		return $content;
	}
	
}