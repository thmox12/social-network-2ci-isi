<?php
// app/Utils/ContentFormatter.php

namespace App\Utils;

class ContentFormatter
{
    /**
     * Format markdown-style content to HTML
     */
    public static function formatContent(string $content): string
    {
        $formattedContent = $content;
        
        // Convert markdown-style formatting to HTML
        // Handle section headers like "* **Title:**" but don't add extra colons
        $formattedContent = preg_replace('/\*\s\*\*([^*]+)\*\*:?/', '<br><strong>$1:</strong>', $formattedContent);
        
        // Convert **text** to bold
        $formattedContent = preg_replace('/\*\*([^*]+)\*\*/', '<strong>$1</strong>', $formattedContent);
        
        // Convert *text* to italic
        $formattedContent = preg_replace('/\*([^*]+)\*/', '<em>$1</em>', $formattedContent);
        
        // Format hashtags
        $formattedContent = preg_replace('/#(\w+)/', '<span class="inline-block bg-blue-100 text-blue-800 text-sm px-2 py-1 rounded mr-1">#$1</span>', $formattedContent);
        
        // Convert line breaks to proper paragraphs
        $formattedContent = nl2br($formattedContent);
        
        // Add spacing between sections
        $formattedContent = preg_replace('/(<br\s*\/?>){2,}/', '</p><p class="mt-4">', $formattedContent);
        
        // Wrap in paragraph tags
        $formattedContent = '<p>' . $formattedContent . '</p>';
        
        return $formattedContent;
    }

    /**
     * Get clean preview text without markdown formatting
     */
    public static function getPreviewText(string $content, int $limit = 200): string
    {
        // Remove markdown formatting
        $cleanContent = preg_replace([
            '/\*\s\*\*([^*]+)\*\*:?/',
            '/\*\*([^*]+)\*\*/',
            '/\*([^*]+)\*/',
            '/#(\w+)/'
        ], [
            '$1: ',
            '$1',
            '$1',
            '#$1'
        ], $content);
        
        // Remove extra whitespace and limit length
        $cleanContent = preg_replace('/\s+/', ' ', trim($cleanContent));
        
        return strlen($cleanContent) > $limit ? substr($cleanContent, 0, $limit) . '...' : $cleanContent;
    }

    /**
     * Extract hashtags from content
     */
    public static function extractHashtags(string $content): array
    {
        preg_match_all('/#(\w+)/', $content, $matches);
        return $matches[1] ?? [];
    }

    /**
     * Check if content appears to be AI generated (contains common AI formatting patterns)
     */
    public static function detectAIFormatting(string $content): bool
    {
        $aiPatterns = [
            '/\*\s\*\*[^*]+\*\*/',  // Section headers like "* **Title:**"
            '/\*\*[^*]+\*\*.*\*\*[^*]+\*\*/', // Multiple bold sections
            '/#\w+.*#\w+.*#\w+/' // Multiple hashtags
        ];
        
        foreach ($aiPatterns as $pattern) {
            if (preg_match($pattern, $content)) {
                return true;
            }
        }
        
        return false;
    }
}