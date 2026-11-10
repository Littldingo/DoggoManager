<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FeedingDay extends Model
{
    protected $table = 'raw.feeding_day';

    

    public function Bestellung($dogId, $table, $fk, $qty)
    {
        return DB::table('raw.feeding_day')
            ->where('dog_id', $dogId)
            ->selectRaw("raw.$table.name, SUM($qty)*4 as summe")
            ->join("raw.$fk", "raw.feeding_day.$fk", '=', "raw.$fk.id")
            ->groupBy("raw.$fk.name")
            ->get();
    }

    public function summeMalVier($dogId, $fk){
        return DB::table('raw.feeding_day')
        ->where('dog_id', $dogId)
        ->selectRaw("sum(raw.feeding_day.$fk)*4 as summe")
        ->value('summe');
    }
}
