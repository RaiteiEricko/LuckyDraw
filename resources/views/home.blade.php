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
                <div class="card-header">Dashboard</div>
            
                <form method="POST" action="{{ route('save-number') }}">
                <div class="card-body">
                    <div class="form-group row">
                        <label for="number" class="col-md-4 col-form-label text-md-right">Enter Lucky Draw Number</label>
                            @csrf
                            <div class="col-md-3">
                                <input id="number" type="text" class="form-control" name="number" required>
                            </div>

                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                    </div>
                </div>
                </form>
            </div>

            <div class="card mt-3">
                <div class="card-header">My Lucky Draw Numbers</div>

                <div class="card-body">
                    <div class="row">
                        @foreach ($userNumbers as $userNumber)
                            <div class="col-md-3">{{ str_pad($userNumber->number, 4, '0', STR_PAD_LEFT) }}</div>
                        @endforeach                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
