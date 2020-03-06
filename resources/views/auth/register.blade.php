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
                </div>
            @endif
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>
               
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }} *</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}"  autocomplete="name" autofocus>

                               
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }} *</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autocomplete="email">

                               
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="raffle_type" class="col-md-4 col-form-label text-md-right">{{ __('Raffle Type') }} *</label>

                            <div class="col-md-6">
                               
                                <select  name="raffle_type" id="raffle_type" class="form-control" >
                                    <option value="">--Select a Type--</option>
                                        @foreach($rafflestypes as $type)
                                            <option value="{{$type->slug}}">{{$type->name}}</option>
                                        @endforeach                
                                </select>

                              
                            </div>
                        </div>
                        

                        

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
