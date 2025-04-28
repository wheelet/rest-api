<?php

declare(strict_types=1);

namespace app\repositories;

use app\models\Company;
use app\models\User;
use app\repositories\interfaces\CompanyRepositoryInterface;
use yii\db\Exception;

class CompanyRepository implements CompanyRepositoryInterface
{
    /**
     * Find a company by ID
     *
     * @param int $id
     * @return Company|null
     */
    public function findById(int $id): ?Company
    {
        return Company::findOne($id);
    }

    /**
     * Find all companies associated with a user
     *
     * @param User $user
     * @return array
     */
    public function findByUser(User $user): array
    {
        return $user->getCompanies()->all();
    }

    /**
     * Save company model
     *
     * @param Company $company
     * @return bool
     * @throws Exception
     */
    public function save(Company $company): bool
    {
        return $company->save();
    }
}
