@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        
        @if (Auth::user()->idRole ==2)
        <reporte-empleado us_id=" {{ Auth::user()->id }}"/>
                           
                        @else
           <reporte-entradas-salidas/>

           @endif
        
    </div>
</div>
@endsection
