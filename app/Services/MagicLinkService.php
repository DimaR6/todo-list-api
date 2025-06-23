<?php

namespace App\Services;

use App\Repositories\MagicLinkRepository;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class MagicLinkService
{
    private $magicLinkRepository;

    public function __construct(MagicLinkRepository $magicLinkRepository)
    {
        $this->magicLinkRepository = $magicLinkRepository;
    }

    /**
     * Create a new magic link.
     *
     * @param array $data
     * @return \App\Models\MagicLink
     */
    public function createMagicLink(array $data = [])
    {
        $hashData = $this->generate();

        return $this->magicLinkRepository->create(array_merge($hashData, $data));
    }

    private function generate(): array
    {
        $hash = Str::uuid()->toString();
        $expiresAt = Carbon::now()->addDays(7);

        return [
            'hash' => $hash,
            'expires_at' => $expiresAt,
            'is_active' => 1,
        ];
    }
}
