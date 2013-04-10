<?php
namespace Search\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Model\ViewModel;
use Search\Form\CourseSearchForm;

class SearchForm extends AbstractHelper {
	
	/**
	 * @var CourseSearchForm
	 */
	protected $searchForm;
	
	/**
	 * $var string template used for view
	 */
	protected $viewTemplate;
	
	/**
	 * __invoke
	 *
	 * @access public
	 * @param array $options array of options
	 * @return string
	 */
	public function __invoke($options = array()) {
		if (array_key_exists('render', $options)) {
			$render = $options['render'];
		} else {
			$render = true;
		}
		if (array_key_exists('redirect', $options)) {
			$redirect = $options['redirect'];
		} else {
			$redirect = false;
		}
	
		$viewModel = new ViewModel(array(
			'form' => $this->getSearchForm(),
			'redirect' => $redirect,
		));
		
		$viewModel->setTemplate($this->viewTemplate);
		
		if ($render) {
			return $this->getView()->render($viewModel);
		} else {
			return $viewModel;
		}
	}
	
	/**
	 * Retrieve Search Form Object
	 * @return SearchForm
	 */
	public function getSearchForm()
	{
		return $this->searchForm;
	}
	
	/**
	 * Inject Search Form Object
	 * @param CourseSearchForm $searchForm
	 * @return SearchForm View Helper
	 */
	public function setSearchForm(CourseSearchForm $searchForm)
	{
		$this->searchForm = $searchForm;
		return $this;
	}
	
	/**
	 * @param string $viewTemplate
	 * @return SearchForm
	 */
	public function setViewTemplate($viewTemplate)
	{
		$this->viewTemplate = $viewTemplate;
		return $this;
	}
	
}