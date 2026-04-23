<?php
use App\Models\Product;

Product::where('name', 'like', '%Keyboard%')->update(['image' => 'products/keyboard.jpg']);

echo "Keyboard image updated successfully!\n";
