<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MinifyHtml
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($this->isHtmlResponse($response)) {
            $content = $response->getContent();

            // Preserve <script>, <pre>, and <textarea> blocks by replacing them with placeholders
            $placeholders = [];
            $content = preg_replace_callback(
                '/(<(?:script|pre|textarea)[\s\S]*?<\/(?:script|pre|textarea)>)/i',
                function ($matches) use (&$placeholders) {
                    $placeholder = '___HTML_MINIFY_PLACEHOLDER_'.count($placeholders).'___';
                    $placeholders[$placeholder] = $matches[0];

                    return $placeholder;
                },
                $content
            );

            // Minify the rest of the HTML
            // 1. Remove comments
            $content = preg_replace('/<!--[\s\S]*?-->/', '', $content);
            // 2. Collapse all whitespaces/newlines to a single space
            $content = preg_replace('/\s+/u', ' ', $content);
            // 3. Remove spaces between tags
            $content = preg_replace('/>\s+</u', '><', $content);

            // Restore preserved blocks
            foreach ($placeholders as $placeholder => $originalContent) {
                $content = str_replace($placeholder, $originalContent, $content);
            }

            $response->setContent(trim($content));
        }

        return $response;
    }

    /**
     * Check if the response is an HTML response.
     */
    protected function isHtmlResponse(Response $response): bool
    {
        $contentType = $response->headers->get('Content-Type');

        return $contentType && str_contains($contentType, 'text/html');
    }
}
