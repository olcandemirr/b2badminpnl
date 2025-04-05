<?php

namespace App\Console\Commands;

use App\Models\Setting;
use Illuminate\Console\Command;

class SetupSettings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup:settings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Varsayılan ayarları yükler';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Varsayılan ayarlar yükleniyor...');
        
        // Varsayılan ayarları ekle
        Setting::addDefaultSettings();
        
        // Ek parametreler ekle
        $this->setupParameters();
        
        $this->info('Varsayılan ayarlar başarıyla yüklendi!');
        
        return Command::SUCCESS;
    }
    
    /**
     * Setup additional parameters
     */
    private function setupParameters()
    {
        // Sipariş parametreleri
        $orderParameters = [
            'min_order_quantity' => 1,
            'max_order_quantity' => 1000,
            'order_increment' => 1,
        ];
        
        // Kargo parametreleri
        $shippingParameters = [
            'default_shipping_company' => 'yurtici',
            'shipping_tracking_url' => 'https://www.yurticikargo.com/tr/online-servisler/gonderi-sorgula?code={tracking_code}',
            'show_shipping_tracking' => true,
        ];
        
        // Para birimi parametreleri
        $currencyParameters = [
            'default_currency' => 'TL',
            'usd_exchange_rate' => 30.75,
            'eur_exchange_rate' => 33.50,
        ];
        
        // Sistem parametreleri
        $systemParameters = [
            'records_per_page' => 25,
            'date_format' => 'd.m.Y',
            'timezone' => 'Europe/Istanbul',
        ];
        
        // Parametreleri kaydet
        foreach ($orderParameters as $key => $value) {
            Setting::set($key, $value, 'parameters', is_bool($value) ? 'boolean' : 'text', true, 'Sipariş parametresi: ' . $key);
        }
        
        foreach ($shippingParameters as $key => $value) {
            Setting::set($key, $value, 'parameters', is_bool($value) ? 'boolean' : 'text', true, 'Kargo parametresi: ' . $key);
        }
        
        foreach ($currencyParameters as $key => $value) {
            Setting::set($key, $value, 'parameters', is_numeric($value) ? 'number' : 'text', true, 'Para birimi parametresi: ' . $key);
        }
        
        foreach ($systemParameters as $key => $value) {
            Setting::set($key, $value, 'parameters', 'text', true, 'Sistem parametresi: ' . $key);
        }
    }
}
