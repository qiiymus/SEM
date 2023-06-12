<?php

namespace Database\Seeders;

use App\Models\DutyRoster;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DutyRosterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DutyRoster::factory(8)->create();
    }
}
