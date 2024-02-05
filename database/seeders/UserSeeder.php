<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Site;
use App\Models\Page;
use App\Models\Section;
use App\Models\Image;
use App\Models\Text;
use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::Create([
            'first_name' => 'Sonia',
            'last_name' => 'Laskri',
            'email' => 'sonia@gmail.com',
            'phone' => 000000,
            'password' => bcrypt('sonia123')
        ]);

        $site = Site::Create([
            'name' => 'monSite',
            'font_color' => 'black',
            'background_color' => '#F2F4F2',
            'section_color' => '#C2DCBC',
            'user_id' => $user->id
        ]);

        $page = Page::Create([
            'name' => 'Index',
            'order' => 1,
            'site_id' => $site->id
        ]);

        $menu = Menu::Create([
            'type' => 'burger',
            'site_id' => $site->id
        ]);
    }
}
