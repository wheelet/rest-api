<?php

declare(strict_types=1);

namespace app\controllers\api;

use app\dto\requests\CompanyCreateRequest;
use app\forms\CompanyCreateForm;
use app\services\interfaces\CompanyServiceInterface;
use Yii;

/**
 * CompanyController implements the API actions for Company model.
 *
 * @SWG\Tag(
 *     name="Companies",
 *     description="Operations related to company management"
 * )
 */
final class CompanyController extends BaseApiController
{
    /**
     * @var CompanyServiceInterface
     */
    private CompanyServiceInterface $companyService;

    /**
     * CompanyController constructor.
     *
     * @param string $id
     * @param \yii\base\Module $module
     * @param CompanyServiceInterface $companyService
     * @param array<string, mixed> $config
     */
    public function __construct(
        string $id,
        $module,
        CompanyServiceInterface $companyService,
        array $config = []
    ) {
        $this->companyService = $companyService;
        parent::__construct($id, $module, $config);
    }

    /**
     * @inheritdoc
     */
    protected function verbs(): array
    {
        return [
            'index' => ['GET'],
            'create' => ['POST'],
        ];
    }

    /**
     * List user's companies
     *
     * @return array<string, mixed>
     *
     * @SWG\Get(
     *     path="/api/user/companies",
     *     summary="List all companies associated with authenticated user",
     *     description="Returns a list of companies that the current user is associated with",
     *     operationId="listUserCompanies",
     *     tags={"Companies"},
     *     security={{"bearerAuth": {}}},
     *     @SWG\Response(
     *         response=200,
     *         description="List of companies",
     *         @SWG\Schema(
     *             type="object",
     *             @SWG\Property(property="success", type="boolean", example=true),
     *             @SWG\Property(
     *                 property="data",
     *                 type="array",
     *                 @SWG\Items(ref="#/definitions/Company")
     *             )
     *         )
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Unauthorized - JWT token invalid or expired",
     *         @SWG\Schema(ref="#/definitions/ErrorResponse")
     *     )
     * )
     */
    public function actionIndex(): array
    {
        $user = Yii::$app->user->identity;
        $companies = $this->companyService->getUserCompanies($user);

        return $this->successResponse($companies);
    }

    /**
     * Create a new company for the user
     *
     * @return array<string, mixed>
     *
     * @SWG\Post(
     *     path="/api/user/companies",
     *     summary="Create a new company",
     *     description="Creates a new company and associates it with the authenticated user",
     *     operationId="createCompany",
     *     tags={"Companies"},
     *     security={{"bearerAuth":{}}},
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         required=true,
     *         description="Company creation information",
     *         @SWG\Schema(ref="#/definitions/CreateCompanyRequest")
     *     ),
     *     @SWG\Response(
     *         response=201,
     *         description="Company created successfully",
     *         @SWG\Schema(
     *             type="object",
     *             @SWG\Property(property="success", type="boolean", example=true),
     *             @SWG\Property(
     *                 property="data",
     *                 type="object",
     *                 ref="#/definitions/Company"
     *             )
     *         )
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="Invalid input",
     *         @SWG\Schema(ref="#/definitions/ErrorResponse")
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Unauthorized - JWT token invalid or expired",
     *         @SWG\Schema(ref="#/definitions/ErrorResponse")
     *     )
     * )
     */
    public function actionCreate(): array
    {
        $form = new CompanyCreateForm();
        if (!$form->load(Yii::$app->request->post(), '') || !$form->validate()) {
            return $this->errorResponse(
                'Missing or invalid required fields',
                $form->getErrors()
            );
        }

        $requestDto = new CompanyCreateRequest($form);
        $userId = Yii::$app->user->identity->id;

        $company = $this->companyService->createCompany($userId, $requestDto);

        if (empty($company)) {
            return $this->errorResponse('Failed to create company', [], 400);
        }

        return $this->successResponse($company, 201);
    }
}
