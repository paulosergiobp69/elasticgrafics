@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                Modelos de Veiculos <small>({{ $fipe_modelos->count() }})</small>
            </div>
            <div class="card-body">
                <form action="{{ url('search_fipe') }}" method="get">
                    <div class="form-group">
                        <input
                            type="text"
                            name="q"
                            class="form-control"
                            placeholder="Busca..."
                            value="{{ request('q') }}"
                        />
                    </div>
                </form>
                @forelse ($fipe_modelos as $fipe_modelo)
                    <article class="mb-3">
                        <h2>{{ $fipe_modelo->modelo_desc }}</h2>

                        <p class="m-0">{{ $fipe_modelo->modelo_cod_fipe }}</body>

                        <div>
                        sem nada
                        </div>
                    </article>
                @empty
                    <p>No articles found</p>
                @endforelse
            </div>
        </div>
    </div>
@stop
