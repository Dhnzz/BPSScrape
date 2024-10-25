<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScrapeResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scrape_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('target_id')->constrained()->onDelete('cascade');
            $table->string('link');
            $table->string('headline');
            $table->string('coverUrl');
            $table->string('content');
            $table->string('tags');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scrape_results');
    }
}
