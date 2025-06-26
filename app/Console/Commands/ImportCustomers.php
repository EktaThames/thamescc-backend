<?php
 
namespace App\Console\Commands;
 
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Webkul\Customer\Models\Customer;
use Illuminate\Support\Facades\Password;
class ImportCustomers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-customers';
 
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
        $filePath = 'imports/new-customers.csv';
        $csvPath = storage_path('app/private/' . $filePath);
 
        if (!file_exists($csvPath)) {
            $this->error('CSV file not found at: ' . $csvPath);
            return;
        }
 
        $data = array_map('str_getcsv', file($csvPath));
        $headers = array_map('trim', array_shift($data));
 
        foreach ($data as $row) {
            if (count($row) !== count($headers)) {
                $this->error('Row skipped due to column mismatch: ' . implode(',', $row));
                continue;
            }
 
            $rowData = array_combine($headers, $row);
 
            if (empty($rowData['password'])) {
                unset($rowData['password']);
            } else {
                $rowData['password'] = Hash::make($rowData['password']);
            }
 
            $rowData['api_token'] = !empty($rowData['api_token']) ? $rowData['api_token'] : null;
 
            $rowData['gender'] = $rowData['gender'] ?? null;
            $rowData['date_of_birth'] = $rowData['date_of_birth'] ?? null;
            $rowData['phone'] = $rowData['phone'] ?? null;
            $rowData['customer_group_id'] = $rowData['customer_group_id'] ?? 3;
            $rowData['status'] = $rowData['status'] ?? 1;
            $rowData['channel_id'] = $rowData['channel_id'] ?? 1;
            $rowData['subscribed_to_news_letter'] = $rowData['subscribed_to_news_letter'] ?? false;
            $rowData['token'] = $rowData['token'] ?? null;
            $rowData['is_verified'] = $rowData['is_verified'] ?? true;
            $rowData['is_suspended'] = $rowData['is_suspended'] ?? false;
 
            try {
                Customer::create($rowData);
 
                // Password::broker('customers')->sendResetLink(['email' => $rowData['email']]);
            
                $this->info("Imported and sent reset link: {$rowData['email']}");
            } catch (\Exception $e) {
                $this->error("Failed: {$rowData['email']} - " . $e->getMessage());
            }
        }
 
        $this->info('Import completed.');
    }
}