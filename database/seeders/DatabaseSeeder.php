<?php

namespace Database\Seeders;

use App\Models\AuctionItem;
use App\Models\Bid;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@lelangku.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '08123456789',
        ]);

        // Create regular user
        User::create([
            'name' => 'User Demo',
            'email' => 'user@lelangku.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'phone' => '08987654321',
        ]);

        // Create categories
        $categories = [
            ['name' => 'Laptop & Komputer', 'icon' => 'laptop', 'description' => 'Laptop dan aksesoris'],
            ['name' => 'Handphone', 'icon' => 'mobile-alt', 'description' => 'Smartphone dan gadget'],
            ['name' => 'Perabotan', 'icon' => 'couch', 'description' => 'Meja, kursi, dan furnitur'],
            ['name' => 'Alat Tulis & Buku', 'icon' => 'book', 'description' => 'Perlengkapan kantor dan buku'],
            ['name' => 'Aksesoris Elektronik', 'icon' => 'keyboard', 'description' => 'Mouse, keyboard, dan lainnya'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // Create sample auction items
        $items = [
            ['title' => 'Laptop ASUS Vivobook 2025', 'category_id' => 1, 'starting_price' => 7000000, 'description' => 'Laptop keluaran terbaru 2025, RAM 8GB, SSD 512GB.'],
            ['title' => 'Smartphone Samsung A55', 'category_id' => 2, 'starting_price' => 5000000, 'description' => 'HP Samsung seri terbaru, baterai awet, kamera jernih.'],
            ['title' => 'Meja Belajar Minimalis', 'category_id' => 3, 'starting_price' => 500000, 'description' => 'Meja kayu simpel cocok untuk mahasiswa.'],
            ['title' => 'Keyboard Mechanical RGB', 'category_id' => 5, 'starting_price' => 350000, 'description' => 'Keyboard gaming mechanical suara tactile.'],
            ['title' => 'Novel Best Seller 2025', 'category_id' => 4, 'starting_price' => 100000, 'description' => 'Buku novel fiksi populer cetakan terbaru.'],
            ['title' => 'Mouse Wireless Silent', 'category_id' => 5, 'starting_price' => 150000, 'description' => 'Mouse tanpa kabel suara klik halus.'],
        ];

        foreach ($items as $item) {
            AuctionItem::create([
                'user_id' => 1,
                'category_id' => $item['category_id'],
                'title' => $item['title'],
                'description' => $item['description'],
                'starting_price' => $item['starting_price'],
                'current_price' => $item['starting_price'],
                'minimum_bid_increment' => $item['starting_price'] * 0.01,
                'start_time' => now(),
                'end_time' => now()->addDays(7),
                'status' => 'active',
            ]);
        }

        // Add some bids
        $user2 = User::where('role', 'user')->first();
        $auctionItems = AuctionItem::all();
        foreach ($auctionItems->take(3) as $auction) {
            $bidAmount = $auction->starting_price + ($auction->minimum_bid_increment * rand(1, 5));
            Bid::create([
                'auction_item_id' => $auction->id,
                'user_id' => $user2->id,
                'amount' => $bidAmount,
            ]);
            $auction->update([
                'current_price' => $bidAmount,
                'total_bids' => 1,
            ]);
        }
    }
}
