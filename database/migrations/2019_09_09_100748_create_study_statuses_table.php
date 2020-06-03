<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudyStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('study_statuses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('en')->nullable();
            $table->string('km')->nullable();
            $table->string('color')->nullable();
            $table->text('description')->nullable();
            $table->text('image')->nullable();
             $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'))->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('study_statuses');
    }
}
