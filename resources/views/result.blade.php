@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-3">
                <div class="text-center display-2 font-weight-bold">Lucky Draw Winners</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-3 text-center"><b>Name</b></div>
                        <div class="col-md-3 text-center"><b>Winning No.</b></div>
                    </div>
                    @if (count($userNumbers))
                    @foreach ($userNumbers as $userNumber)
                        <div class="row">
                            <div class="col-md-6 text-primary font-weight-bold">{{ Config::get('luckydraw.winnerTypes')[$userNumber->winner_type] }}</div>
                            <div class="col-md-3 text-center">{{ $userNumber->user->name }}</div>
                            <div class="col-md-3 text-center">{{ str_pad($userNumber->number, 4, '0', STR_PAD_LEFT) }}</div>
                        </div>
                    @endforeach      
                    @else
                        <div class="row">
                            <div class="col-md-12">No winners yet.</div>
                        </div>
                    @endif                  
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
