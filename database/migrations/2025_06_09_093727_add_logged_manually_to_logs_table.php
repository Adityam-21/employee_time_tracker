<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (!Schema::hasColumn('logs', 'logged_manually')) {
            Schema::table('logs', function (Blueprint $table) {
                $table->boolean('logged_manually')->default(false)->after('end_time'); // adjust column position as needed
            });
        }
    }

    public function down()
    {
        Schema::table('logs', function (Blueprint $table) {
            $table->dropColumn('logged_manually');
        });
    }
};
