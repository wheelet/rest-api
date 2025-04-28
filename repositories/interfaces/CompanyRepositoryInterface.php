<?php

namespace app\repositories\interfaces;

use app\models\Company;
use app\models\User;

interface CompanyRepositoryInterface
{
    /**
     * Find a company by ID
     *
     * @param int $id
     * @return Company|null
     */
    public function findById(int $id): ?Company;

    /**
     * Find all companies associated with a user
     *
     * @param User $user
     * @return array
     */
    public function findByUser(User $user): array;

    /**
     * Save company model
     *
     * @param Company $company
     * @return bool
     */
    public function save(Company $company): bool;
}
