@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="center"> Lista de Cursos</h3>
        <div class="row center" >
            @foreach($fipe_modelos as $fipe_modelo)
        <div class="col s12 m3">
          <div class="card">
            <div class="card-image">
              <img width="20" height="100" src="{{ $fipe_modelo->modelo_desc}}">
            </div>
            <div class="card-content">
                <h5>{{ $fipe_modelo->modelo_desc}}</h5>
                <p>{{ $fipe_modelo->modelo_desc}}</p>
            </div>
            <div class="card-action">
              <a href="#">Ver mais...</a>
            </div>
          </div>
        </div>
            @endforeach
      </div>
      <div class="row" align="center">
        {{}}
      </div>
	</div>

@endsection('content')