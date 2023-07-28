<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AmenitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      $hotelAmenities = [
          ['name' => 'Free Wi-Fi', 'description' => 'Complimentary high-speed internet access'],
          ['name' => 'Swimming Pool', 'description' => 'Indoor or outdoor pool for guests'],
          ['name' => 'Fitness Center', 'description' => 'Fully equipped gym and exercise facilities'],
          ['name' => 'Spa and Wellness Center', 'description' => 'Relaxation and wellness treatments'],
          ['name' => 'Restaurant', 'description' => 'On-site dining options for all meals'],
          ['name' => 'Bar/Lounge', 'description' => 'Relaxing space for drinks and socializing'],
          ['name' => 'Room Service', 'description' => 'In-room food and beverage service'],
          ['name' => 'Business Center', 'description' => 'Facilities for business and meetings'],
          ['name' => 'Concierge Service', 'description' => 'Personalized guest assistance'],
          ['name' => 'Parking', 'description' => 'On-site parking facilities'],
          ['name' => 'Airport Shuttle', 'description' => 'Transportation to/from the airport'],
          ['name' => '24-Hour Front Desk', 'description' => 'Round-the-clock guest service'],
          ['name' => 'Luggage Storage', 'description' => 'Secure storage for guest luggage'],
          ['name' => 'Laundry Service', 'description' => 'On-site laundry facilities or service'],
          ['name' => 'Childcare Services', 'description' => 'Babysitting and child care options'],
          ['name' => 'Pet-Friendly', 'description' => 'Accommodations for guests with pets'],
          ['name' => 'Conference/Meeting Facilities', 'description' => 'Spaces for events and meetings'],
          ['name' => 'Gift Shop', 'description' => 'On-site shop for souvenirs and items'],
          ['name' => 'Safety Deposit Box', 'description' => 'Secure storage for valuables'],
          ['name' => 'Airport Hotel Shuttle', 'description' => 'Shuttle service to/from the airport'],
          ['name' => 'Dry Cleaning', 'description' => 'Laundry service for delicate clothing'],
          ['name' => 'Ironing Facilities', 'description' => 'Iron and ironing board in rooms'],
          ['name' => 'Minibar', 'description' => 'In-room stocked with snacks and beverages'],
          ['name' => 'Tea/Coffee Maker', 'description' => 'Complimentary coffee and tea-making facilities'],
          ['name' => 'Satellite/Cable TV', 'description' => 'Television with a wide range of channels'],
          ['name' => 'Ensuite Bathroom', 'description' => 'Private bathroom with amenities'],
          ['name' => 'Complimentary Breakfast', 'description' => 'Free breakfast options for guests'],
          ['name' => 'Electric Vehicle Charging Station', 'description' => 'Charging facilities for electric vehicles'],
          ['name' => 'Garden/Patio', 'description' => 'Outdoor space for relaxation'],
          ['name' => 'Wheelchair Accessibility', 'description' => 'Accommodations for guests with disabilities'],
          ['name' => 'Air-Conditioned Unit', 'description' => 'Rooms with air conditioning'],
          ['name' => '24 Hours Standby Generator', 'description' => 'Backup generator for continuous power'],
          ['name' => 'Intercom', 'description' => 'Communication system in rooms'],
          ['name' => 'Free Airport Pick-up', 'description' => 'Complimentary airport pick-up service'],
      ];

      DB::table('amenities')->insert($hotelAmenities);
    }
}
