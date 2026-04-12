<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('barang');

        Schema::create('barang', function (Blueprint $table) {
            $table->string('id_barang', 8)->primary();
            $table->string('nama', 50);
            $table->integer('harga');
            $table->timestamps();
        });

        DB::unprepared("
            CREATE SEQUENCE IF NOT EXISTS barang_id_seq;

            CREATE OR REPLACE FUNCTION generate_barang_id()
            RETURNS TRIGGER AS $$
            BEGIN
                NEW.id_barang := 'BRG-' || LPAD(nextval('barang_id_seq')::text, 4, '0');
                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;

            CREATE TRIGGER trg_generate_barang_id
            BEFORE INSERT ON barang
            FOR EACH ROW
            EXECUTE FUNCTION generate_barang_id();
        ");
    }

    public function down(): void
    {
        DB::unprepared("
            DROP TRIGGER IF EXISTS trg_generate_barang_id ON barang;
            DROP FUNCTION IF EXISTS generate_barang_id();
            DROP SEQUENCE IF EXISTS barang_id_seq;
        ");
        Schema::dropIfExists('barang');
    }
};
