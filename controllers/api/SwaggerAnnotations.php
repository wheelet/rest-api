<?php

declare(strict_types=1);

namespace app\controllers\api;

/**
 * @SWG\Swagger(
 *     basePath="/",
 *     host="localhost:8080",
 *     schemes={"http"},
 *     @SWG\Info(
 *         version="1.0",
 *         title="Company API",
 *         description="RESTful API для управління компаніями",
 *         termsOfService="",
 *         @SWG\Contact(name="API Support", email="support@example.com"),
 *         @SWG\License(name="MIT", url="https://github.com/swagger-api/swagger-spec/blob/master/LICENSE")
 *     ),
 *     @SWG\ExternalDocumentation(
 *         description="Знайдіть більше інформації тут",
 *         url="https://swagger.io/about"
 *     )
 * )
 *
 * @SWG\SecurityScheme(
 *     securityDefinition="bearerAuth",
 *     type="apiKey",
 *     name="Authorization",
 *     in="header",
 *     description="JWT Authorization header using the Bearer scheme. Example: 'Bearer {token}'"
 * )
 *
 * @SWG\Definition(
 *     definition="ErrorResponse",
 *     required={"status", "message"},
 *     @SWG\Property(property="status", type="string", description="Status of the response", example="error"),
 *     @SWG\Property(property="message", type="string", description="Error message", example="Invalid input")
 * )
 *
 * @SWG\Definition(
 *     definition="CompanyModel",
 *     required={"name", "description"},
 *     @SWG\Property(property="id", type="integer", description="Unique company ID", example=1),
 *     @SWG\Property(property="name", type="string", description="Company name", example="Acme Inc."),
 *     @SWG\Property(property="description", type="string", description="Company description", example="A company that makes everything"),
 *     @SWG\Property(property="created_at", type="string", format="date-time", description="Creation date", example="2025-04-27T19:46:34+00:00"),
 *     @SWG\Property(property="updated_at", type="string", format="date-time", description="Last update date", example="2025-04-27T19:46:34+00:00")
 * )
 *
 * @SWG\Definition(
 *     definition="UserModel",
 *     required={"username", "email"},
 *     @SWG\Property(property="id", type="integer", description="Unique user ID", example=1),
 *     @SWG\Property(property="username", type="string", description="Username", example="john_doe"),
 *     @SWG\Property(property="email", type="string", description="Email address", example="john@example.com"),
 *     @SWG\Property(property="created_at", type="string", format="date-time", description="Registration date", example="2025-04-27T19:46:34+00:00")
 * )
 */
/**
 * Class for Swagger API documentation annotations
 *
 * @codeCoverageIgnore
 */
final class SwaggerAnnotations
{
}
