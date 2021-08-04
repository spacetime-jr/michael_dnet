<?php

namespace Modules\Settings\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Settings\Entities\Setting;

class SettingsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->command->info('Begin inserting Setting');

        $setting = new Setting();
        $setting->key = 'jatah_cuti_setahun';
        $setting->value = 13;
        $setting->save();
    }
}
