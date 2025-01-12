<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Auctions;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;
class AuctionsSeeder extends Seeder
{
    public function run()
    {
        $filePath = database_path('seeders/CSV/Auction.csv');

        $file = fopen($filePath, 'r');

        $header = fgetcsv($file);

        while (($row = fgetcsv($file)) !== false) {
            try {
                $buildDate = $this->parseDate($row[3]);
                $deadline = $this->parseDate($row[10]);
                $dateListed = $this->parseDate($row[22]);

                $auction = Auctions::firstOrCreate(
                    ['unique_identifier' => $row[14]],
                    [
                        'name' => $row[0], 
                        'make' => $row[1], 
                        'model' => $row[2], 
                        'build_date' => $buildDate,
                        'odometer' => $row[4],
                        'body_type' => $row[5],
                        'fuel' => $row[6],
                        'transmission' => $row[7],
                        'seats' => $row[8],
                        'auctioneer' => $row[9],
                        'deadline' => $deadline,
                        'link_to_auction' => $row[11],
                        'link_to_condition_report' => $row[12],
                        'other_specs' => $row[13],
                        'hours' => $row[15],
                        'state' => $row[16],
                        'redbook_code' => $row[17],
                        'redbook_average_wholesale' => $row[18],
                        'current_market_retail' => $row[19],
                        'auction_registration_link' => $row[20],
                        'vin' => $row[21],
                        'date_listed' => $dateListed,
                        'name_of_auction' => $row[23],
                    ]
                );
            } catch (Exception $e) {
                Log::error("Date parsing error for row: " . implode(", ", $row) . " - " . $e->getMessage());
            }
        }

        fclose($file);
    }


    private function parseDate($date)
    {
        if (empty($date) || $date == '0000') {
            return null; 
        }

        try {
            return Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
        } catch (Exception $e) {
            return Carbon::createFromFormat('Y', $date)->format('Y-m-d'); 
        }
    }
}
