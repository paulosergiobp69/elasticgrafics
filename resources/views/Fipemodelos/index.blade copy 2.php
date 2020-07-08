@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                Modelos de Veiculos <small>({{ $fipe_modelos->count() }})</small>
            </div>
            <div class="card-body">
                <form action="{{ url('search_fipe') }}" method="get">
                    <div class="row justify-content-md-left">
                        <div class="col col-lg-3">
                        <input
                            type="text"
                            name="q"
                            class="form-control "
                            placeholder="Busca..."
                            value="{{ request('q') }}"
                        />
                        </div>
                        <div class="col-lg-2">
                          <div id="line_top_x"></div>
                        </div>
                    </div>
                  
                </form>
                    @forelse ($fipe_modelos as $fipe_modelo)
                    <article class="mb-3">
                        <h2>{{ $fipe_modelo->modelo_desc }}</h2>

                        <p class="m-0">{{ $fipe_modelo->modelo_cod_fipe }}</body>

                        <div>
                        Ano: {{ $fipe_modelo->ano_modelo }} - Tipo: {{ $fipe_modelo->tipo_id }}
                        </div>
                        <div id="line_top_x"></div>
                    </article>
                    @empty
                        <p>No articles found</p>
                    @endforelse
                </div>
                <nav aria-label="...">
  <ul class="pagination justify-content-center">
    <li class="page-item disabled">
      <span class="page-link">Anterior</span>
    </li>
    <li class="page-item"><a class="page-link" href="#">1</a></li>
    <li class="page-item active">
      <span class="page-link">
        2
        <span class="sr-only">(atual)</span>
      </span>
    </li>
    <li class="page-item"><a class="page-link" href="#">3</a></li>
    <li class="page-item">
      <a class="page-link" href="#">Próximo</a>
    </li>
  </ul>
</nav>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
   <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['line']});
      google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

      var data = new google.visualization.DataTable();
      data.addColumn('number', 'Day');
      data.addColumn('number', 'Guardians of the Galaxy');
      data.addColumn('number', 'The Avengers');
      data.addColumn('number', 'Transformers: Age of Extinction');

      data.addRows([
        [1,  37.8, 80.8, 41.8],
        [2,  30.9, 69.5, 32.4],
        [3,  25.4,   57, 25.7],
        [4,  11.7, 18.8, 10.5],
        [5,  11.9, 17.6, 10.4],
        [6,   8.8, 13.6,  7.7],
        [7,   7.6, 12.3,  9.6],
        [8,  12.3, 29.2, 10.6],
        [9,  16.9, 42.9, 14.8],
        [10, 12.8, 30.9, 11.6],
        [11,  5.3,  7.9,  4.7],
        [12,  6.6,  8.4,  5.2],
        [13,  4.8,  6.3,  3.6],
        [14,  4.2,  6.2,  3.4]
      ]);

      var options = {
        chart: {
          title: 'Movimentação de Valores de Veiculos no Periodo',
          subtitle: 'preço em Reais'
        },
        width: 900,
        height: 500,
        axes: {
          x: {
            0: {side: 'botton'}
          }
        }
      };

      var chart = new google.charts.Line(document.getElementById('line_top_x'));

      chart.draw(data, google.charts.Line.convertOptions(options));
    }

    </script>

@stop
