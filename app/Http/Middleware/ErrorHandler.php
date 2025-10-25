<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ErrorHandler
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $response = $next($request);
            
            // Log successful requests for monitoring (only for important routes)
            if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
                $this->logSuccessfulRequest($request, $response);
            }
            
            return $response;
        } catch (\Exception $e) {
            $this->logError($request, $e);
            
            // Return a user-friendly error response
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Internal server error',
                    'message' => 'An unexpected error occurred. Please try again later.',
                    'timestamp' => now()->toDateTimeString()
                ], 500);
            }
            
            // Try to show a custom error page, fallback to generic if not available
            try {
                return response()->view('errors.500', [
                    'error' => $e->getMessage(),
                    'timestamp' => now()->toDateTimeString()
                ], 500);
            } catch (\Exception $viewException) {
                // If view doesn't exist, return a simple HTML response
                return response('<h1>Internal Server Error</h1><p>An unexpected error occurred. Please try again later.</p>', 500);
            }
        }
    }

    /**
     * Log successful requests for monitoring
     */
    private function logSuccessfulRequest(Request $request, Response $response): void
    {
        $logData = [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'status_code' => $response->getStatusCode(),
            'user_agent' => $request->userAgent(),
            'ip' => $request->ip(),
            'timestamp' => now()->toDateTimeString()
        ];

        // Only log important routes to avoid log spam
        $importantRoutes = ['/raffles', '/payment', '/cart', '/api/'];
        $shouldLog = false;
        
        foreach ($importantRoutes as $route) {
            if (str_contains($request->path(), $route)) {
                $shouldLog = true;
                break;
            }
        }

        if ($shouldLog) {
            Log::info('Request processed successfully', $logData);
        }
    }

    /**
     * Log errors with detailed information
     */
    private function logError(Request $request, \Exception $e): void
    {
        $logData = [
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString(),
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'user_agent' => $request->userAgent(),
            'ip' => $request->ip(),
            'user_id' => auth()->id(),
            'timestamp' => now()->toDateTimeString()
        ];

        Log::error('Application error occurred', $logData);
    }
}
