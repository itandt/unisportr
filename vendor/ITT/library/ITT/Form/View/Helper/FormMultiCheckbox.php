<?php
namespace ITT\Form\View\Helper;

use Zend\Form\View\Helper\FormMultiCheckbox as ZendFormMultiCheckbox;
use Zend\Form\Element\MultiCheckbox as MultiCheckboxElement;

class FormMultiCheckbox extends ZendFormMultiCheckbox {
	
	/**
	 * @see \Zend\Form\View\Helper\FormMultiCheckbox#renderOptions(...)
	 */
	protected function renderOptions(MultiCheckboxElement $element, array $options, array $selectedOptions,
                                     array $attributes)
	{
		$escapeHtmlHelper = $this->getEscapeHtmlHelper();
		$labelHelper      = $this->getLabelHelper();
		$labelClose       = $labelHelper->closeTag();
		$labelPosition    = $this->getLabelPosition();
		$globalLabelAttributes = $element->getLabelAttributes();
		$closingBracket   = $this->getInlineClosingBracket();
	
		if (empty($globalLabelAttributes)) {
			$globalLabelAttributes = $this->labelAttributes;
		}
	
		$combinedMarkup = array();
		$count          = 0;
	
		foreach ($options as $key => $optionSpec) {
			$count++;
			if ($count > 1 && array_key_exists('id', $attributes)) {
				unset($attributes['id']);
			}
	
			$value           = '';
			$label           = '';
			$selected        = false;
			$disabled        = false;
			$inputAttributes = $attributes;
			$labelAttributes = $globalLabelAttributes;
	
			if (is_scalar($optionSpec)) {
				$optionSpec = array(
						'label' => $optionSpec,
						'value' => $key
				);
			}
	
			if (isset($optionSpec['value'])) {
				$value = $optionSpec['value'];
			}
			if (isset($optionSpec['label'])) {
				$label = $optionSpec['label'];
			}
			if (isset($optionSpec['selected'])) {
				$selected = $optionSpec['selected'];
			}
			if (isset($optionSpec['disabled'])) {
				$disabled = $optionSpec['disabled'];
			}
			if (isset($optionSpec['label_attributes'])) {
				$labelAttributes = (isset($labelAttributes))
				? array_merge($labelAttributes, $optionSpec['label_attributes'])
				: $optionSpec['label_attributes'];
			}
			if (isset($optionSpec['attributes'])) {
				$inputAttributes = array_merge($inputAttributes, $optionSpec['attributes']);
			}
	
			if (in_array($value, $selectedOptions)) {
				$selected = true;
			}
	
			$inputAttributes['value']    = $value;
			$inputAttributes['checked']  = $selected;
			$inputAttributes['disabled'] = $disabled;
			
			$additionalInputAttributes = array('id' => $inputAttributes['name'] . $optionSpec['value']);
			$inputAttributes = array_merge($inputAttributes, $additionalInputAttributes);
			
			$input = sprintf(
					'<input %s%s',
					$this->createAttributesString($inputAttributes),
					$closingBracket
			);
	
			if (null !== ($translator = $this->getTranslator())) {
				$label = $translator->translate(
						$label, $this->getTranslatorTextDomain()
				);
			}
			
			$additionalLabelAttributes = array('for' => $additionalInputAttributes['id']);
			$labelAttributes = is_array($labelAttributes)
				? array_merge($labelAttributes, $additionalLabelAttributes)
				: $additionalLabelAttributes
			;

			$label     = $escapeHtmlHelper($label);
			$labelOpen = $labelHelper->openTag($labelAttributes);
			switch ($labelPosition) {
				case self::LABEL_PREPEND:
					$template  = $labelOpen . $label . $labelClose . '%s';
					break;
				case self::LABEL_APPEND:
				default:
					$template  = '%s' . $labelOpen . $label . $labelClose;
					break;
			}
			$markup = sprintf($template, $input);
	
			$combinedMarkup[] = $markup;
		}
	
		return implode($this->getSeparator(), $combinedMarkup);
	}
	
}