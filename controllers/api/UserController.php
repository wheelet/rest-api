<?php

declare(strict_types=1);

namespace app\controllers\api;

use app\dto\requests\PasswordRecoverRequest;
use app\dto\requests\UserLoginRequest;
use app\dto\requests\UserRegisterRequest;
use app\forms\PasswordRecoverForm;
use app\forms\UserLoginForm;
use app\forms\UserRegisterForm;
use app\services\interfaces\UserServiceInterface;
use Yii;

/**
 * UserController implements the API actions for User model.
 *
 * @SWG\Tag(
 *     name="User",
 *     description="Operations related to user management"
 * )
 */
final class UserController extends BaseApiController
{
    /**
     * UserController constructor.
     *
     * @param string $id
     * @param \yii\base\Module $module
     * @param UserServiceInterface $userService
     * @param array<string, mixed> $config
     */
    public function __construct(
        string $id,
        $module,
        private UserServiceInterface $userService,
        array $config = []
    ) {
        $this->userService = $userService;
        parent::__construct($id, $module, $config);
    }

    /**
     * @inheritdoc
     */
    protected function authExceptActions(): array
    {
        return ['register', 'sign-in', 'recover-password'];
    }

    /**
     * @inheritdoc
     */
    protected function verbs(): array
    {
        return [
            'register' => ['POST'],
            'sign-in' => ['POST'],
            'recover-password' => ['POST', 'PATCH'],
        ];
    }

    /**
     * Register a new user
     *
     * @return array<string, mixed>
     *
     * @SWG\Post(
     *     path="/api/user/register",
     *     summary="Register a new user",
     *     description="Creates a new user account with the provided information",
     *     operationId="registerUser",
     *     tags={"User"},
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         required=true,
     *         description="User registration information",
     *         @SWG\Schema(ref="#/definitions/RegisterRequest")
     *     ),
     *     @SWG\Response(
     *         response=201,
     *         description="User registered successfully",
     *         @SWG\Schema(
     *             type="object",
     *             @SWG\Property(property="success", type="boolean", example=true),
     *             @SWG\Property(
     *                 property="data",
     *                 type="object",
     *                 ref="#/definitions/User"
     *             )
     *         )
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="Invalid input or email already in use",
     *         @SWG\Schema(ref="#/definitions/ErrorResponse")
     *     )
     * )
     */
    public function actionRegister(): array
    {
        try {
            $request = Yii::$app->request->getBodyParams();
            $form = new UserRegisterForm();

            if (!$form->load($request, '') || !$form->validate()) {
                Yii::error('Registration validation failed', __METHOD__);
                return $this->errorResponse('Invalid input', $form->getErrors(), 400);
            }

            $requestDto = new UserRegisterRequest($form);
            $user = $this->userService->register($requestDto);

            if (!$user) {
                Yii::error('User registration failed', __METHOD__);
                return $this->errorResponse('Registration failed', [], 400);
            }

            Yii::info('User registered successfully: ' . $user->id, __METHOD__);
            return $this->successResponse(['data' => $user], 201);
        } catch (\Exception $e) {
            Yii::error('Error during registration: ' . $e->getMessage(), __METHOD__);
            return $this->errorResponse('An error occurred', [], 500);
        }
    }

    /**
     * Sign in a user
     *
     * @return array<string, mixed>
     *
     * @SWG\Post(
     *     path="/api/user/sign-in",
     *     summary="Authenticate user and get access token",
     *     description="Validates user credentials and returns a JWT token for API access",
     *     operationId="loginUser",
     *     tags={"User"},
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         required=true,
     *         description="User credentials",
     *         @SWG\Schema(ref="#/definitions/LoginRequest")
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful authentication",
     *         @SWG\Schema(ref="#/definitions/LoginResponse")
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Invalid credentials",
     *         @SWG\Schema(ref="#/definitions/ErrorResponse")
     *     )
     * )
     */
    public function actionSignIn(): array
    {
        try {
            $request = Yii::$app->request->getBodyParams();
            $form = new UserLoginForm();

            if (!$form->load($request, '') || !$form->validate()) {
                Yii::error('Login validation failed', __METHOD__);
                return $this->errorResponse('Invalid credentials', $form->getErrors(), 401);
            }

            $requestDto = new UserLoginRequest($form);
            $tokenData = $this->userService->login($requestDto);

            if (!$tokenData) {
                Yii::error('Login failed', __METHOD__);
                return $this->errorResponse('Invalid credentials', [], 401);
            }

            Yii::info('User logged in successfully: ' . $form->email, __METHOD__);
            return $this->successResponse($tokenData, 200);
        } catch (\Exception $e) {
            Yii::error('Error during login: ' . $e->getMessage(), __METHOD__);
            return $this->errorResponse('An error occurred', [], 500);
        }
    }

    /**
     * Request password recovery or reset password with token
     *
     * @return array<string, mixed>
     *
     * @SWG\Post(
     *     path="/api/user/recover-password",
     *     summary="Request password recovery",
     *     description="Sends a password recovery token to the user's email",
     *     operationId="requestPasswordRecovery",
     *     tags={"User"},
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         required=true,
     *         description="Email for password recovery",
     *         @SWG\Schema(ref="#/definitions/RecoverPasswordRequest")
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Recovery email sent successfully",
     *         @SWG\Schema(
     *             type="object",
     *             @SWG\Property(property="success", type="boolean", example=true),
     *             @SWG\Property(property="message", type="string", example="Password reset link has been sent to your email")
     *         )
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="Invalid email",
     *         @SWG\Schema(ref="#/definitions/ErrorResponse")
     *     )
     * )
     *
     * @SWG\Patch(
     *     path="/api/user/recover-password",
     *     summary="Reset password with token",
     *     description="Resets user password using a valid recovery token",
     *     operationId="resetPassword",
     *     tags={"User"},
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         required=true,
     *         description="Password reset information",
     *         @SWG\Schema(ref="#/definitions/ResetPasswordRequest")
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Password reset successful",
     *         @SWG\Schema(
     *             type="object",
     *             @SWG\Property(property="success", type="boolean", example=true),
     *             @SWG\Property(property="message", type="string", example="Password has been reset successfully")
     *         )
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="Invalid or expired token",
     *         @SWG\Schema(ref="#/definitions/ErrorResponse")
     *     )
     * )
     */
    public function actionRecoverPassword(): array
    {
        try {
            $request = Yii::$app->request->getBodyParams();
            $form = new PasswordRecoverForm();

            if (!$form->load($request, '') || !$form->validate()) {
                Yii::error('Password recovery validation failed', __METHOD__);
                return $this->errorResponse('Invalid email', $form->getErrors(), 400);
            }

            $requestDto = new PasswordRecoverRequest($form);

            if (!$this->userService->requestPasswordReset($requestDto)) {
                Yii::error('Password recovery failed', __METHOD__);
                return $this->errorResponse('Password recovery failed', [], 400);
            }

            Yii::info('Password recovery email sent: ' . $form->email, __METHOD__);
            return $this->successResponse(['message' => 'Password reset link has been sent to your email'], 200);
        } catch (\Exception $e) {
            Yii::error('Error during password recovery: ' . $e->getMessage(), __METHOD__);
            return $this->errorResponse('An error occurred', [], 500);
        }
    }
}
