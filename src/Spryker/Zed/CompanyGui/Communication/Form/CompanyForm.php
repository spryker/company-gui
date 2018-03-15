<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CompanyGui\Communication\Form;

use Spryker\Zed\Kernel\Communication\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Required;

/**
 * @method \Spryker\Zed\CompanyGui\Communication\CompanyGuiCommunicationFactory getFactory()
 */
class CompanyForm extends AbstractType
{
    const OPTION_COMPANY_TYPE_CHOICES = 'company_type_choices';

    const FIELD_ID_COMPANY = 'id_company';
    const FIELD_NAME = 'name';
    const FIELD_FK_COMPANY_TYPE = 'fk_company_type';

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'customer';
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired(static::OPTION_COMPANY_TYPE_CHOICES);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this
            ->addIdCompanyField($builder)
            ->addNameField($builder)
            ->addCompanyTypeField($builder, $options[self::OPTION_COMPANY_TYPE_CHOICES]);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return \Spryker\Zed\CompanyGui\Communication\Form\CompanyForm
     */
    protected function addIdCompanyField(FormBuilderInterface $builder)
    {
        $builder->add(self::FIELD_ID_COMPANY, HiddenType::class);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return \Spryker\Zed\CompanyGui\Communication\Form\CompanyForm
     */
    protected function addNameField(FormBuilderInterface $builder)
    {
        $builder->add(self::FIELD_NAME, TextType::class, [
            'label' => 'Name',
            'constraints' => $this->getTextFieldConstraints(),
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $choices
     *
     * @return \Spryker\Zed\CompanyGui\Communication\Form\CompanyForm
     */
    protected function addCompanyTypeField(FormBuilderInterface $builder, array $choices)
    {
        $builder->add(self::FIELD_FK_COMPANY_TYPE, ChoiceType::class, [
            'label' => 'Company type',
            'placeholder' => 'Select one',
            'choices' => array_flip($choices),
            'choices_as_values' => true,
            'constraints' => [
                new NotBlank(),
            ],
        ]);

        return $this;
    }

    /**
     * @return array
     */
    protected function getTextFieldConstraints()
    {
        return [
            new Required(),
            new NotBlank(),
            new Length(['max' => 100]),
        ];
    }
}