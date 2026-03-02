<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CompanyGui\Dependency\Facade;

use Generated\Shared\Transfer\CompanyCollectionTransfer;
use Generated\Shared\Transfer\CompanyCriteriaFilterTransfer;
use Generated\Shared\Transfer\CompanyResponseTransfer;
use Generated\Shared\Transfer\CompanyTransfer;

class CompanyGuiToCompanyFacadeBridge implements CompanyGuiToCompanyFacadeInterface
{
    /**
     * @var \Spryker\Zed\Company\Business\CompanyFacadeInterface
     */
    protected $companyFacade;

    /**
     * @param \Spryker\Zed\Company\Business\CompanyFacadeInterface $companyFacade
     */
    public function __construct($companyFacade)
    {
        $this->companyFacade = $companyFacade;
    }

    public function update(CompanyTransfer $companyTransfer): CompanyResponseTransfer
    {
        return $this->companyFacade->update($companyTransfer);
    }

    public function getCompanyById(CompanyTransfer $companyTransfer): CompanyTransfer
    {
        return $this->companyFacade->getCompanyById($companyTransfer);
    }

    public function create(CompanyTransfer $companyTransfer): CompanyResponseTransfer
    {
        return $this->companyFacade->create($companyTransfer);
    }

    public function findCompanyById(int $idCompany): ?CompanyTransfer
    {
        return $this->companyFacade->findCompanyById($idCompany);
    }

    public function getCompanyCollection(CompanyCriteriaFilterTransfer $companyCriteriaFilterTransfer): CompanyCollectionTransfer
    {
        return $this->companyFacade->getCompanyCollection($companyCriteriaFilterTransfer);
    }
}
