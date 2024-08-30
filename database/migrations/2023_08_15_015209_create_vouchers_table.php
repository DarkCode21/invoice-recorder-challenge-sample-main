<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('issuer_name');
            $table->string('issuer_document_type');
            $table->string('issuer_document_number');
            $table->string('receiver_name');
            $table->string('receiver_document_type');
            $table->string('receiver_document_number');
            $table->decimal('total_amount', 8, 2);
            
            // DATOS SOLICITADOS
            $table->string('document_serie', 4); 
            $table->string('document_number', 8); 
            $table->string('document_type_code', 3);
            $table->string('currency_code', 3);

            $table->longText('xml_content');
            $table->uuid('user_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('vouchers', function (Blueprint $table) {
            $table->dropColumn(['document_serie', 'document_number', 'document_type_code', 'currency_code']);
            
        });
    }
};
