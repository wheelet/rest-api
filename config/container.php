<?php

use app\repositories\CompanyRepository;
use app\repositories\interfaces\CompanyRepositoryInterface;
use app\repositories\interfaces\UserRepositoryInterface;
use app\repositories\UserRepository;
use app\services\AuthService;
use app\services\CompanyService;
use app\services\interfaces\AuthServiceInterface;
use app\services\interfaces\CompanyServiceInterface;
use app\services\interfaces\UserServiceInterface;
use app\services\UserService;

return [
    'definitions' => [
        // Repositories
        UserRepositoryInterface::class => UserRepository::class,
        CompanyRepositoryInterface::class => CompanyRepository::class,

        // Services
        UserServiceInterface::class => UserService::class,
        CompanyServiceInterface::class => CompanyService::class,
        AuthServiceInterface::class => AuthService::class,
    ],
];
