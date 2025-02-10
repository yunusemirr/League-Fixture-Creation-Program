<?php
namespace App\Helpers;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BaseMigration extends Migration{

    public Blueprint $t;

    public function softDeleter(Blueprint $t = null){
        if($t != null){
            $this->t = $t;
        }

        $this->t->unsignedBigInteger('deleted_by')->nullable();
        $this->t->softDeletes();

        return $this;
    }

    public function byer(Blueprint $t = null){
        if($t != null){
            $this->t = $t;
        }

        $this->t->unsignedBigInteger('created_by')->nullable();
        $this->t->unsignedBigInteger('updated_by')->nullable();
        return $this;
    }
}