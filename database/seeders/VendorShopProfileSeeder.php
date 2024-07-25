<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Vendor;

class VendorShopProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'vendor@gmail.com')->first();

        $vendor = new Vendor();
        $vendor->banner = 'uploads/1234.jpg';
        $vendor->shop_name = 'Vendor Shop';
        $vendor->phone = '99999899986';
        $vendor->email = 'admin@gmail.com';
        $vendor->address = 'Uzb';
        $vendor->description = 'shop description';
        $vendor->user_id = $user->id;
        $vendor->save();
    }
}
