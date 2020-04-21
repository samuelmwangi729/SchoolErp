<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('StudentName');
            $table->string('parent');
            $table->integer('class');
            $table->string('Stream');
            $table->string('AdmissionNumber');
            $table->string('Kcpe');
            $table->date('birthDate');
            $table->string('Passport');
            $table->string('Nemis');
            $table->string('SchoolFees')->default(0);
            $table->string('Balance')->default(0);
            $table->integer('Status')->default(0);
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
        Schema::dropIfExists('students');
    }
}
