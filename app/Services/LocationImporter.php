<?php

namespace App\Services;

use App\Models\Location;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class LocationImporter
{
    public function __construct(private ?string $path = null)
    {
        $this->path ??= database_path('data/locations.csv');
    }

    public function rows(): array
    {
        $handle = @fopen($this->path, 'r');

        if (! $handle) {
            throw new RuntimeException("Cannot open CSV file: {$this->path}");
        }

        $header = array_map(fn ($h) => strtolower(trim($h, "\xEF\xBB\xBF \"")), fgetcsv($handle));
        $now = now();
        $rows = [];

        while (($line = fgetcsv($handle)) !== false) {
            if (count($line) !== count($header)) {
                continue;
            }

            $data = array_combine($header, $line);
            $rows[] = [
                'id' => (int) $data['id'],
                'name' => $data['name'],
                'lat' => $data['lat'],
                'lng' => $data['lng'],
                'status' => $data['status'] ?: null,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        fclose($handle);

        return $rows;
    }

    public function import(): int
    {
        $rows = $this->rows();

        DB::transaction(function () use ($rows) {
            Location::query()->withTrashed()->forceDelete();

            foreach (array_chunk($rows, 500) as $chunk) {
                Location::query()->insert($chunk);
            }
        });

        return count($rows);
    }
}
