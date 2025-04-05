<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'group',
        'type',
        'is_public',
        'description'
    ];

    protected $casts = [
        'is_public' => 'boolean',
    ];

    /**
     * Get a setting value by key
     * 
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get(string $key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        
        if (!$setting) {
            return $default;
        }

        return $setting->getTypedValue();
    }

    /**
     * Set a setting value
     * 
     * @param string $key
     * @param mixed $value
     * @param string $group
     * @param string $type
     * @param bool $isPublic
     * @param string|null $description
     * @return Setting
     */
    public static function set(string $key, $value, string $group = 'general', string $type = 'text', bool $isPublic = false, ?string $description = null)
    {
        $setting = self::firstOrNew(['key' => $key]);
        
        $setting->value = $value;
        $setting->group = $group;
        $setting->type = $type;
        $setting->is_public = $isPublic;
        
        if ($description) {
            $setting->description = $description;
        }
        
        $setting->save();
        
        return $setting;
    }

    /**
     * Başlangıç ayarlarını ekle
     */
    public static function addDefaultSettings()
    {
        $defaults = [
            // Site bilgileri
            ['key' => 'site_name', 'value' => 'B2B Admin Panel', 'group' => 'general', 'type' => 'text', 'is_public' => true, 'description' => 'Site adı'],
            ['key' => 'site_description', 'value' => 'B2B Yönetim Paneli', 'group' => 'general', 'type' => 'text', 'is_public' => true, 'description' => 'Site açıklaması'],
            ['key' => 'logo', 'value' => null, 'group' => 'general', 'type' => 'file', 'is_public' => true, 'description' => 'Site logosu'],
            
            // Mail ayarları
            ['key' => 'mail_server', 'value' => 'smtp.example.com', 'group' => 'mail', 'type' => 'text', 'is_public' => false, 'description' => 'Mail sunucusu'],
            ['key' => 'mail_port', 'value' => '587', 'group' => 'mail', 'type' => 'text', 'is_public' => false, 'description' => 'Mail port'],
            ['key' => 'mail_username', 'value' => 'user@example.com', 'group' => 'mail', 'type' => 'text', 'is_public' => false, 'description' => 'Mail kullanıcı adı'],
            ['key' => 'mail_password', 'value' => '', 'group' => 'mail', 'type' => 'text', 'is_public' => false, 'description' => 'Mail şifresi'],
            ['key' => 'mail_encryption', 'value' => 'tls', 'group' => 'mail', 'type' => 'text', 'is_public' => false, 'description' => 'Mail şifreleme'],
            ['key' => 'mail_from_address', 'value' => 'info@example.com', 'group' => 'mail', 'type' => 'text', 'is_public' => false, 'description' => 'Mail gönderen adresi'],
            ['key' => 'mail_from_name', 'value' => 'B2B Admin', 'group' => 'mail', 'type' => 'text', 'is_public' => false, 'description' => 'Mail gönderen adı'],
            
            // Sipariş ayarları
            ['key' => 'min_order_amount', 'value' => '500', 'group' => 'order', 'type' => 'number', 'is_public' => true, 'description' => 'Minimum sipariş tutarı'],
            ['key' => 'free_shipping_amount', 'value' => '2000', 'group' => 'order', 'type' => 'number', 'is_public' => true, 'description' => 'Ücretsiz kargo tutarı'],
            ['key' => 'kdv_rate', 'value' => '18', 'group' => 'order', 'type' => 'number', 'is_public' => true, 'description' => 'KDV oranı'],
            ['key' => 'kdv_included', 'value' => 'true', 'group' => 'order', 'type' => 'boolean', 'is_public' => true, 'description' => 'KDV dahil mi?'],
        ];

        foreach ($defaults as $item) {
            self::firstOrCreate(
                ['key' => $item['key']],
                $item
            );
        }
    }

    /**
     * Değeri tipine göre dönüştür
     * 
     * @return mixed
     */
    public function getTypedValue()
    {
        switch ($this->type) {
            case 'boolean':
                return filter_var($this->value, FILTER_VALIDATE_BOOLEAN);
            case 'number':
                return is_numeric($this->value) ? (float) $this->value : 0;
            case 'json':
                return json_decode($this->value, true) ?? [];
            default:
                return $this->value;
        }
    }
    
    /**
     * Get all settings as key => value pairs
     * 
     * @param string|null $group
     * @return array
     */
    public static function getAllSettings(?string $group = null): array
    {
        $query = self::query();
        
        if ($group) {
            $query->where('group', $group);
        }
        
        $settings = $query->get();
        
        $result = [];
        foreach ($settings as $setting) {
            $result[$setting->key] = $setting->getTypedValue();
        }
        
        return $result;
    }
}
