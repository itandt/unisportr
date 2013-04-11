<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module {
	
    public function onBootstrap(MvcEvent $mvcEvent)
    {
        $mvcEvent->getApplication()->getServiceManager()->get('translator');
        $eventManager        = $mvcEvent->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        
        $application = $mvcEvent->getApplication();
        $serviceManager = $application->getServiceManager();
        $viewHelperManager = $serviceManager->get('ViewHelperManager');
        $viewHelperManager->setInvokableClass('formmulticheckbox', 'ITT\Form\View\Helper\FormMultiCheckbox');
        $viewHelperManager->setInvokableClass('formradio', 'ITT\Form\View\Helper\FormRadio');
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
	
	public function getViewHelperConfig() {
		return array(
			'invokables' => array(
				'FormMultiCheckboxViewHelper' => 'ITT\Form\View\Helper\FormMultiCheckbox()',
			)
		);
	}
}
