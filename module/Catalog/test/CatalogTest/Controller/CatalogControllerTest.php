<?php
namespace CatalogTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

use CatalogTest\Bootstrap;
use Catalog\Controller\CatalogController;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;
use PHPUnit_Framework_TestCase;

class CatalogControllerTest extends AbstractHttpControllerTestCase
{
	protected $controller;
	protected $request;
	protected $response;
	protected $routeMatch;
	protected $event;
	
	public function setUp()
	{
		$serviceManager		= Bootstrap::getServiceManager();
		$this->controller	= new CatalogController();
		$this->request		= new Request();
		$this->routeMatch	= new RouteMatch(array('controller' => 'catalog'));
		$this->event		= new MvcEvent();
		$config				= $serviceManager->get('Config');
		$routerConfig		= isset($config['router']) ? $config['router'] : array();
		$router				= HttpRouter::factory($routerConfig);
		
		$this->event->setRouter($router);
		$this->event->setRouteMatch($this->routeMatch);
		$this->controller->setEvent($this->event);
		$this->controller->setServiceLocator($serviceManager);
		
		parent::setUp();
		$this->traceError = true;
	}

    public function testIndexActionCanBeAccessed()
    {
    	// Specify which action to run
        $this->routeMatch->setParam('action', 'index');
        // Kick the controller into action
        $result   = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        // Check the HTTP response code
        $this->assertEquals(200, $response->getStatusCode());
        // Check for a ViewModel to be returned
        $this->assertInstanceOf('Zend\View\Model\ViewModel', $result);
        // Test the parameters contained in the View model
        // when the ViewModel has variables: ViewModel(array("var" => "test")
        // $vars = $result->getVariables();
        // $this->assertTrue(isset($vars['var']));
    }
}