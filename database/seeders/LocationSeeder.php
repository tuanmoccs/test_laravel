<?php

namespace Database\Seeders;

use App\Services\LocationImporter;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    public function run(LocationImporter $importer): void
    {
        $importer->import();
    }
}
