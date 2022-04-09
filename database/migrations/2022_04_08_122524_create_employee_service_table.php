<?php

use App\Models\Service;
use App\Models\Employee;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_service', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Employee::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Service::class)->constrained()->cascadeOnDelete();
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
        Schema::dropIfExists('employee_service');
    }
}
