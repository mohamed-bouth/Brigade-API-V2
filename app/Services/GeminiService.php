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

reason rules:
- If any allergy, forbidden, disliked, or not_preferred ingredient is found in the dish, reason must be a short factual sentence mentioning only the matching ingredients.
- If no matching ingredient is found, reason must be a message saying the dish is very recommended because he contain no conflit
- Do not add general advice.
- Do not mention ingredients that are not present in the input.

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
                            'minimum' => 0,
                            'maximum' => 100,
                            'description' => 'Compatibility score from 0 to 100 based strictly on the provided scoring rules.',
                        ],
                        'reason' => [
                            'type' => 'string',
                            'description' => 'Return a short factual explanation only when dish ingredients conflict with allergies, dislikes, not_preferred, or forbidden ingredients. Otherwise return an empty string.',
                        ],
                    ],
                    'required' => ['score', 'reason'],
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