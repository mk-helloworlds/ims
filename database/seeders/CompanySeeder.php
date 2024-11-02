<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::create([
            'company_name' => "Angkor Tech Solutions",
            'company_profile' => "Angkor Tech Solutions is a leading IT service provider in Cambodia, offering solutions in software development and cloud services.",
            'category_id' => 1, // Technology
        ]);
        
        Company::create([
            'company_name' => "Phnom Penh Real Estate",
            'company_profile' => "Phnom Penh Real Estate specializes in property management, sales, and rentals in the growing real estate market of Cambodia.",
            'category_id' => 4, // Real Estate
        ]);
        
        Company::create([
            'company_name' => "Sabay Digital Media",
            'company_profile' => "Sabay Digital Media is a key player in Cambodia's digital media industry, providing content, advertising, and media solutions.",
            'category_id' => 29, // Media & Publishing
        ]);
        
        Company::create([
            'company_name' => "Cambodia Food and Beverage Group",
            'company_profile' => "We are a leading group of restaurants and food producers in Cambodia, offering authentic Khmer and international cuisine.",
            'category_id' => 11, // Food & Beverage
        ]);
        
        Company::create([
            'company_name' => "Khmer Construction Co.",
            'company_profile' => "Khmer Construction Co. has been building Cambodia's skyline, providing construction services for residential and commercial projects.",
            'category_id' => 9, // Construction
        ]);
        
        Company::create([
            'company_name' => "Siem Reap Hospitality Group",
            'company_profile' => "Siem Reap Hospitality Group runs a network of high-end hotels and resorts in Cambodia, catering to tourists visiting Angkor Wat.",
            'category_id' => 12, // Hospitality
        ]);
        
        Company::create([
            'company_name' => "Mekong Agriculture Ltd.",
            'company_profile' => "Mekong Agriculture Ltd. focuses on sustainable farming practices, supplying fresh produce to markets across Cambodia.",
            'category_id' => 18, // Agriculture
        ]);
        
        Company::create([
            'company_name' => "Cambodia Logistics Hub",
            'company_profile' => "We are the leading logistics and supply chain management company in Cambodia, ensuring fast and reliable deliveries across the region.",
            'category_id' => 15, // Logistics
        ]);
        
        Company::create([
            'company_name' => "Kampot Pepper Exports",
            'company_profile' => "Known for our world-famous Kampot pepper, we export high-quality pepper products to global markets.",
            'category_id' => 18, // Agriculture
        ]);
        
        Company::create([
            'company_name' => "Battambang Solar Energy",
            'company_profile' => "We provide sustainable energy solutions across Cambodia, specializing in solar panel installations for homes and businesses.",
            'category_id' => 20, // Energy
        ]);
        
        Company::create([
            'company_name' => "Tonle Sap Fisheries",
            'company_profile' => "Tonle Sap Fisheries is committed to sustainable fish farming, supplying quality seafood to markets and restaurants in Cambodia.",
            'category_id' => 18, // Agriculture
        ]);
        
        Company::create([
            'company_name' => "Cambodia Telecom",
            'company_profile' => "Cambodia Telecom is a leading telecommunications provider, offering mobile, internet, and broadband services across the country.",
            'category_id' => 10, // Telecommunications
        ]);
        
        Company::create([
            'company_name' => "Khmer Engineering Group",
            'company_profile' => "We provide innovative engineering solutions for infrastructure projects in Cambodia, specializing in civil and electrical engineering.",
            'category_id' => 9, // Construction
        ]);
        
        Company::create([
            'company_name' => "Angkor Brewery",
            'company_profile' => "Angkor Brewery is one of Cambodia's oldest and most loved beer brands, supplying quality beverages nationwide.",
            'category_id' => 11, // Food & Beverage
        ]);
        
        Company::create([
            'company_name' => "Golden Silk Co.",
            'company_profile' => "Golden Silk Co. is a luxury silk producer in Cambodia, crafting high-quality silk garments and textiles for local and international markets.",
            'category_id' => 26, // Fashion
        ]);
        
        Company::create([
            'company_name' => "Cambodia Financial Solutions",
            'company_profile' => "We provide financial consulting and investment solutions, helping local businesses grow and expand in Cambodia's economy.",
            'category_id' => 3, // Finance
        ]);
        
        Company::create([
            'company_name' => "Phnom Penh Eco Transport",
            'company_profile' => "Phnom Penh Eco Transport offers green transportation solutions, including electric bikes and scooters for urban commuting.",
            'category_id' => 30, // Transportation
        ]);
        
        Company::create([
            'company_name' => "Siem Reap Travel & Tours",
            'company_profile' => "As a leading travel agency in Cambodia, we provide tours and travel services, specializing in cultural and historical sites like Angkor Wat.",
            'category_id' => 35, // Tourism
        ]);
        
        Company::create([
            'company_name' => "Khmer Herbal Products",
            'company_profile' => "We produce and distribute natural health products made from traditional Khmer herbs and plants.",
            'category_id' => 19, // E-commerce
        ]);
        
        Company::create([
            'company_name' => "Cambodia Fashion House",
            'company_profile' => "Cambodia Fashion House designs and produces modern, traditional, and fusion-style clothing for Cambodia’s growing fashion market.",
            'category_id' => 26, // Fashion
        ]);
    }
}
