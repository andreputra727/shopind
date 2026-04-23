<?php
use App\Models\Product;

Product::where('name', 'like', '%Smartwatch%')->update(['image' => 'products/watch.jpg']);
Product::where('name', 'like', '%Smartphone%')->update(['image' => 'products/phone.jpg']);
Product::where('name', 'like', '%Headphone%')->update(['image' => 'products/headphones.jpg']);
Product::where('name', 'like', '%Laptop%')->update(['image' => 'products/laptop.jpg']);
Product::where('name', 'like', '%Kamera%')->update(['image' => 'products/camera.jpg']);

echo "Products updated successfully!\n";
