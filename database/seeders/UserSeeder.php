<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Site;
use App\Models\Page;
use App\Models\Section;
use App\Models\Image;
use App\Models\Text;
use App\Models\Article;
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
            'font_color' => '#333333',
            'background_color' => '#D8E5EB',
            'section_color' => '#40535B',
            'user_id' => $user->id
        ]);

        $page = Page::Create([
            'name' => 'Index',
            'site_id' => $site->id
        ]);

        $menu = Menu::Create([
            'type' => 'burger',
            'site_id' => $site->id
        ]);
    }
}
