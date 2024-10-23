<?php

declare(strict_types=1);

use App\App\Handler\CustomErrorHandler;
use Slim\Factory\AppFactory;
use Slim\CallableResolver;
use Slim\Psr7\Factory\ResponseFactory;

require_once __DIR__ . '/../../vendor/autoload.php';
const BASE_DIR = __DIR__ . '/../../';

require_once __DIR__ . '/ErrorHandler.php';

$app = AppFactory::create();
$app->addBodyParsingMiddleware(); // Add middleware for parsing request body

// Register routes
(require_once __DIR__ . '/Routes.php')($app);

// Create CallableResolver
$callableResolver = new CallableResolver($app->getContainer());

// Create CustomErrorHandler
$responseFactory = new ResponseFactory();
$customErrorHandler = new CustomErrorHandler($callableResolver, $responseFactory);

// Add Error Middleware
$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$errorMiddleware->setDefaultErrorHandler($customErrorHandler);

$app->run();