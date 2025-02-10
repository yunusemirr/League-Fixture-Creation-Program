<?php

use App\Helpers\BaseMigration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends BaseMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $this->t = $table;
            $table->id();

            $table->boolean('is_active')->default(false)->nullable();

            $table->string('name');
            $table->string('surname')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('phone')->unique()->nullable();
            $table->string('tc')->unique()->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();

            $table->integer('role_id')->default(1)->nullable();

            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();

            $this->byer()->softDeleter();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
