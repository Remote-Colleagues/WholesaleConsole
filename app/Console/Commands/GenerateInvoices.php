<?php
namespace App\Console\Commands;

use App\Models\Partner;
use Illuminate\Console\Command;
use App\Models\Consoler;

class GenerateInvoices extends Command
{
    protected $signature = 'invoices:generate';
    protected $description = 'Automatically generate invoices for all consolers and Partners';

    public function handle()
    {
        $consolers = Consoler::all();
        $partners = Partner::all();

        foreach ($consolers as $consoler) {
            $consoler->generateOrUpdateInvoice();
            sleep(1);
        }
        foreach ($partners as $partner) {
            $partner->generateOrUpdateInvoice();
            sleep(1);
        }

        $this->info('Invoices generated successfully!');
    }
}
