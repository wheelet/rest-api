<?php

namespace app\services\interfaces;

use app\dto\requests\CompanyCreateRequest;
use app\models\Company;
use app\models\User;

interface CompanyServiceInterface
{
    /**
     * Get all companies associated with a user
     *
     * @param User $user
     * @return array
     */
    public function getUserCompanies(User $user): array;

    /**
     * Create a new company and associate it with a user
     *
     * @param int $userId
     * @param CompanyCreateRequest $request
     * @return Company|null
     */
    public function createCompany(int $userId, CompanyCreateRequest $request): ?Company;

    /**
     * Get company by ID
     *
     * @param int $id
     * @return Company|null
     */
    public function getCompanyById(int $id): ?Company;
}
