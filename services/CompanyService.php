<?php
declare(strict_types=1);

namespace app\services;

use app\dto\requests\CompanyCreateRequest;
use app\models\Company;
use app\models\User;
use app\repositories\interfaces\CompanyRepositoryInterface;
use app\services\interfaces\CompanyServiceInterface;
use Yii;

class CompanyService implements CompanyServiceInterface
{
    /**
     * CompanyService constructor.
     *
     * @param CompanyRepositoryInterface $companyRepository
     */
    public function __construct(public CompanyRepositoryInterface $companyRepository)
    {
    }

    /**
     * Get all companies associated with a user
     *
     * @param User $user User object or user ID
     * @return array
     */
    public function getUserCompanies(User $user): array
    {
        return $this->companyRepository->findByUser($user);
    }

    /**
     * Create a new company and associate it with a user
     *
     * @param int $userId
     * @param CompanyCreateRequest $request
     * @return Company
     * @throws \RuntimeException|\Throwable
     */
    public function createCompany(int $userId, CompanyCreateRequest $request): Company
    {
        return Yii::$app->db->transaction(function () use ($userId, $request) {
            $company = Company::create($request->title, $request->phone, $request->description);

            if (!$company->save()) {
                throw new \RuntimeException('Company validation failed');
            }

            /** @var User|null $user */
            $user = User::findOne($userId);
            if (empty($user)) {
                throw new \RuntimeException('User not found');
            }
            $user->link('companies', $company);

            return $company;
        });
    }

    /**
     * Get company by ID
     *
     * @param int $id
     * @return Company|null
     */
    public function getCompanyById(int $id): ?Company
    {
        return $this->companyRepository->findById($id);
    }
}
