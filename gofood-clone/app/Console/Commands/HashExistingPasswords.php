<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Restaurant; // Import model Restaurant
use App\Models\Driver;     // Import model Driver
use Illuminate\Support\Facades\Hash; // Import Hash facade
use Illuminate\Support\Facades\Log;  // Import Log facade (opsional, tapi bagus untuk debugging)

class HashExistingPasswords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // Nama command yang akan dijalankan: php artisan data:hash-passwords
    protected $signature = 'data:hash-passwords';

    /**
     * The console command description.
     *
     * @var string
     */
    // Deskripsi command
    protected $description = 'Hashes existing plain text passwords for Restaurant and Driver models.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting password hashing process...'); // Pesan di konsol
        $updatedCount = 0;

        // --- Proses Model Restaurant ---
        $this->info('Processing Restaurant passwords...');
        $restaurants = Restaurant::all();
        $this->info('Found ' . $restaurants->count() . ' restaurants.');

        foreach ($restaurants as $restaurant) {
            // Cek apakah password ada dan belum di-hash (cek format Bcrypt)
            // Asumsi kolom 'password' ada di model Restaurant dan tabelnya
            // Pastikan model Restaurant meng-extend User atau mengimplementasikan Authenticatable
            if ($restaurant->password && !str_starts_with($restaurant->password, '$2y$')) {
                try {
                    $restaurant->password = Hash::make($restaurant->password);
                    $restaurant->save();
                    $updatedCount++;
                    // Log atau output di konsol akun yang di-hash
                    // PERBAIKAN SINTAKS ?? untuk PHP 5.x
                    $restaurantEmail = isset($restaurant->email) ? $restaurant->email : 'N/A';
                    $this->info("Hashed password for Restaurant ID: {$restaurant->restaurant_id}, Email: " . $restaurantEmail);

                     // PERBAIKAN SINTAKS ?? untuk PHP 5.x di array Log
                    Log::info("Artisan Command Hashed password for Restaurant", ['restaurant_id' => $restaurant->restaurant_id, 'email' => $restaurantEmail]);

                } catch (\Exception $e) {
                    $this->error("Error hashing password for Restaurant ID: {$restaurant->restaurant_id}. " . $e->getMessage());
                    Log::error("Artisan Command Error hashing password for Restaurant", ['restaurant_id' => $restaurant->restaurant_id, 'error' => $e->getMessage()]);
                }
            }
        }
        $this->info('Finished processing Restaurant passwords.');


        // --- Proses Model Driver ---
        $this->info('Processing Driver passwords...');
        $drivers = Driver::all();
        $this->info('Found ' . $drivers->count() . ' drivers.');

        foreach ($drivers as $driver) {
             // Cek apakah password ada dan belum di-hash
             // Asumsi kolom 'password' ada di model Driver dan tabelnya
             // Pastikan model Driver meng-extend User atau mengimplementasikan Authenticatable
            if ($driver->password && !str_starts_with($driver->password, '$2y$')) {
                 try {
                    $driver->password = Hash::make($driver->password);
                    $driver->save();
                    $updatedCount++;
                    // Log atau output di konsol akun yang di-hash
                    // PERBAIKAN SINTAKS ?? untuk PHP 5.x
                    $driverEmail = isset($driver->email) ? $driver->email : 'N/A';
                    $this->info("Hashed password for Driver ID: {$driver->driver_id}, Email: " . $driverEmail);

                    // PERBAIKAN SINTAKS ?? untuk PHP 5.x di array Log
                    Log::info("Artisan Command Hashed password for Driver", ['driver_id' => $driver->driver_id, 'email' => $driverEmail]);

                } catch (\Exception $e) {
                    $this->error("Error hashing password for Driver ID: {$driver->driver_id}. " . $e->getMessage());
                    Log::error("Artisan Command Error hashing password for Driver", ['driver_id' => $driver->driver_id, 'error' => $e->getMessage()]);
                }
            }
        }
        $this->info('Finished processing Driver passwords.');


        $this->info("Password hashing process finished. Total passwords updated: {$updatedCount}"); // Pesan ringkasan di konsol
        Log::info("Artisan Command Password Hashing Process Completed. Total updated: {$updatedCount}");


        return Command::SUCCESS; // Mengembalikan kode sukses
    }
}