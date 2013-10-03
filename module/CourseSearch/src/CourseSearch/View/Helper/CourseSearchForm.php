<?php
namespace CourseSearch\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Model\ViewModel;
use CourseSearch\Form\CourseSearchForm as SearchForm;

class CourseSearchForm extends AbstractHelper {
	
	/**
	 * @var CourseSearchForm
	 */
	protected $courseSearchForm;
	
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
			'form' => $this->getCourseSearchForm(),
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
	 * Retrieve CourseSearch Form Object
	 * @return CourseSearchForm
	 */
	public function getCourseSearchForm()
	{
		return $this->searchForm;
	}
	
	/**
	 * Inject CourseSearch Form Object
	 * @param SearchForm $courseSearchForm
	 * @return CourseSearchForm View Helper
	 */
	public function setCourseSearchForm(SearchForm $courseSearchForm)
	{
		$this->searchForm = $courseSearchForm;
		return $this;
	}
	
	/**
	 * @param string $viewTemplate
	 * @return CourseSearchForm
	 */
	public function setViewTemplate($viewTemplate)
	{
		$this->viewTemplate = $viewTemplate;
		return $this;
	}
	
}