<?php

namespace app\controllers\api;

use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\rest\Controller;
use yii\web\Response;

/**
 * Base API Controller
 */
class BaseApiController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = [
            'contentNegotiator' => [
                'class' => ContentNegotiator::class,
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
            'verbFilter' => [
                'class' => VerbFilter::class,
                'actions' => $this->verbs(),
            ],
            'cors' => [
                'class' => Cors::class,
            ],
        ];

        if (defined('YII_ENV') && YII_ENV === 'test' || $this->skipAuthentication()) {
            return $behaviors;
        }

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
            'except' => $this->authExceptActions(),
        ];

        return $behaviors;
    }

    /**
     * Return actions that should be excluded from authentication
     * Override this method in child controllers to specify which actions don't require authentication
     *
     * @return array<string>
     */
    protected function authExceptActions(): array
    {
        return [];
    }

    /**
     * Determines if authentication should be skipped for this controller
     * Override this method in child controllers if needed
     *
     * @return bool
     */
    protected function skipAuthentication(): bool
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    protected function verbs()
    {
        return [];
    }

    /**
     * Creates a standardized success response
     *
     * @param mixed $data Response data
     * @param int $statusCode HTTP status code
     * @param string|null $message Success message
     * @return array<string, mixed> Formatted success response
     */
    protected function successResponse(mixed $data, int $statusCode = 200, ?string $message = null): array
    {
        Yii::$app->response->statusCode = $statusCode;
        $response = [
            'success' => true,
            'data' => $data
        ];

        if ($message !== null) {
            $response['message'] = $message;
        }

        return $response;
    }

    /**
     * Creates a standardized error response
     *
     * @param string $message Error message
     * @param array<string, mixed> $errors Detailed error messages
     * @param int $statusCode HTTP status code
     * @return array<string, mixed> Formatted error response
     */
    protected function errorResponse(string $message, array $errors = [], int $statusCode = 400): array
    {
        Yii::$app->response->statusCode = $statusCode;
        return [
            'success' => false,
            'message' => $message,
            'errors' => $errors
        ];
    }
}
