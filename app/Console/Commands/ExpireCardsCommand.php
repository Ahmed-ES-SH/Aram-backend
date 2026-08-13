<?php

namespace App\Console\Commands;

use App\Modules\Card\Models\OwnedCard;
use Illuminate\Console\Command;

class ExpireCardsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:expire-cards-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'تحديث حالة البطاقات المنتهية الصلاحية يومياً';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        OwnedCard::where('status', 'active')
            ->whereNotNull('expiry_date')
            ->where('expiry_date', '<=', now())
            ->chunkById(200, function ($cards) {
                foreach ($cards as $card) {
                    $card->update([
                        'status' => 'expired',
                    ]);
                }
            });

        return Command::SUCCESS;
    }
}
