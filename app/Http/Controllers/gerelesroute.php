<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class gerelesroute extends Controller
{
    //
    public function animale(){
        return view("matier.animal");
    }
    public function fruits(){
        return view("matier.fruits");
    }
    public function color(){
        return view("matier.color");
    }
     public function hopetal(){
        return view("dialoge.francais.hopetal");
    }
       public function love(){
        return view("dialoge.francais.love");
    } 
    public function transport(){
        return view("matier.transport");
    }
     public function math(){
        return view("matier.math");
    }
     public function francais(){
        return view("dialoge.francais.index");
    }
     public function anglais(){
        return view("dialoge.anglais.index");
    }
    public function shopping(){
        return view("dialoge.francais.shopping");
    }
     public function café(){
        return view("dialoge.francais.café");
    }
}
