<?php

namespace App\Http\Controllers;

use Auth;
use View;
use Illuminate\Http\Request;
use App\UserNumber;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $userNumbers = UserNumber::where('user_id', Auth::id())->get(['number']);
        return View::make('home')->with('userNumbers', $userNumbers);
    }

    public function admin()
    {
        $userNumbers = UserNumber::whereNotNull('winner_type')->orderBy('winner_type', 'asc')->get(['user_id', 'number', 'winner_type']);
        return View::make('admin')->with('userNumbers', $userNumbers);
    }

    public function saveNumber(Request $request)
    {
        $validatedData = $request->validate([
            'number' => 'required|unique:user_numbers,number|digits:4'
        ]);
        UserNumber::create(array_merge(['user_id' => Auth::id()],$validatedData));
        return redirect()->route('home');
    }

    public function drawWinner(Request $request)
    {
        $validatedData = $request->validate([
            'number' => ['nullable', 'digits:4', 'exists:user_numbers,number'],
            'type' => [
                'required', 
                'in:'. implode(',', array_keys(config('luckydraw.winnerTypes'))),
                'unique:user_numbers,winner_type',
            ],
        ]);

        if($validatedData['number']) {
            $userNumber = UserNumber::where('number', $validatedData['number'])->first();            

            if (UserNumber::where('user_id', $userNumber->user_id)->whereNotNull('winner_type')->exists()){
                return back()->withErrors('This user already has a winning number.');
            }
            else {
                $userNumber->update(['winner_type' => $validatedData['type']]);
            }
        } else {
            // auto generate
            if ($validatedData['type'] == 1) {
                // get member with most number of winning number but not exist in the winners list
                $potentialWinners = UserNumber::select('user_id')
                    ->selectRaw('count(*) AS total')
                    ->whereRaw ('user_id NOT IN (SELECT user_id FROM user_numbers WHERE winner_type IS NOT NULL)')
                    ->groupBy('user_id')
                    ->orderBy('total', 'desc')
                    ->get();

                $winner = $potentialWinners->reject(function ($userNumber) use ($potentialWinners) {
                        return $userNumber->total < $potentialWinners->max('total');
                    })
                    ->random();

                $userNumbers = UserNumber::select('number')
                    ->where('user_id', $winner->user_id)
                    ->inRandomOrder()
                    ->first();
            } else {
                // select random but not exist in winners list
                $userNumbers = UserNumber::select('number')
                    ->whereRaw('user_id NOT IN (SELECT user_id FROM user_numbers WHERE winner_type IS NOT NULL)')
                    ->inRandomOrder()
                    ->first();
            }

            $winningNumber = $userNumbers->number ?? '';
            if($winningNumber) {
                UserNumber::where('number', $winningNumber)
                    ->update(['winner_type' => $validatedData['type']]);
            } else {
                return back()->withErrors('No more winning number is eligible.');
            }
        }

        return redirect()->route('admin');
    }
}
