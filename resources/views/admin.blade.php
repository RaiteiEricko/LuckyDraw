@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div><br />
            @endif
            <div class="card">
                <div class="card-header">Admin Dashboard</div>

                <form method="POST" action="{{ route('draw-winner') }}">
                @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="type" class="col-md-4 col-form-label text-md-right">Prize Types <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <select class="form-control" id="type" name="type">
                                    <option value="">- Please Select -</option>
                                    @foreach (Config::get('luckydraw.winnerTypes') as $key => $text)
                                    <option value="{{ $key }}">{{ $text }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="number" class="col-md-4 col-form-label text-md-right">Winning Number <br/>(empty to auto generate)</label>
                            <div class="col-md-6">
                                <input id="number" type="text" class="form-control" name="number">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card mt-3">
                <div class="card-header">Winners</div>

                <div class="card-body">
                    @if (count($userNumbers))
                    @foreach ($userNumbers as $userNumber)
                        <div class="row">
                            <div class="col-md-6">{{ Config::get('luckydraw.winnerTypes')[$userNumber->winner_type] }}</div>
                            <div class="col-md-3">{{ $userNumber->user->name }}</div>
                            <div class="col-md-3">{{ str_pad($userNumber->number, 4, '0', STR_PAD_LEFT) }}</div>
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
