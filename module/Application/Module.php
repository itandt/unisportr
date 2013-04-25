<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link	  http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Validator\AbstractValidator;
use Zend\Console\Console;

class Module {
	
	public function onBootstrap(MvcEvent $mvcEvent) {
		$eventManager		= $mvcEvent->getApplication()->getEventManager();
		$moduleRouteListener = new ModuleRouteListener();
		$moduleRouteListener->attach($eventManager);
		
		$application = $mvcEvent->getApplication();
		$serviceManager = $application->getServiceManager();
		
		$viewHelperManager = $serviceManager->get('ViewHelperManager');
		$viewHelperManager->setInvokableClass('formmulticheckbox', 'ITT\Form\View\Helper\FormMultiCheckbox');
		$viewHelperManager->setInvokableClass('formradio', 'ITT\Form\View\Helper\FormRadio');
		$viewHelperManager->setInvokableClass('formrow', 'ITT\Form\View\Helper\FormRow');
		$viewHelperManager->setInvokableClass('formlabel', 'ITT\Form\View\Helper\FormLabel');
		
		// $viewHelperManager->setInvokableClass('url', 'ITT\View\Helper\Url'); doesn't work;
		// factory must be set/overwritten instead.
		$viewHelperManager->setFactory('url', function ($sm) use($serviceManager) {
			$helper = new \ITT\View\Helper\Url;
			$router = Console::isConsole() ? 'HttpRouter' : 'Router';
			$helper->setRouter($serviceManager->get($router));
			
			$match = $serviceManager->get('application')
			->getMvcEvent()
			->getRouteMatch();
			
			if ($match instanceof RouteMatch) {
				$helper->setRouteMatch($match);
			}
			
			return $helper;
		});
		
		$translator = $serviceManager->get('translator');
		$translator->addTranslationFile(
			'phpArray',
			'./vendor/zendframework/zendframework/resources/languages/de/Zend_Validate.php'
		);
		AbstractValidator::setDefaultTranslator($translator);
	}

	public function getConfig()
	{
		return include __DIR__ . '/config/module.config.php';
	}

	public function getAutoloaderConfig()
	{
		return array(
			'Zend\Loader\ClassMapAutoloader' => array(
				__DIR__ . '/autoload_classmap.php',
			),
			'Zend\Loader\StandardAutoloader' => array(
				'namespaces' => array(
					__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
					'ITT' => __DIR__ . '/../../vendor/ITT/library/ITT',
				),
			),
		);
	}
	
	public function getViewHelperConfig() {
		return array(
			'factories' => array(
				'contentForEnvironment' => function($serviceManager) {
					$helper = new \ITT\View\Helper\ContentForEnvironment($serviceManager);
					return $helper;
				},
				'currentRoute' => function($serviceManager) {
					$helper = new \ITT\View\Helper\CurrentRouteName($serviceManager);
					return $helper;
				},
			)
		);
	}
	
}
