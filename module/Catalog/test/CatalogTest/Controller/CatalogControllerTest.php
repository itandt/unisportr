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
use Zend\View\Variables;
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
    	$this->markTestIncomplete();

//     	$this->routeMatch->setParam('action', 'index');
//     	print_r($this->request);
//     	die(PHP_EOL . '###' . $this->event->getRouteMatch()->getParam('controller', null) . '###' . PHP_EOL);
//     	die('###');
//     	$response = $this->controller->getResponse();
    }
    
	public function testListCitiesActionCanBeAccessed() {
        $this->routeMatch->setParam('action', 'list-cities');
        $result   = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertInstanceOf('Zend\View\Model\ViewModel', $result);
        $vars = $result->getVariables();
        $this->assertFalse(isset($vars['city']));
        $this->assertFalse(isset($vars['sport']));
	}
	
	public function testListSportsActionCanBeAccessed() {
		$this->routeMatch->setParam('action', 'list-sports');
        $this->routeMatch->setParam('city', 'Berlin');
        $result   = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $vars = $result->getVariables();
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertInstanceOf('Zend\View\Model\ViewModel', $result);
        $this->assertTrue(isset($vars['city']));
        $this->assertNotNull($vars['city']);
	}
	
	public function testListCoursesActionCanBeAccessed() {
        $this->routeMatch->setParam('action', 'list-courses');
        $this->routeMatch->setParam('city', 'Berlin');
        $this->routeMatch->setParam('sport', 'Aikido');
        $result   = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $vars = $result->getVariables();
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertInstanceOf('Zend\View\Model\ViewModel', $result);
        $this->assertTrue(isset($vars['city']));
        $this->assertNotNull($vars['city']);
        $this->assertTrue(isset($vars['sport']));
        $this->assertNotNull($vars['sport']);
	}
}