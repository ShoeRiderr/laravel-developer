<?php

namespace Database\Seeders;

use App\Models\Golfer;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class GolferSeeder extends Seeder
{
    public function run(): void
    {
        /**
         * @var Golfer|null
         */
        $lastGolfer = Golfer::orderBy('id', 'desc')->first();

        /**
         * @var int
         */
        $lastDebitorAccountNummer = $lastGolfer->debitor_account ?? 0;

        Golfer::factory()
            ->count(100)
            ->sequence(fn (Sequence $sequence) => ['debitor_account' => $lastDebitorAccountNummer + $sequence->index + 1])
            ->create();
    }
}
