<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable()->after('id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->text('requirements')->nullable()->after('description');
            $table->text('benefits')->nullable()->after('requirements');
            $table->string('experience_required')->nullable()->after('benefits');
            $table->string('skills_required')->nullable()->after('experience_required');
            $table->date('deadline')->nullable()->after('skills_required');
            $table->integer('vacancies')->default(1)->after('deadline');
        });
    }

    public function down(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropColumn([
                'company_id','requirements','benefits','experience_required',
                'skills_required','deadline','vacancies',
            ]);
        });
    }
};
