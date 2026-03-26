<?php

namespace App\Services;

use App\Models\Plat;
use App\Models\User;

class PlatRecommendationService
{
    public function __construct(
        protected GeminiService $geminiService
    ) {
    }

    public function analyze(User $user, Plat $plat): array
    {
        $plat->loadMissing('ingredients');
        $user->loadMissing('preferences');

        $payload = $this->buildPayload($user, $plat);

        return $this->geminiService->generateStructuredRecommendation($payload);
    }

    protected function buildPayload(User $user, Plat $plat): array
    {
        $preferences = $user->preferences;

        $allergies = [];
        $disliked = [];
        $notPreferred = [];
        $forbidden = [];

        foreach ($preferences as $preference) {
            $ingredientName = $this->normalizeText($preference->ingredient);

            if ($ingredientName === '') {
                continue;
            }

            switch ($preference->type) {
                case 'allergic_to_it':
                    $allergies[] = $ingredientName;
                    break;

                case 'dislikes_it':
                    $disliked[] = $ingredientName;
                    break;

                case 'Not_preferred':
                    $notPreferred[] = $ingredientName;
                    break;

                case 'forbidden':
                    $forbidden[] = $ingredientName;
                    break;

                case 'likes_it':
                    break;
            }
        }

        $dishIngredients = $plat->ingredients
            ->pluck('name')
            ->map(fn ($name) => $this->normalizeText($name))
            ->filter()
            ->values()
            ->all();

        return [
            'user_preferences' => [
                'allergies' => array_values(array_unique($allergies)),
                'disliked' => array_values(array_unique($disliked)),
                'not_preferred' => array_values(array_unique($notPreferred)),
                'forbidden' => array_values(array_unique($forbidden)),
            ],
            'dish' => [
                'name' => $plat->name,
                'ingredients' => $dishIngredients,
            ],
        ];
    }

    protected function normalizeText(?string $text): string
    {
        $text = trim((string) $text);
        $text = mb_strtolower($text);
        $text = preg_replace('/\s+/', ' ', $text);
        
        return $text;
    }
}