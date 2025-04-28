<?php

/**
 * @SWG\Definition(
 *     definition="User",
 *     type="object",
 *     title="User Model",
 *     description="User model representation",
 *     @SWG\Property(property="id", type="integer", example=1),
 *     @SWG\Property(property="first_name", type="string", example="John"),
 *     @SWG\Property(property="last_name", type="string", example="Doe"),
 *     @SWG\Property(property="email", type="string", format="email", example="john@example.com"),
 *     @SWG\Property(property="phone", type="string", example="+1234567890"),
 *     @SWG\Property(property="created_at", type="string", format="date-time")
 * )
 */

/**
 * @SWG\Definition(
 *     definition="Company",
 *     type="object",
 *     title="Company Model",
 *     description="Company model representation",
 *     @SWG\Property(property="id", type="integer", example=1),
 *     @SWG\Property(property="title", type="string", example="Acme Corporation"),
 *     @SWG\Property(property="phone", type="string", example="+1234567890"),
 *     @SWG\Property(property="description", type="string", example="A global technology company"),
 *     @SWG\Property(property="created_at", type="string", format="date-time")
 * )
 */

/**
 * @SWG\Definition(
 *     definition="LoginRequest",
 *     type="object",
 *     required={"email", "password"},
 *     @SWG\Property(property="email", type="string", format="email", example="user@example.com"),
 *     @SWG\Property(property="password", type="string", format="password", example="password123")
 * )
 */

/**
 * @SWG\Definition(
 *     definition="LoginResponse",
 *     type="object",
 *     @SWG\Property(property="success", type="boolean", example=true),
 *     @SWG\Property(
 *         property="data", 
 *         type="object",
 *         @SWG\Property(property="token", type="string", example="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9..."),
 *         @SWG\Property(property="user", ref="#/definitions/User")
 *     )
 * )
 */

/**
 * @SWG\Definition(
 *     definition="RegisterRequest",
 *     type="object",
 *     required={"first_name", "last_name", "email", "password", "phone"},
 *     @SWG\Property(property="first_name", type="string", example="John"),
 *     @SWG\Property(property="last_name", type="string", example="Doe"),
 *     @SWG\Property(property="email", type="string", format="email", example="john@example.com"),
 *     @SWG\Property(property="password", type="string", format="password", example="password123"),
 *     @SWG\Property(property="phone", type="string", example="+1234567890")
 * )
 */

/**
 * @SWG\Definition(
 *     definition="RecoverPasswordRequest",
 *     type="object",
 *     required={"email"},
 *     @SWG\Property(property="email", type="string", format="email", example="john@example.com")
 * )
 */

/**
 * @SWG\Definition(
 *     definition="ResetPasswordRequest",
 *     type="object",
 *     required={"token", "password"},
 *     @SWG\Property(property="token", type="string"),
 *     @SWG\Property(property="password", type="string", format="password", example="newPassword123")
 * )
 */

/**
 * @SWG\Definition(
 *     definition="CreateCompanyRequest",
 *     type="object",
 *     required={"title", "phone"},
 *     @SWG\Property(property="title", type="string", example="Acme Corporation"),
 *     @SWG\Property(property="phone", type="string", example="+1234567890"),
 *     @SWG\Property(property="description", type="string", example="A global technology company")
 * )
 */

/**
 * @SWG\Definition(
 *     definition="SuccessResponse",
 *     type="object",
 *     @SWG\Property(property="success", type="boolean", example=true),
 *     @SWG\Property(property="data", type="object")
 * )
 */
