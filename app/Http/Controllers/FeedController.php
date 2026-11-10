<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\FeedingDay;

class FeedController extends Controller
{
    public function loadFeeding()
    {

        $feeding = new FeedingDay();
        $fleisch = $feeding->Bestellung(1, 'flesh', 'flesh', 'flesh_q');
        $vegetables = $feeding->summeMalVier(1, 'vegetables_q');
        $fat = $feeding->summeMalVier(1, 'fat_q');
        $offal = $feeding->Bestellung(1, 'offal', 'offal', 'offal_q');
        $bones = $feeding->Bestellung(1, 'bones', 'bones', 'bones_q');
        $daten = DB::table("raw.feeding_day")
            ->join('raw.bones', 'raw.feeding_day.bones', '=', 'raw.bones.id')
            ->join('raw.flesh', 'raw.feeding_day.flesh', '=', 'raw.flesh.id')
            ->join('raw.offal', 'raw.feeding_day.offal', '=', 'raw.offal.id')
            ->join('raw.dogs', 'raw.feeding_day.dog_id', '=', 'raw.dogs.id')
            ->join('raw.days', 'raw.feeding_day.day', '=', 'raw.days.id')
            ->orderBy('raw.days.id')
            ->select(
                'raw.dogs.name as hund',
                'raw.days.name as tag',
                'raw.flesh.name as fleisch',
                'raw.offal.name as innereien',
                'raw.bones.name as knochen',
                'raw.feeding_day.bones_q',
                'raw.feeding_day.offal_q',
                'raw.feeding_day.flesh_q',
                'raw.feeding_day.vegetables_q',
                'raw.feeding_day.fat_q',
            )
            ->get();


        $start = Carbon::Parse("2026-10-31");
        $today = Carbon::today();
        $days = $start->diffInDays($today);
        $cycleDay = ($days % 28) + 1;

        return view('feed', [
            "cycleDay" => $cycleDay,
            "daten" => $daten,            
            "vegetables" => $vegetables,
            "fat" => $fat,
            "fleisch" => $fleisch,
            "offal" => $offal,
            "bones" => $bones
        ]);
    }
}
