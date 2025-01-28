<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Consoler;

class GenerateInvoices extends Command
{
    protected $signature = 'invoices:generate';
    protected $description = 'Automatically generate invoices for all consolers';

    public function handle()
    {
        $consolers = Consoler::all();

        foreach ($consolers as $consoler) {
            $consoler->generateOrUpdateInvoice();
            sleep(1);
        }

        $this->info('Invoices generated successfully!');
    }
}
