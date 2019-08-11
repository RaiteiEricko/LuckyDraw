<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserNumber;
use Auth;
use View;

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
        return view('admin');
    }

    public function saveNumber(Request $request)
    {
        $validatedData = $request->validate([
            'number' => 'required|unique:user_numbers,number|digits:4'
        ]);
        UserNumber::create(array_merge(['user_id' => Auth::id()],$validatedData));
        return redirect(route('home'));
    }
}
