<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contact;

class ContactsTableSeeder extends Seeder
{
    public function run()
    {
        Contact::factory()->count(35)->create();
    }
}