<?php

namespace App\Routes;

use App\Controllers\AuthController;
use App\Controllers\ImageController;
use App\Middleware\AuthMiddleware;
use App\Middleware\AdminMiddleware;
use App\Services\ResponseService;
use Exception;

/**
 * Route Dispatcher
 * 
 * Central routing system for the application
 */
class RouteDispatcher
{
    private $uri;
    private $method;
    private $routes = [];
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->uri = $this->getUri();
        $this->method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $this->registerRoutes();
    }
    
    /**
     * Register all application routes
     * 
     * @return void
     */
    private function registerRoutes()
    {
        // Auth routes
        $this->addRoute('POST', '/api/auth/login', [AuthController::class, 'login']);
        $this->addRoute('POST', '/api/auth/signup', [AuthController::class, 'signup']);
        $this->addRoute('POST', '/api/auth/logout', [AuthController::class, 'logout'], [AuthMiddleware::class]);
        $this->addRoute('POST', '/api/auth/verify', [AuthController::class, 'verifyAccount']);
        $this->addRoute('POST', '/api/auth/refresh-token', [AuthController::class, 'refreshToken']);
        
        // Admin routes
        $this->addRoute('POST', '/api/admin/login', 'AdminLogin::login');
        $this->addRoute('POST', '/api/admin/signup', 'AdminSignup::signup', [AdminMiddleware::class]);
        
        // Image routes
        $this->addRoute('POST', '/api/images/upload', [ImageController::class, 'uploadImage'], [AuthMiddleware::class]);
        $this->addRoute('GET', '/api/images/([a-zA-Z0-9_\-\.]+)', [ImageController::class, 'getImage']);
        $this->addRoute('GET', '/api/images', [ImageController::class, 'getAllImages']);
        $this->addRoute('DELETE', '/api/images/([a-zA-Z0-9_\-\.]+)', [ImageController::class, 'deleteImage'], [AuthMiddleware::class]);
        
        // Example routes for testing JSON/XML responses
        $this->addRoute('GET', '/api/example/user', ['App\Controllers\ExampleController', 'getUser']);
        $this->addRoute('GET', '/api/example/users', ['App\Controllers\ExampleController', 'getAllUsers']);
        $this->addRoute('POST', '/api/example/process', ['App\Controllers\ExampleController', 'processData']);
        
        // Test endpoint to verify JSON/XML output
        $this->addRoute('GET', '/api/test', 'Examples\TestOutput::test');
        
        // Database test endpoints
        $this->addRoute('GET', '/api/db/status', 'Examples\DatabaseTest::getStatus');
        $this->addRoute('GET', '/api/db/users', 'Examples\DatabaseTest::getUsers');
        $this->addRoute('GET', '/api/db/products', 'Examples\DatabaseTest::getProducts');
        $this->addRoute('GET', '/api/db/orders', 'Examples\DatabaseTest::getOrders');
        $this->addRoute('GET', '/api/db/settings', 'Examples\DatabaseTest::getSettings');
        
        // API Documentation
        $this->addRoute('GET', '/api/docs', function() {
            header('Location: /api/docs/');
            exit;
        });
    }
    
    /**
     * Add a route to the routes array
     * 
     * @param string $method
     * @param string $pattern
     * @param mixed $handler
     * @param array $middleware
     * @return void
     */
    private function addRoute($method, $pattern, $handler, $middleware = [])
    {
        $this->routes[] = [
            'method' => $method,
            'pattern' => $pattern,
            'handler' => $handler,
            'middleware' => $middleware
        ];
    }
    
    /**
     * Dispatch the request to the appropriate handler
     * 
     * @return void
     */
    public function dispatch()
    {
        // Handle API request
        if (strpos($this->uri, '/api/') === 0) {
            // Set proper headers for API responses
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
            header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
            
            // Let the ResponseService handle the specific content type based on the response format
            
            foreach ($this->routes as $route) {
                if ($this->method !== $route['method']) {
                    continue;
                }
                
                $pattern = '#^' . $route['pattern'] . '$#';
                
                if (preg_match($pattern, $this->uri, $matches)) {
                    // Remove the full match from the matches array
                    array_shift($matches);
                    
                    // Apply middleware
                    foreach ($route['middleware'] as $middlewareClass) {
                        $middleware = new $middlewareClass();
                        if (!$middleware->handle()) {
                            return; // Middleware rejected the request
                        }
                    }
                    
                    try {
                        // Call the route handler
                        if (is_callable($route['handler'])) {
                            call_user_func_array($route['handler'], $matches);
                            return;
                        } elseif (is_array($route['handler']) && count($route['handler']) === 2) {
                            $controller = new $route['handler'][0]();
                            $method = $route['handler'][1];
                            call_user_func_array([$controller, $method], $matches);
                            return;
                        } elseif (is_string($route['handler']) && strpos($route['handler'], '::') !== false) {
                            list($class, $method) = explode('::', $route['handler'], 2);
                            // Check if the class already has a namespace
                            if (strpos($class, '\\') === false) {
                                $class = 'App\\Api\\' . $class;
                            }
                            call_user_func_array([$class, $method], $matches);
                            return;
                        }
                    } catch (Exception $e) {
                        $this->sendJsonError($e->getMessage(), 500);
                        return;
                    }
                }
            }
            
            // If we reach here, no route matched
            $this->sendJsonError('Route not found', 404);
        }
        
        // Non-API routes or static HTML content is handled by the HTML part of index.php
    }
    
    /**
     * Get the current URI
     * 
     * @return string
     */
    private function getUri()
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        
        // Remove query string from URI if present
        if (strpos($uri, '?') !== false) {
            $uri = strstr($uri, '?', true);
        }
        
        // Remove trailing slash if not root
        if ($uri !== '/' && substr($uri, -1) === '/') {
            $uri = rtrim($uri, '/');
        }
        
        // Get the path relative to the base directory
        $basePath = dirname($_SERVER['SCRIPT_NAME']);
        if ($basePath !== '/' && $basePath !== '\\') {
            $uri = substr($uri, strlen($basePath));
        }
        
        return $uri ?: '/';
    }
    
    /**
     * Send JSON error response
     * 
     * @param string $message
     * @param int $statusCode
     * @return void
     */
    private function sendJsonError($message, $statusCode = 400)
    {
        ResponseService::send([
            'status' => 'error',
            'message' => $message
        ], $statusCode);
    }
    
    /**
     * Log error to file
     * 
     * @param string $message
     * @param Exception|null $exception
     * @return void
     */
    private function logError($message, $exception = null)
    {
        $logFile = __DIR__ . '/../logs/error.log';
        $date = date('Y-m-d H:i:s');
        $logMessage = "[$date] $message";
        
        if ($exception) {
            $logMessage .= ' - ' . $exception->getMessage() . 
                ' in ' . $exception->getFile() . 
                ' on line ' . $exception->getLine();
        }
        
        $logMessage .= PHP_EOL;
        file_put_contents($logFile, $logMessage, FILE_APPEND);
    }
} 