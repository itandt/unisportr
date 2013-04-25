<?php
namespace ITT\Form\View\Helper;

use Zend\Form\ElementInterface;
use Zend\Form\Exception;
use Zend\Form\View\Helper\FormLabel as ZendFormLabel;

class FormLabel extends ZendFormLabel
{
    public function openTag($attributesOrElement = null)
    {
        if (null === $attributesOrElement) {
            return '<label>';
        }

        if (is_array($attributesOrElement)) {
            $attributes = $this->createAttributesString($attributesOrElement);
            return sprintf('<label %s>', $attributes);
        }

        if (!$attributesOrElement instanceof ElementInterface) {
            throw new Exception\InvalidArgumentException(sprintf(
                '%s expects an array or Zend\Form\ElementInterface instance; received "%s"',
                __METHOD__,
                (is_object($attributesOrElement) ? get_class($attributesOrElement) : gettype($attributesOrElement))
            ));
        }

        $id = $this->getId($attributesOrElement);
        if (null === $id) {
            throw new Exception\DomainException(sprintf(
                '%s expects the Element provided to have either a name or an id present; neither found',
                __METHOD__
            ));
        }

        $labelAttributes = $attributesOrElement->getLabelAttributes();
        
        $elementAttributeId = $attributesOrElement->getAttribute('id');
        $labelAttributeForDeactivated = isset($labelAttributes['for']) && $labelAttributes['for'] === false;
        
        if (!empty($elementAttributeId) && !$labelAttributeForDeactivated) {
        	$attributes = array('for' => $id);
        } else {
        	$attributes = array();
        	unset($labelAttributes['for']);
        }

        if (!empty($labelAttributes)) {
            $attributes = array_merge($labelAttributes, $attributes);
        }
		
        $attributesString = $this->createAttributesString($attributes);
        $attributesString = !empty($attributesString) ? ' ' . $attributesString : $attributesString;
        return sprintf('<label%s>', $attributesString);
    }
}
