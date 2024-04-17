<?php

namespace Database\Seeders;

use App\Models\DeskStatus\DeskStatusModel;
use App\Models\Log\LogModel;
use App\Models\OfficeStatus\OfficeStatusModel;
use App\Traits\UserTrait;
use Facade\FlareClient\Time\Time;
use Illuminate\Database\Seeder;
Use Carbon\Carbon;

class DummyDataSeeder extends Seeder {
    use UserTrait;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

    }
}
