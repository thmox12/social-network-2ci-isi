<?php
// app/Services/GeminiService.php

namespace App\Services;

use GeminiAPI\Client;
use GeminiAPI\Resources\Parts\TextPart;
use Exception;

class GeminiService
{
    private Client $client;

    public function __construct()
    {
        $apiKey = config('services.gemini.api_key');
        
        if (!$apiKey) {
            throw new Exception('Gemini API key is not configured. Please set GEMINI_API_KEY in your .env file.');
        }

        $this->client = new Client($apiKey);
    }

    public function generatePostContent(string $prompt): string
    {
        try {
            $enhancedPrompt = "Write a social media post about: {$prompt}. 

            Guidelines:
            - Make it engaging, conversational, and appropriate for sharing with friends
            - Keep it between 150-300 words
            - Use simple formatting: **bold** for emphasis and *italics* for style
            - Include relevant hashtags at the end
            - Write in a friendly, personal tone
            - Break content into short paragraphs for readability
            - Don't use excessive formatting or special characters
            
            Please write a clean, well-formatted social media post.";
            
            $response = $this->client->generativeModel('gemini-1.5-flash')
                ->generateContent(new TextPart($enhancedPrompt));
            
            return $response->text();
        } catch (Exception $e) {
            throw new Exception("Failed to generate content: " . $e->getMessage());
        }
    }
}