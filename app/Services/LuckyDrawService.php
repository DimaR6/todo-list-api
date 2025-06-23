<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Repositories\LuckyDrawRepository;

class LuckyDrawService
{

    /** @var LuckyDrawRepository $luckyDrawRepository*/
    private $luckyDrawRepository;

    public function __construct(LuckyDrawRepository $luckyDrawRepo)
    {
        $this->luckyDrawRepository = $luckyDrawRepo;
    }

    private function roll(): array
    {
        $user = Auth::user();

        $number = rand(1, 1000);
        $isEven = $number % 2 === 0;
        $result = $isEven ? 'Win' : 'Lose';

        $winAmount = 0;
        if ($result === 'Win') {
            if ($number > 900) {
                $winAmount = $number * 0.7;
            } elseif ($number > 600) {
                $winAmount = $number * 0.5;
            } elseif ($number > 300) {
                $winAmount = $number * 0.3;
            } else {
                $winAmount = $number * 0.1;
            }
        }

        return [
            'random_number' => $number,
            'result' => $result,
            'win_amount' => round($winAmount, 2),
            'user_id' => $user->id,
        ];
    }

    public function makeRoll()
    {
        return $this->luckyDrawRepository->create(
            $this->roll()
        );
    }
}
