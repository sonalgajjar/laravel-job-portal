<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->string('profile_image')->nullable()->after('phone');
            $table->string('resume')->nullable()->after('profile_image');
            $table->text('resume_text')->nullable()->after('resume');
            $table->string('skills')->nullable()->after('resume_text');
            $table->text('bio')->nullable()->after('skills');
            $table->string('address')->nullable()->after('bio');
            $table->text('experience_info')->nullable()->after('address');
            $table->text('education_info')->nullable()->after('experience_info');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone','profile_image','resume','resume_text','skills',
                'bio','address','experience_info','education_info',
            ]);
        });
    }
};
