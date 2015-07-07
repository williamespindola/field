<?php

namespace WilliamEspindola\Field\Extension;

use Twig_Extension;
use Twig_Function_Method;
use WilliamEspindola\Field\Repository\FieldRepository;
use WilliamEspindola\Field\Repository\OptionRepository;

class FieldTwigExtension extends Twig_Extension
{
    /**
     * @var \WilliamEspindola\Field\Repository\FieldRepository
     */
    protected $fieldRepository;

    /**
     * @var \WilliamEspindola\Field\Repository\OptionRepository
     */
    protected $optionService;

    public function __construct(
        FieldRepository $fieldRepository,
        OptionRepository $optionRepository
    ) {
        $this->fieldRepository = $fieldRepository;
        $this->optionRepository = $optionRepository;
    }

    /**
     * @return array Extension functions
     */
    public function getFunctions()
    {
        return [
            'field' => new Twig_Function_Method($this, 'getField'),
            'fieldValue' => new Twig_Function_Method($this, 'getFieldValue'),
            'optionsOfField' => new Twig_Function_Method($this, 'getOptionsOfField'),
        ];
    }

    /**
     * @param $name Name of field
     * @return array Field Object
     */
    public function getField($name)
    {
        return $this->fieldRepository->fetchBy(['name' => $name]);
    }

    /**
     * @param $name Name of Field
     * @return array Field Object with your options
     */
    public function getOptionsOfField($name)
    {
        $field = $this->fieldRepository->fetchBy(['name' => $name]);
        $field->options = $this->optionRepository->findBy(
            ['field_id' => $field->getId()],
            Sql::orderBy('id')
        );

        return $field;
    }

    /**
     * @param $name Name of Field
     * @return string Value of field
     */
    public function getFieldValue($name)
    {
        $field = $this->fieldRepository->fetchBy(['name' => $name]);

        return $field->getValue();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'field';
    }
}
