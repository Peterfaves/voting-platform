<?php
// database/seeders/DemoEventSeeder.php (Optional for testing)
namespace Database\Seeders;

use App\Models\User;
use App\Models\Event;
use App\Models\Category;
use App\Models\Contestant;
use App\Models\Ticket;
use Illuminate\Database\Seeder;

class DemoEventSeeder extends Seeder
{
    public function run(): void
    {
        $organizer = User::where('email', 'organizer@chilkyvote.com')->first();

        // Create Demo Event
        $event = Event::create([
            'user_id' => $organizer->id,
            'name' => 'Nigerian Music Awards 2025',
            'description' => 'The biggest music awards in Nigeria',
            'vote_price' => 100.00,
            'start_date' => now(),
            'end_date' => now()->addDays(30),
            'status' => 'active',
        ]);

        // Create Categories
        $categories = [
            ['name' => 'Best Male Artist', 'description' => 'Vote for your favorite male artist'],
            ['name' => 'Best Female Artist', 'description' => 'Vote for your favorite female artist'],
            ['name' => 'Song of the Year', 'description' => 'Best song released this year'],
        ];

        foreach ($categories as $index => $categoryData) {
            $category = $event->categories()->create([
                'name' => $categoryData['name'],
                'description' => $categoryData['description'],
                'order' => $index,
            ]);

            // Create contestants for each category
            for ($i = 1; $i <= 5; $i++) {
                $category->contestants()->create([
                    'name' => "Contestant {$i} - {$category->name}",
                    'bio' => "Bio for contestant {$i}",
                    'total_votes' => rand(0, 1000),
                    'status' => 'active',
                ]);
            }
        }

        // Create Tickets
        $tickets = [
            ['name' => 'Regular', 'price' => 5000, 'quantity' => 500, 'type' => 'regular'],
            ['name' => 'VIP', 'price' => 15000, 'quantity' => 100, 'type' => 'vip'],
            ['name' => 'VVIP', 'price' => 30000, 'quantity' => 50, 'type' => 'vvip'],
        ];

        foreach ($tickets as $ticketData) {
            $event->tickets()->create([
                'name' => $ticketData['name'] . ' Ticket',
                'description' => "Access to {$ticketData['name']} section",
                'price' => $ticketData['price'],
                'quantity' => $ticketData['quantity'],
                'type' => $ticketData['type'],
            ]);
        }
    }
}