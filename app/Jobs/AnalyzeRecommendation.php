<?php

namespace App\Jobs;

use Throwable;
use App\Models\Plat;
use App\Models\User;
use App\Models\Recommendation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\PlatRecommendationService;

class AnalyzeRecommendation implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    public int $tries = 3;
    public int $timeout = 120;

    public function __construct(
        public int $recommendationId,
        public int $userId,
        public int $platId,
    ) {}

    public function handle(PlatRecommendationService $service): void
    {
        $recommendation = Recommendation::findOrFail($this->recommendationId);
        $user = User::findOrFail($this->userId);
        $plat = Plat::findOrFail($this->platId);

        $result = $service->analyze($user, $plat);

        $recommendation->update([
            'status' => 'ready',
            'score' => $result['parsed']['score'],
            'warning_message' => $result['parsed']['reason']
        ]);
    }

    public function failed(?Throwable $exception): void
    {
        $recommendation = Recommendation::find($this->recommendationId);

        if ($recommendation) {
            $recommendation->update([
                'status' => 'failed',
                'error' => $exception?->getMessage(),
            ]);
        }
    }
}