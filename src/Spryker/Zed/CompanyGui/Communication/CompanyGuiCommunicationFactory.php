<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CompanyGui\Communication;

use Orm\Zed\Company\Persistence\SpyCompanyQuery;
use Spryker\Zed\CompanyGui\Communication\Form\ActivateCompanyForm;
use Spryker\Zed\CompanyGui\Communication\Form\ApproveCompanyForm;
use Spryker\Zed\CompanyGui\Communication\Form\CompanyForm;
use Spryker\Zed\CompanyGui\Communication\Form\CompanyToCompanyBusinessUnitForm;
use Spryker\Zed\CompanyGui\Communication\Form\CompanyToCompanyRoleCreateForm;
use Spryker\Zed\CompanyGui\Communication\Form\CompanyToCompanyUnitAddressForm;
use Spryker\Zed\CompanyGui\Communication\Form\CompanyToCompanyUserForm;
use Spryker\Zed\CompanyGui\Communication\Form\CompanyToCustomerCompanyAttachForm;
use Spryker\Zed\CompanyGui\Communication\Form\CompanyUserCompanyForm;
use Spryker\Zed\CompanyGui\Communication\Form\DataProvider\CompanyFormDataProvider;
use Spryker\Zed\CompanyGui\Communication\Form\DataProvider\CompanyToCompanyBusinessUnitFormDataProvider;
use Spryker\Zed\CompanyGui\Communication\Form\DataProvider\CompanyToCompanyRoleCreateFormDataProvider;
use Spryker\Zed\CompanyGui\Communication\Form\DataProvider\CompanyToCompanyUnitAddressFormDataProvider;
use Spryker\Zed\CompanyGui\Communication\Form\DataProvider\CompanyToCompanyUserFormDataProvider;
use Spryker\Zed\CompanyGui\Communication\Form\DataProvider\CompanyToCustomerCompanyAttachFormDataProvider;
use Spryker\Zed\CompanyGui\Communication\Form\DataProvider\CompanyUserCompanyFormDataProvider;
use Spryker\Zed\CompanyGui\Communication\Form\DeactivateCompanyForm;
use Spryker\Zed\CompanyGui\Communication\Form\DenyCompanyForm;
use Spryker\Zed\CompanyGui\Communication\Formatter\CompanyGuiFormatter;
use Spryker\Zed\CompanyGui\Communication\Formatter\CompanyGuiFormatterInterface;
use Spryker\Zed\CompanyGui\Communication\Formatter\CompanyNameFormatter;
use Spryker\Zed\CompanyGui\Communication\Formatter\CompanyNameFormatterInterface;
use Spryker\Zed\CompanyGui\Communication\FormExpander\CompanyFieldToCompanyUserFormExpander;
use Spryker\Zed\CompanyGui\Communication\FormExpander\CompanyFieldToCompanyUserFormExpanderInterface;
use Spryker\Zed\CompanyGui\Communication\FormExpander\CompanyToCompanyBusinessUnitFormExpander;
use Spryker\Zed\CompanyGui\Communication\FormExpander\CompanyToCompanyBusinessUnitFormExpanderInterface;
use Spryker\Zed\CompanyGui\Communication\FormExpander\CompanyToCompanyRoleCreateFormExpander;
use Spryker\Zed\CompanyGui\Communication\FormExpander\CompanyToCompanyRoleCreateFormExpanderInterface;
use Spryker\Zed\CompanyGui\Communication\FormExpander\CompanyToCompanyUnitAddressFormExpander;
use Spryker\Zed\CompanyGui\Communication\FormExpander\CompanyToCompanyUnitAddressFormExpanderInterface;
use Spryker\Zed\CompanyGui\Communication\FormExpander\CompanyToCustomerCompanyAttachFormExpander;
use Spryker\Zed\CompanyGui\Communication\FormExpander\CompanyToCustomerCompanyAttachFormExpanderInterface;
use Spryker\Zed\CompanyGui\Communication\Table\CompanyTable;
use Spryker\Zed\CompanyGui\Communication\Table\PluginExecutor\CompanyTablePluginExecutor;
use Spryker\Zed\CompanyGui\Communication\Table\PluginExecutor\CompanyTablePluginExecutorInterface;
use Spryker\Zed\CompanyGui\CompanyGuiDependencyProvider;
use Spryker\Zed\CompanyGui\Dependency\Facade\CompanyGuiToCompanyFacadeInterface;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormTypeInterface;

/**
 * @method \Spryker\Zed\CompanyGui\CompanyGuiConfig getConfig()
 */
class CompanyGuiCommunicationFactory extends AbstractCommunicationFactory
{
    public function createCompanyTable(): CompanyTable
    {
        return new CompanyTable(
            $this->getPropelCompanyQuery(),
            $this->createCompanyPluginExecutor(),
        );
    }

    protected function createCompanyPluginExecutor(): CompanyTablePluginExecutorInterface
    {
        return new CompanyTablePluginExecutor(
            $this->getCompanyTableConfigExpanderPlugins(),
            $this->getCompanyTableHeaderExpanderPlugins(),
            $this->getCompanyTableDataExpanderPlugins(),
            $this->getCompanyTableActionExpanderPlugins(),
        );
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer|array|null $data
     * @param array<string, mixed> $options
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    public function getCompanyForm($data = null, array $options = []): FormInterface
    {
        return $this->getFormFactory()->create(CompanyForm::class, $data, $options);
    }

    public function createCompanyFormDataProvider(): CompanyFormDataProvider
    {
        return new CompanyFormDataProvider(
            $this->getCompanyFacade(),
        );
    }

    public function createCompanyGuiFormatter(): CompanyGuiFormatterInterface
    {
        return new CompanyGuiFormatter($this->createCompanyNameFormatter());
    }

    public function createCompanyUserCompanyFormDataProvider(): CompanyUserCompanyFormDataProvider
    {
        return new CompanyUserCompanyFormDataProvider($this->getCompanyFacade());
    }

    public function createCompanyUserCompanyForm(): FormTypeInterface
    {
        return new CompanyUserCompanyForm();
    }

    public function createCompanyToCompanyUserFormDataProvider(): CompanyToCompanyUserFormDataProvider
    {
        return new CompanyToCompanyUserFormDataProvider($this->getCompanyFacade());
    }

    public function createCompanyToCompanyUserForm(): FormTypeInterface
    {
        return new CompanyToCompanyUserForm();
    }

    public function createCompanyFieldToCompanyUserFormExpander(): CompanyFieldToCompanyUserFormExpanderInterface
    {
        return new CompanyFieldToCompanyUserFormExpander(
            $this->createCompanyToCompanyUserForm(),
            $this->createCompanyToCompanyUserFormDataProvider(),
        );
    }

    public function createCompanyToCompanyBusinessUnitForm(): FormTypeInterface
    {
        return new CompanyToCompanyBusinessUnitForm();
    }

    public function createCompanyToCompanyBusinessUnitFormDataProvider(): CompanyToCompanyBusinessUnitFormDataProvider
    {
        return new CompanyToCompanyBusinessUnitFormDataProvider($this->getCompanyFacade());
    }

    public function createCompanyToCompanyBusinessUnitFormExpander(): CompanyToCompanyBusinessUnitFormExpanderInterface
    {
        return new CompanyToCompanyBusinessUnitFormExpander(
            $this->createCompanyToCompanyBusinessUnitForm(),
            $this->createCompanyToCompanyBusinessUnitFormDataProvider(),
        );
    }

    public function createCompanyToCompanyUnitAddressForm(): FormTypeInterface
    {
        return new CompanyToCompanyUnitAddressForm();
    }

    public function createCompanyToCompanyUnitAddressFormDataProvider(): CompanyToCompanyUnitAddressFormDataProvider
    {
        return new CompanyToCompanyUnitAddressFormDataProvider($this->getCompanyFacade());
    }

    public function createCompanyToCompanyUnitAddressFormExpander(): CompanyToCompanyUnitAddressFormExpanderInterface
    {
        return new CompanyToCompanyUnitAddressFormExpander(
            $this->createCompanyToCompanyUnitAddressForm(),
            $this->createCompanyToCompanyUnitAddressFormDataProvider(),
        );
    }

    public function createActivateCompanyForm(): FormInterface
    {
        return $this->getFormFactory()->create(ActivateCompanyForm::class);
    }

    public function createDeativateCompanyForm(): FormInterface
    {
        return $this->getFormFactory()->create(DeactivateCompanyForm::class);
    }

    public function createApproveCompanyForm(): FormInterface
    {
        return $this->getFormFactory()->create(ApproveCompanyForm::class);
    }

    public function createDenyCompanyForm(): FormInterface
    {
        return $this->getFormFactory()->create(DenyCompanyForm::class);
    }

    public function createCompanyToCompanyRoleCreateFormExpander(): CompanyToCompanyRoleCreateFormExpanderInterface
    {
        return new CompanyToCompanyRoleCreateFormExpander(
            $this->createCompanyToCompanyRoleCreateForm(),
            $this->createCompanyToCompanyRoleCreateFormDataProvider(),
        );
    }

    public function createCompanyToCompanyRoleCreateForm(): FormTypeInterface
    {
        return new CompanyToCompanyRoleCreateForm();
    }

    public function createCompanyToCompanyRoleCreateFormDataProvider(): CompanyToCompanyRoleCreateFormDataProvider
    {
        return new CompanyToCompanyRoleCreateFormDataProvider(
            $this->getCompanyFacade(),
            $this->createCompanyNameFormatter(),
        );
    }

    public function createCompanyNameFormatter(): CompanyNameFormatterInterface
    {
        return new CompanyNameFormatter();
    }

    public function getCompanyFacade(): CompanyGuiToCompanyFacadeInterface
    {
        return $this->getProvidedDependency(CompanyGuiDependencyProvider::FACADE_COMPANY);
    }

    public function createCompanyToCustomerCompanyAttachFormExpander(): CompanyToCustomerCompanyAttachFormExpanderInterface
    {
        return new CompanyToCustomerCompanyAttachFormExpander(
            $this->createCompanyToCustomerCompanyAttachForm(),
            $this->createCompanyToCustomerCompanyAttachFormDataProvider(),
        );
    }

    public function createCompanyToCustomerCompanyAttachFormDataProvider(): CompanyToCustomerCompanyAttachFormDataProvider
    {
        return new CompanyToCustomerCompanyAttachFormDataProvider($this->getCompanyFacade());
    }

    public function createCompanyToCustomerCompanyAttachForm(): FormTypeInterface
    {
        return new CompanyToCustomerCompanyAttachForm();
    }

    protected function getPropelCompanyQuery(): SpyCompanyQuery
    {
        return $this->getProvidedDependency(CompanyGuiDependencyProvider::PROPEL_COMPANY_QUERY);
    }

    /**
     * @return array<\Spryker\Zed\CompanyGuiExtension\Dependency\Plugin\CompanyTableConfigExpanderPluginInterface>
     */
    protected function getCompanyTableConfigExpanderPlugins(): array
    {
        return $this->getProvidedDependency(CompanyGuiDependencyProvider::PLUGINS_COMPANY_TABLE_CONFIG_EXPANDER);
    }

    /**
     * @return array<\Spryker\Zed\CompanyGuiExtension\Dependency\Plugin\CompanyTableHeaderExpanderPluginInterface>
     */
    protected function getCompanyTableHeaderExpanderPlugins(): array
    {
        return $this->getProvidedDependency(CompanyGuiDependencyProvider::PLUGINS_COMPANY_TABLE_HEADER_EXPANDER);
    }

    /**
     * @return array<\Spryker\Zed\CompanyGuiExtension\Dependency\Plugin\CompanyTableDataExpanderPluginInterface>
     */
    protected function getCompanyTableDataExpanderPlugins(): array
    {
        return $this->getProvidedDependency(CompanyGuiDependencyProvider::PLUGINS_COMPANY_TABLE_DATA_EXPANDER);
    }

    /**
     * @return array<\Spryker\Zed\CompanyGuiExtension\Dependency\Plugin\CompanyTableActionExpanderInterface>
     */
    protected function getCompanyTableActionExpanderPlugins(): array
    {
        return $this->getProvidedDependency(CompanyGuiDependencyProvider::PLUGINS_COMPANY_TABLE_ACTION_EXPANDER);
    }

    /**
     * @return array<\Spryker\Zed\CompanyGuiExtension\Dependency\Plugin\CompanyFormExpanderPluginInterface>
     */
    public function getCompanyFormPlugins(): array
    {
        return $this->getProvidedDependency(CompanyGuiDependencyProvider::PLUGINS_COMPANY_FORM_EXPANDER);
    }
}
