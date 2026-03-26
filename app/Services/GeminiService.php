<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeminiService
{
    public function generateStructuredRecommendation(array $payload): array
    {
        $baseUrl = config('services.gemini.base_url');
        $apiKey = config('services.gemini.key');
        $model = config('services.gemini.model');

        $prompt = "
You are a strict food compatibility analyzer in a meal recommendation application.

Analyze the dish using only the provided user preferences and dish ingredients.

Scoring rules:
- Start with a score of 100
- If any allergy ingredient is found in the dish, stop immediately and return score 0
- Subtract 30 for each dislikes_it ingredient found
- Subtract 15 for each not_preferred ingredient found
- Subtract 50 for each forbidden ingredient found
- Clamp the final score between 0 and 100

Instructions:
- Do not assume missing information
- Do not invent ingredients, conflicts, or explanations
- Return valid JSON only
- The response must strictly follow the required schema

warning_message rules:
- If there is a real conflict or warning, explain it briefly
- Otherwise return an empty string

Input data:
" . json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        $response = Http::withHeaders([
            'x-goog-api-key' => $apiKey,
            'Content-Type' => 'application/json',
        ])->post("{$baseUrl}/models/{$model}:generateContent", [
            'systemInstruction' => [
                'parts' => [
                    [
                        'text' => 'You must follow the provided scoring rules exactly and return only valid JSON matching the required schema.',
                    ],
                ],
            ],
            'contents' => [
                [
                    'parts' => [
                        [
                            'text' => $prompt,
                        ],
                    ],
                ],
            ],
            'generationConfig' => [
                'responseMimeType' => 'application/json',
                'responseJsonSchema' => [
                    'type' => 'object',
                    'additionalProperties' => false,
                    'properties' => [
                        'score' => [
                            'type' => 'integer',
                        ],
                        'warning_message' => [
                            'type' => 'string',
                        ],
                    ],
                    'required' => [
                        'score',
                        'warning_message',
                    ],
                ],
                'temperature' => 0,
            ],
        ]);

        if ($response->failed()) {
            return [
                'success' => false,
                'status' => $response->status(),
                'message' => 'Gemini request failed.',
                'body' => $response->json(),
            ];
        }

        $text = data_get($response->json(), 'candidates.0.content.parts.0.text');

        if (!$text) {
            return [
                'success' => false,
                'status' => $response->status(),
                'message' => 'No text content returned from Gemini.',
                'raw' => $response->json(),
            ];
        }

        $parsed = json_decode($text, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return [
                'success' => false,
                'status' => $response->status(),
                'message' => 'Invalid JSON returned by Gemini.',
                'text' => $text,
                'json_error' => json_last_error_msg(),
                'raw' => $response->json(),
            ];
        }

        return [
            'success' => true,
            'status' => $response->status(),
            'text' => $text,
            'parsed' => $parsed,
            'raw' => $response->json(),
        ];
    }
}