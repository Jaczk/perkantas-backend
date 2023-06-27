<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Loan;
use Carbon\Carbon;

class UpdateFines extends Command
{
    protected $signature = 'fines:update';
    protected $description = 'Update fines for all loans';

    public function handle()
    {
        $loans = Loan::where('return_date', '<', Carbon::today())->where('is_returned', 0)->get();

        foreach ($loans as $loan) {
            $diffInDays = Carbon::today()->diffInDays($loan->return_date);
            $fine = ($diffInDays + 1) * 5;

            $loan->fine = $fine;
            $loan->save();
        }

        $this->info('Fines have been updated successfully.');
    }
}

