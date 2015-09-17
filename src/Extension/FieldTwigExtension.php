<?php

namespace WilliamEspindola\Field\Extension;

use Twig_Extension;
use Twig_Function_Method;
use WilliamEspindola\Field\Repository\FieldRepository;
use WilliamEspindola\Field\Service\DoctrineFieldService;
use WilliamEspindola\Field\Service\RespectFieldService;
use Respect\Relational\Mapper;

/**
 * Class FieldTwigExtension
 * @package WilliamEspindola\Field\Extension
 */
class FieldTwigExtension extends Twig_Extension
{
    /**
     * @var
     */
    protected $fieldService;

    /**
     * @var
     */
    protected $optionService;

    /**
     * @param FieldRepository $fieldRepository
     */
    public function __construct(
        FieldRepository $fieldRepository
    ) {
        if ($fieldRepository->getStorage()->getMapper() instanceof Mapper) {
            $this->fieldService = new RespectFieldService($fieldRepository);
        } else {
            $this->fieldService = new DoctrineFieldService($fieldRepository);
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
