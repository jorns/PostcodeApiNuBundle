<?php

namespace FH\Bundle\PostcodeApiNuBundle\Form\Type;

use FH\Bundle\PostcodeApiNuBundle\Form\DataTransformer\PostalCodeGeoTransformer;
use PostcodeApiNu\Service as PostcodeService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PostalCodeGeoType extends AbstractType
{

    /**
     * @var \PostcodeApiNu\Service
     */
    protected $postcodeApiNuService;

    /**
     * @param PostcodeService $postcodeApiNuService
     */
    public function __construct(PostcodeService $postcodeApiNuService)
    {
        $this->postcodeApiNuService = $postcodeApiNuService;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $service = isset($options['service']) ? $options['service'] : $this->postcodeApiNuService;
        $builder->addModelTransformer(new PostalCodeGeoTransformer($service));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setOptional(['service']);
        $resolver->setAllowedTypes(['service' => 'PostcodeApiNu\ServiceInterface']);
    }

    public function getParent()
    {
        return 'text';
    }

    public function getName()
    {
        return 'postal_code_geo';
    }
}
