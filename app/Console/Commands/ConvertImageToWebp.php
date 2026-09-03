<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ConvertImageToWebp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:webp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        ini_set('memory_limit', '2048M');
        $BASE_PATH = '/home/thniqjewells/public_html/public/uploads';
        if (app()->environment('local')) {
            $BASE_PATH = 'C:/xampp/htdocs/8thniqjewels-frontend/public/uploads/';
        }
        \Log::info("images directory---------",[$BASE_PATH]); 
        if (!is_dir($BASE_PATH)) {
            $this->error("Uploads directory not found.");
            return Command::FAILURE;
        }

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator(
                $BASE_PATH,
                \FilesystemIterator::SKIP_DOTS
            )
        );

        $converted = 0;
        $skipped = 0;
        $failed = 0;

        foreach ($iterator as $file) {

            if (!$file->isFile()) {
                continue;
            }

            $extension = strtolower($file->getExtension());

            if (!in_array($extension, ['jpg', 'jpeg', 'png'])) {
                continue;
            }

            $imagePath = $file->getPathname();
            
            $this->line("Checking: " . $imagePath);
            
            $webpPath = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $imagePath);

            if (file_exists($webpPath)) {
                $skipped++;
                continue;
            }

            try {

                switch ($extension) {

                    case 'jpg':
                    case 'jpeg':
                        $image = imagecreatefromjpeg($imagePath);
                        break;

                    case 'png':
                        $image = imagecreatefrompng($imagePath);

                        imagepalettetotruecolor($image);
                        imagealphablending($image, true);
                        imagesavealpha($image, true);

                        break;

                    default:
                        continue 2;
                }

                if (!$image) {
                    $failed++;
                    continue;
                }

                imagewebp($image, $webpPath, 80);

                imagedestroy($image);
                unlink($imagePath); 
                $converted++;

                $this->line("✔ ".$imagePath);

            } catch (\Throwable $e) {
                 $failed++;
                \Log::info("Image conversion failed", [
                    'file' => $imagePath,
                    'error' => $e->getMessage(),
                    'line' => $e->getLine(),
                ]);

                $this->error("✖ " . $imagePath);
                $this->error($e->getMessage());
            }

        }

        $this->newLine();

        $this->info("Converted : {$converted}");
        $this->warn("Skipped  : {$skipped}");
        $this->error("Failed   : {$failed}");

        $this->updateDatabase();
        return Command::SUCCESS;
    }

    private function updateDatabase()
    {
        $tables = [
            ['table' => 'aboutus', 'column' => 'media'],
            ['table' => 'banners','column'=> 'image'],
            ['table' => 'blogs', 'column' => 'media'],
            ['table' => 'categories', 'column' => 'image'],
            ['table' => 'categories', 'column' => 'thumbnail_image'],
            ['table' => 'promises', 'column' =>'media'],
            ['table' => 'product_collections', 'column' => 'image'],
            ['table' => 'product_graphics', 'column' => 'graphic'],
            ['table' => 'sliders', 'column' => 'media_url'],
            ['table' => 'testimonials', 'column' => 'image'],
            ['table' => 'user_review', 'column' => 'image'],
        ];

        foreach ($tables as $item) {

            // jpg
            DB::table($item['table'])
                ->where($item['column'], 'LIKE', '%.jpg')
                ->update([
                    $item['column'] => DB::raw("REPLACE({$item['column']}, '.jpg', '.webp')")
                ]);

            // JPG
            DB::table($item['table'])
                ->where($item['column'], 'LIKE', '%.JPG')
                ->update([
                    $item['column'] => DB::raw("REPLACE({$item['column']}, '.JPG', '.webp')")
                ]);

            // jpeg
            DB::table($item['table'])
                ->where($item['column'], 'LIKE', '%.jpeg')
                ->update([
                    $item['column'] => DB::raw("REPLACE({$item['column']}, '.jpeg', '.webp')")
                ]);

            // JPEG
            DB::table($item['table'])
                ->where($item['column'], 'LIKE', '%.JPEG')
                ->update([
                    $item['column'] => DB::raw("REPLACE({$item['column']}, '.JPEG', '.webp')")
                ]);

            // png
            DB::table($item['table'])
                ->where($item['column'], 'LIKE', '%.png')
                ->update([
                    $item['column'] => DB::raw("REPLACE({$item['column']}, '.png', '.webp')")
                ]);

            // PNG
            DB::table($item['table'])
                ->where($item['column'], 'LIKE', '%.PNG')
                ->update([
                    $item['column'] => DB::raw("REPLACE({$item['column']}, '.PNG', '.webp')")
                ]);

            $this->info("✔ Updated {$item['table']}");
        }
    }
}
