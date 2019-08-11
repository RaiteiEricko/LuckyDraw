<?php

namespace App\Http\Controllers;

use View;
use Illuminate\Http\Request;
use App\UserNumber;

class ResultController extends Controller
{
    public function result()
    {
        $userNumbers = UserNumber::whereNotNull('winner_type')->orderBy('winner_type', 'asc')->get(['user_id', 'number', 'winner_type']);
        return View::make('result')->with('userNumbers', $userNumbers);
    }
}
