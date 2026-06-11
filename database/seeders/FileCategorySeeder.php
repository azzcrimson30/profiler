<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\FileCategory;
use Illuminate\Database\Seeder;

class FileCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Images', 'slug' => 'images', 'description' => 'Image files, avatars and photos.'],
            ['name' => 'PDFs', 'slug' => 'pdfs', 'description' => 'PDF documents.'],
            ['name' => 'Spreadsheets', 'slug' => 'spreadsheets', 'description' => 'Excel and CSV files.'],
            ['name' => 'Documents', 'slug' => 'documents', 'description' => 'Word and text documents.'],
            ['name' => 'Others', 'slug' => 'others', 'description' => 'Miscellaneous files.'],
        ];

        foreach ($categories as $cat) {
            FileCategory::updateOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}
