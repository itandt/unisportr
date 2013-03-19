<?php
namespace Catalog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * CatalogController
 * 
 * @author
 * @version 
 */
class CatalogController extends AbstractActionController {
	/**
	 * The default action - show the home page
	 */
	public function indexAction() {
		return new ViewModel();
	}
}