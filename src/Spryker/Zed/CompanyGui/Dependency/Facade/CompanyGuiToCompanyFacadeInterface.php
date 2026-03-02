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

interface CompanyGuiToCompanyFacadeInterface
{
    public function update(CompanyTransfer $companyTransfer): CompanyResponseTransfer;

    public function getCompanyById(CompanyTransfer $companyTransfer): CompanyTransfer;

    public function create(CompanyTransfer $companyTransfer): CompanyResponseTransfer;

    public function findCompanyById(int $idCompany): ?CompanyTransfer;

    public function getCompanyCollection(CompanyCriteriaFilterTransfer $companyCriteriaFilterTransfer): CompanyCollectionTransfer;
}
