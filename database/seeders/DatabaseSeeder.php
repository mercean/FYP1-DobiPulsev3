<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Machine;

class MachineSeeder extends Seeder
{
    /**
     * Seed the machines table with 6 washers and 6 dryers.
     */
    public function run(): void
    {
        $types = ['washer', 'dryer'];

        foreach ($types as $type) {
            for ($i = 1; $i <= 6; $i++) {
                Machine::create([
                    'type' => $type,
                    'location' => 'Level ' . ceil($i / 2),
                    'status' => 'available',
                ]);
            }
        }
    }
}
