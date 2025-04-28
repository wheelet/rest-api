<?php

use app\models\Company;
use app\models\User;
use app\models\UserCompany;
use yii\db\Migration;
use Faker\Factory;

/**
 * Class m230101_000004_seed_test_data
 */
class m230101_000004_seed_test_data extends Migration
{
    /**
     * {@inheritdoc}
     * @throws \yii\db\Exception
     * @throws \yii\base\Exception
     */
    public function safeUp()
    {
        $faker = Factory::create();
        $faker->seed(1234);


        $userIds = [];
        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $user->first_name = $faker->firstName();
            $user->last_name = $faker->lastName();
            $user->email = $faker->email();
            $user->phone = $faker->phoneNumber();
            $user->setPassword('password123');
            $user->generateAuthKey();
            $user->status = User::STATUS_ACTIVE;
            $user->save();

            $userIds[] = $user->id;
        }

        $companyIds = [];
        for ($i = 0; $i < 8; $i++) {
            $company = new Company();
            $company->title = $faker->company();
            $company->phone = $faker->phoneNumber();
            $company->description = $faker->paragraph(2);
            $company->save();

            $companyIds[] = $company->id;
        }

        $createdAssociations = [];

        foreach ($userIds as $userId) {
            $numCompanies = $faker->numberBetween(1, 3);

            $selectedCompanies = $faker->randomElements($companyIds, $numCompanies);

            foreach ($selectedCompanies as $companyId) {
                $key = $userId . '-' . $companyId;

                if (!isset($createdAssociations[$key])) {
                    $userCompany = new UserCompany();
                    $userCompany->user_id = $userId;
                    $userCompany->company_id = $companyId;
                    $userCompany->save();

                    $createdAssociations[$key] = true;
                }
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%user_company}}');
        $this->delete('{{%company}}');
        $this->delete('{{%user}}');
    }
}
