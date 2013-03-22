<?php
namespace Catalog;

use Zend\EventManager\EventManager;
use Zend\Http\PhpEnvironment;
use Zend\ModuleManager\ModuleManager;
use Zend\Mvc\Application;
use Zend\ServiceManager\ServiceManager;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\Mvc\MvcEvent;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;

use Catalog\Model\City;
use Catalog\Model\CityTable;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
    	/**
		 * @var ServiceManager $serviceManager
    	 */
        $serviceManager = $e->getApplication()->getServiceManager();
        $registeredServices = $serviceManager->getRegisteredServices();
		$breakpoint = null;
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
                ),
            ),
        );
    }
    
    public function getServiceConfig() {
    	try {
    		return array (
    			'factories' =>array(
	    			'Catalog\Model\CityTable' => function ($serviceManager) {
	    				$tableGateway = $serviceManager->get('CityTableGateway');
	    				$table = new CityTable($tableGateway);
	    				return $table;
	    			},
	    			'CityTableGateway' => function ($serviceManager) {
	    				$dbAdapter = $serviceManager->get('Zend\Db\Adapter\Adapter');
	    				$resultSetPrototype = new ResultSet();
	    				$resultSetPrototype->setArrayObjectPrototype(new City());
	    				return new TableGateway('cities', $dbAdapter, null, $resultSetPrototype);
	    			}
	    		)
    		);
    	} catch (\Exception $e) {
    		do {
    			echo $e->getMessage();
    		} while ($e = $e->getPrevious());
    	}
    	// $breakpoint = null;

    }
}
