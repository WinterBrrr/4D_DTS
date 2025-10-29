<?php
$file = 'resources/views/layouts/app.blade.php';
$content = file_get_contents($file);

// Find and replace the logo section
$pattern = '/<a href="\{\{ route\(\'dashboard\'\) \}\}" class="flex items-center space-x-2[^"]*">\s*<img[^>]*>\s*<\/a>/s';

$replacement = '<a href="{{ route(\'dashboard\') }}" class="flex items-center space-x-3 font-bold text-lg tracking-tight text-gray-900 hover:text-emerald-600 transition-colors">
                            <img src="{{ asset(\'images/logo.png\') }}" alt="4DOCS Logo" class="h-14 w-auto">
                            <span class="text-2xl font-bold">4DOCS</span>
                        </a>';

$content = preg_replace($pattern, $replacement, $content);

// If the above pattern didn't match, try a more specific one
if (strpos($content, '4DOCS') === false) {
    $old = '<a href="{{ route(\'dashboard\') }}" class="flex items-center space-x-2 font-bold text-lg tracking-tight text-gray-900 hover:text-emerald-600 transition-colors">
                            <img src="{{ asset(\'images/logo.png\') }}" alt="DTS Logo" class="h-10 w-auto">
                        </a>';
    
    $new = '<a href="{{ route(\'dashboard\') }}" class="flex items-center space-x-3 font-bold text-lg tracking-tight text-gray-900 hover:text-emerald-600 transition-colors">
                            <img src="{{ asset(\'images/logo.png\') }}" alt="4DOCS Logo" class="h-14 w-auto">
                            <span class="text-2xl font-bold">4DOCS</span>
                        </a>';
    
    $content = str_replace($old, $new, $content);
}

file_put_contents($file, $content);
echo "Logo updated with 4DOCS text!\n";
