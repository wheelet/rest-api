<?php

declare(strict_types=1);

namespace app\controllers;

use yii\web\Controller;
use yii\helpers\Url;

/**
 * SwaggerController implements the Swagger UI functionality directly.
 */
final class SwaggerController extends Controller
{
    /**
     * @inheritdoc
     * @return array<string, mixed>
     */
    public function actions(): array
    {
        return [
            'index' => [
                'class' => 'yii2mod\swagger\SwaggerUIRenderer',
                'restUrl' => Url::to(['swagger/json-schema'], true),
                'view' => '@app/views/api/swagger/index',
            ],
            'json-schema' => [
                'class' => 'yii2mod\swagger\OpenAPIRenderer',
                'scanDir' => [
                    \Yii::getAlias('@app/controllers/api'),
                    \Yii::getAlias('@app/models'),
                ],
            ],
        ];
    }
}
