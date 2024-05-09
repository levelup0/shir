<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;
use App\Traits\GenerateHash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class IndexController extends Controller
{
    use GenerateHash;
    
    public function create(){
        
    }

    /**
     * Это нужная функция
     */

    private function random_color_part() {
        return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
    }
    
    private function random_color() {
        return $this->random_color_part() . $this->random_color_part() . $this->random_color_part();
    }
}
