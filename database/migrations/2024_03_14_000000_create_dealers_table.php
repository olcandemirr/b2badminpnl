<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('dealers', function (Blueprint $table) {
            $table->id();
            // Giriş Bilgileri
            $table->string('dealer_no')->nullable()->unique();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('email')->unique();
            $table->string('program_code')->nullable();
            $table->boolean('is_active')->default(true);

            // Genel Bilgiler
            $table->string('first_name');
            $table->string('last_name');
            $table->string('company_title');
            $table->string('country')->default('Türkiye');
            $table->string('city');
            $table->string('district');
            $table->string('postal_code')->nullable();
            $table->string('address_title')->nullable();
            $table->text('address');
            $table->text('address_description')->nullable();
            $table->string('phone');
            $table->string('tax_office')->nullable();
            $table->string('tax_number')->nullable();

            // Evraklar
            $table->string('tax_document')->nullable(); // Vergi levhası
            $table->string('signature_circular')->nullable(); // İmza sirküleri
            $table->string('trade_registry')->nullable(); // Ticari sicil gazetesi
            $table->string('findeks_report')->nullable(); // Findeks risk raporu

            // Ödeme Sistemi
            $table->decimal('balance', 10, 2)->default(0);
            $table->decimal('order_limit', 10, 2)->default(0);
            $table->decimal('yearly_target', 10, 2)->default(0);
            $table->boolean('include_vat')->default(false);
            $table->boolean('has_debt_order_block')->default(false);
            $table->boolean('has_free_payment')->default(false);
            $table->boolean('cash_only')->default(false);
            $table->boolean('card_payment')->default(false);
            $table->boolean('check_payment')->default(false);
            $table->boolean('cash_payment')->default(false);
            $table->boolean('pay_at_door')->default(false);

            // Bayi Tipi ve Diğer Özellikler
            $table->enum('dealer_type', ['Ana Bayi', 'Alt Bayi']);
            $table->boolean('is_super_dealer')->default(false);
            $table->string('main_dealer')->nullable();
            $table->boolean('campaign_news')->default(false);
            $table->boolean('contract')->default(false);
            $table->boolean('kvkk')->default(false);
            $table->boolean('separate_warehouse')->default(false);
            $table->boolean('gift_passive')->default(false);
            $table->boolean('tax_document_required')->default(false);
            $table->boolean('signature_circular_required')->default(false);
            $table->boolean('trade_registry_required')->default(false);
            $table->boolean('findeks_report_required')->default(false);

            // Temsilci ve Dil Bilgileri
            $table->string('representative')->nullable();
            $table->string('language')->default('Türkçe');

            // Fiyat Bilgileri
            $table->string('currency')->nullable();
            $table->string('price_type')->nullable();
            $table->decimal('general_discount', 5, 2)->default(0);
            $table->decimal('additional_discount', 5, 2)->default(0);
            $table->decimal('extra_discount', 5, 2)->default(0);
            $table->string('discount_profile')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dealers');
    }
}; 