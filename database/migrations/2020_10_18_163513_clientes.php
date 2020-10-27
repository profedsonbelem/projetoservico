<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Clientes extends Migration
{
     
    public function up()
    {
       Schema::create('clientes', function(Blueprint $table){
            $table->increments("id");
            $table->string("nome",50);
            $table->string("email",50)->unique();
            $table->string("foto");
            $table->timestamps();
       });
    }

    
    public function down()
    {
        Schema::drop("clientes");
    }
}
