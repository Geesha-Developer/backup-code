<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Crypt;

class EncryptUrls
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $content = $response->getContent();

        $encryptedContent = $this->encryptUrls($content);

        $response->setContent($encryptedContent);

        return $response;
    }

    protected function encryptUrls($content)
    {
        return preg_replace_callback('/(href=["\'])([^"\']+)/', function ($matches) {
            return $matches[1] . encrypt($matches[2]);
        }, $content);
    }
}
