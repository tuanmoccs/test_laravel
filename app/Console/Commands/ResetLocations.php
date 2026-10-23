<?php

namespace App\Console\Commands;

use App\Services\LocationImporter;
use Illuminate\Console\Command;

class ResetLocations extends Command
{
    protected $signature = 'locations:reset';

    protected $description = 'Reset the locations table to the original CSV data';

    public function handle(LocationImporter $importer): int
    {
        $count = $importer->import();

        $this->info("Locations reset: {$count} rows imported.");

        return self::SUCCESS;
    }
}
