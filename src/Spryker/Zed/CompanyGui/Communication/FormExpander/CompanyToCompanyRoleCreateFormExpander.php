<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CompanyGui\Communication\FormExpander;

use Spryker\Zed\CompanyGui\Communication\Form\DataProvider\CompanyToCompanyRoleCreateFormDataProvider;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormTypeInterface;

class CompanyToCompanyRoleCreateFormExpander implements CompanyToCompanyRoleCreateFormExpanderInterface
{
    /**
     * @var \Symfony\Component\Form\FormTypeInterface
     */
    protected $companyToCompanyRoleCreateForm;

    /**
     * @var \Spryker\Zed\CompanyGui\Communication\Form\DataProvider\CompanyToCompanyRoleCreateFormDataProvider
     */
    protected $companyToCompanyRoleCreateFormDataProvider;

    public function __construct(
        FormTypeInterface $companyToCompanyRoleCreateForm,
        CompanyToCompanyRoleCreateFormDataProvider $companyToCompanyRoleCreateFormDataProvider
    ) {
        $this->companyToCompanyRoleCreateForm = $companyToCompanyRoleCreateForm;
        $this->companyToCompanyRoleCreateFormDataProvider = $companyToCompanyRoleCreateFormDataProvider;
    }

    public function expand(FormBuilderInterface $builder): FormBuilderInterface
    {
        $idCompany = $builder->getData()->getFkCompany();

        $this->companyToCompanyRoleCreateForm->buildForm(
            $builder,
            $this->companyToCompanyRoleCreateFormDataProvider->getOptions($idCompany),
        );

        return $builder;
    }
}
