<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name'        => 'Laptop Modern Pro',
                'price'       => 12500000,
                'stock'       => 15,
                'description' => 'Laptop modern dengan performa tinggi, cocok untuk pekerjaan profesional dan gaming. Dilengkapi dengan processor terbaru dan RAM 16GB.',
                'image'       => null,
            ],
            [
                'name'        => 'Headphone Wireless Pro',
                'price'       => 2500000,
                'stock'       => 30,
                'description' => 'Headphone wireless premium dengan noise cancelling dan kualitas audio superior. Battery life hingga 30 jam.',
                'image'       => null,
            ],
            [
                'name'        => 'Smartphone X Pro',
                'price'       => 8900000,
                'stock'       => 20,
                'description' => 'Smartphone flagship dengan kamera 108MP dan layar AMOLED 6.7 inch. Performa kencang dengan chipset terbaru.',
                'image'       => null,
            ],
            [
                'name'        => 'Smartwatch Elite',
                'price'       => 3200000,
                'stock'       => 25,
                'description' => 'Smartwatch dengan fitur kesehatan lengkap, GPS, dan tahan air. Cocok untuk aktivitas sehari-hari dan olahraga.',
                'image'       => null,
            ],
            [
                'name'        => 'Kamera Profesional',
                'price'       => 18500000,
                'stock'       => 10,
                'description' => 'Kamera profesional dengan sensor full frame dan lensa kit 24-70mm. Ideal untuk fotografer profesional.',
                'image'       => null,
            ],
            [
                'name'        => 'Gaming Keyboard Mechanical',
                'price'       => 1800000,
                'stock'       => 40,
                'description' => 'Keyboard gaming mechanical dengan RGB lighting dan switch premium. Response time cepat untuk gaming kompetitif.',
                'image'       => null,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}