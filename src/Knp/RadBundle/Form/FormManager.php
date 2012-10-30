<?php

namespace Knp\RadBundle\Form;

use Symfony\Component\Form\AbstractType;

class FormManager
{
    private $factory;

    public function __construct($factory)
    {
        $this->factory = $factory;
    }

    public function createFormFor($data, array $options = array(), AbstractType $type = null)
    {
        if (null !== $type) {
            $formType = $type;
        } else {
            $formType = $this->getDefaultFormType($data);
        }

        return $this->factory->create($formType, $data, $options);
    }

    /**
     * @throw \InvalidArgumentException when $entity is null
     */
    private function getDefaultFormType($entity)
    {
        if (!is_object($entity)) {
            throw new \InvalidArgumentException(sprintf('Expected object, got %s', gettype($entity)));
        }

        $class = get_class($entity);
        $formClass = $this->getFormType($class);

        return new $formClass();
    }

    private function getFormType($entityClass)
    {
        $arr = explode('\\', $entityClass);
        $formClass = sprintf('App\Form\%sType', end($arr));

        if (!class_exists($formClass)) {
            if (false !== $parentClass = get_parent_class($entityClass)) {
                $formClass = $this->getFormType($parentClass);
            } else {
                throw new \Exception(sprintf('Couldn\'t find a form type associated with %s', $entityClass));
            }
        }

        return $formClass;
    }
}
