<?php

use App\Models\Project\ProjectStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null');
            $table->foreignId('company_id')
                ->references('id')
                ->on('companies')
                ->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->tinyInteger('status')->default(ProjectStatus::NEW->value);
            $table->timestamp('duration')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
};
