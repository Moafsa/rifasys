<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RateLimiter
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, int $maxAttempts = 60, int $decayMinutes = 1): Response
    {
        $key = $this->resolveRequestSignature($request);
        
        // Check if rate limit is exceeded
        if ($this->tooManyAttempts($key, $maxAttempts)) {
            $this->logRateLimitExceeded($request, $key);
            
            return $this->buildRateLimitResponse($request);
        }
        
        // Increment attempt counter
        $this->hit($key, $decayMinutes);
        
        $response = $next($request);
        
        // Add rate limit headers to response
        $this->addRateLimitHeaders($response, $key, $maxAttempts);
        
        return $response;
    }

    /**
     * Resolve request signature for rate limiting
     */
    protected function resolveRequestSignature(Request $request): string
    {
        // Use IP address and user ID if available
        $identifier = $request->ip();
        
        if ($request->user()) {
            $identifier .= '|' . $request->user()->id;
        }
        
        // Include route for more granular limiting
        $route = $request->route() ? $request->route()->getName() : $request->path();
        
        return 'rate_limit:' . md5($identifier . '|' . $route);
    }

    /**
     * Check if too many attempts have been made
     */
    protected function tooManyAttempts(string $key, int $maxAttempts): bool
    {
        $attempts = Cache::get($key, 0);
        return $attempts >= $maxAttempts;
    }

    /**
     * Increment attempt counter
     */
    protected function hit(string $key, int $decayMinutes): void
    {
        $attempts = Cache::get($key, 0);
        Cache::put($key, $attempts + 1, now()->addMinutes($decayMinutes));
    }

    /**
     * Log rate limit exceeded
     */
    protected function logRateLimitExceeded(Request $request, string $key): void
    {
        Log::warning('Rate limit exceeded', [
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'user_id' => $request->user()?->id,
            'key' => $key,
            'timestamp' => now()->toDateTimeString()
        ]);
    }

    /**
     * Build rate limit response
     */
    protected function buildRateLimitResponse(Request $request): Response
    {
        if ($request->expectsJson()) {
            return response()->json([
                'error' => 'Too Many Requests',
                'message' => 'Rate limit exceeded. Please try again later.',
                'retry_after' => 60,
                'timestamp' => now()->toDateTimeString()
            ], 429);
        }
        
        return response()->view('errors.429', [], 429);
    }

    /**
     * Add rate limit headers to response
     */
    protected function addRateLimitHeaders(Response $response, string $key, int $maxAttempts): void
    {
        $attempts = Cache::get($key, 0);
        $remaining = max(0, $maxAttempts - $attempts);
        
        $response->headers->set('X-RateLimit-Limit', $maxAttempts);
        $response->headers->set('X-RateLimit-Remaining', $remaining);
        $response->headers->set('X-RateLimit-Reset', now()->addMinutes(1)->timestamp);
    }
}
