<?php

namespace WilliamEspindola\Field\Extension;

use Twig_Extension;
use Twig_Function_Method;
use WilliamEspindola\Field\Repository\FieldRepository;
use WilliamEspindola\Field\Repository\OptionRepository;
use Respect\Relational\Mapper;

/**
 * Class FieldTwigExtension
 * @package WilliamEspindola\Field\Extension
 */
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

    /**
     * @param FieldRepository $fieldRepository
     * @param OptionRepository $optionRepository
     */
    public function __construct(
        FieldRepository $fieldRepository,
        OptionRepository $optionRepository
    ) {
        $this->fieldRepository = $fieldRepository;
        $this->optionRepository = $optionRepository;

        if ($this->fieldRepository->getStorage()->getMapper() instanceof Mapper) {
            $this->fieldService = new RespectFieldService($this->fieldRepository);
        } else {
            $this->fieldService = new DoctrineFieldService($this->fieldRepository);
        }
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
        return $this->fieldService->findOneByName($name);
    }

    /**
     * @param $name Name of Field
     * @return array Field Object with your options
     */
    public function getOptionsOfField($name)
    {
        $field = $this->fieldService->findOneByName($name);

        return $this->optionService->getOptionsOfField($field, 'id');
    }

    /**
     * @param $name Name of Field
     * @return string Value of field
     */
    public function getFieldValue($name)
    {
        return $this->fieldService->findOneByNameAndGetValue($name);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'field';
    }
}
