<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id') //fixed foreign key syntax
                ->constrained('users') //references 'id' on 'users' table by default
                ->onDelete('cascade'); //deletes comments if user is deleted
            $table->foreignId('post_id')
                ->constrained('posts')
                ->onDelete('cascade')
                ->after('user_id'); // optional, for order


            $table->string('body');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign(['post_id']); //first remove the fk constrained
            $table->dropColumn('post_id'); //then,remove the actual column
        });
    }
};
