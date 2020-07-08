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
                        <div class="col-lg-1">
                          <div id="line_top_x" class="col-lg-81"></div>
                        </div>
                    </div>
                </form>
    
                <div class="box-body">
                    <table id="GridFipe" class="table table-condensed table-striped table-hover table-bordered">
                        <thead>
                            <tr>
                                <th</th>
                            </tr>
                        </thead>
                        <tbody>

                      

                        @forelse ($fipe_modelos as $fipe_modelo)
                          <tr>
                            <td>
                           
                    <article class="mb-3">
                        <!-- Default unchecked -->
                          <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" id="estaSelecionado-{{ $fipe_modelo->_source['codigo_fipe'] }}-{{ $fipe_modelo->_source['ano_modelo'] }}">
                             
                              <label class="custom-control-label" for="estaSelecionado-{{ $fipe_modelo->_source['codigo_fipe'] }}-{{ $fipe_modelo->_source['ano_modelo'] }}"><h4>{{ $fipe_modelo->_source['modelo'] }} </h4></label>
                          </div>
                          <div id="confirmacao-{{ $fipe_modelo->_source['codigo_fipe'] }}-{{ $fipe_modelo->_source['ano_modelo'] }}" style="display:none">O checkbox está selecionado</div>
                        <p class="m-0">{{ $fipe_modelo->_source['codigo_fipe'] }}</body>

                        <div>
                        Ano: {{ $fipe_modelo->_source['ano_modelo'] }} - Tipo: {{ $fipe_modelo->_source['tipo_veiculos'] }}
                        </div>
                    </article>
                    </td>
                    </tr>
                    @empty
                        <p></p>
                    @endforelse
                            </td>
                        </tbody>
                     </table>
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
    
      google.charts.load('current', {'packages':['line']});
      google.charts.setOnLoadCallback(drawChart);
    

    function drawChart(data) {

      if (typeof data === "undefined") {
         var data = new google.visualization.DataTable();
         data.addColumn('number', 'Meses');
         data.addColumn('number', '2018');
         data.addColumn('number', '2020');
         data.addColumn('number', '2019');

         data.addRows([
         [1,  0, 0, 0],
         [2,  0, 0, 0],
         [3,  0, 0, 0],
         [4,  0, 0, 0],
         [5,  0, 0, 0],
         [6,  0, 0, 0],
         [7,  0, 0, 0],
         [8,  0, 0, 0],
         [9,  0, 0, 0],
         [10,  0, 0, 0],
         [11,  0, 0, 0],
         [12,  0, 0, 0]
       ]);

/*
         data.addRows([
         [1,  , 80.8, 41.8],
         [2,  , 69.5, 32.4],
         [3,  ,   57, 25.7],
         [4,  , 18.8, 10.5],
         [5,  , 17.6, 10.4],
         [6,  , 13.6,  7.7],
         [7,   7.6, 12.3,  9.6],
         [8,  12.3, 29.2, 10.6],
         [9,  16.9, 42.9, 14.8],
         [10, 12.8, 30.9, 11.6],
         [11,  5.3,  7.9,  4.7],
         [12,  6.6,  8.4,  5.2]
       ]);
*/

/*
         data.addRows([
         [1,  0, 0, 0],
         [2,  0, 0, 0],
         [3,  0, 0, 0],
         [4,  0, 0, 0],
         [5,  0, 0, 0],
         [6,  0, 0, 0],
         [7,  0, 0, 0],
         [8,  0, 0, 0],
         [9,  0, 0, 0],
         [10,  0, 0, 0],
         [11,  0, 0, 0],
         [12,  0, 0, 0]
       ]);
       */
       
/*
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
         [12,  6.6,  8.4,  5.2]
       ]);
*/
//       console.log(data);

      } 

      var options = {
        chart: {
            title: 'Movimentação de Valores de Veiculos no Periodo',
            subtitle: 'preço em Reais'
        },
        width: 800,
        height: 400,
        axes: {
          x: {
            0: {side: 'botton'}
          }
        }
      };

      var chart = new google.charts.Line(document.getElementById('line_top_x'));

      chart.draw(data, google.charts.Line.convertOptions(options));
    }

// var _token = $('meta[name="_token"]').attr('content');
 $(document).ready(function(){

      var inputs = $('[type="checkbox"]'); // colocar os inputs em cache
      var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

      inputs.on('click', function() {        
        var id = $(this).attr('id');
        var vModelo_cod_fipe = id.substr(16, 8);
        var vAno_modelo = id.substr(25, 4);
        inputs.get().forEach(function(el) { 
              el.checked = el == this && this.checked; 
        }, this);
 
       
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
          url: '/postajax',
          type: 'POST',
          dataType: 'JSON',
          data: {  _token: CSRF_TOKEN, 
                  message:'paulopaulo',
          modelo_cod_fipe: vModelo_cod_fipe, 
               ano_modelo: vAno_modelo
          },
          cache: false,
          async: false,
          success: function (response) {
              console.log(response[4][0] + ',' + response[4][1] + ',' + response[4][2]);
              console.log(response);

              var data = new google.visualization.DataTable();
              data.addColumn('number', response[0].toString());
              data.addColumn('number', response[1].toString());
              data.addColumn('number', response[2].toString());
              data.addColumn('number', response[3].toString());

              data.addRows([
                   [1,response[4][0],response[4][1],response[4][2]],
                   [2,response[5][0],response[5][1],response[5][2]],
                   [3,response[6][0],response[6][1],response[6][2]],
                   [4,response[7][0],response[7][1],response[7][2]],
                   [5,response[8][0],response[8][1],response[8][2]],
                   [6,response[9][0],response[9][1],response[9][2]],
                   [7,response[10][0],response[10][1],response[10][2]],
                   [8,response[11][0],response[11][1],response[11][2]],
                   [9,response[12][0],response[12][1],response[12][2]],
                   [10,response[13][0],response[13][1],response[13][2]],
                   [11,response[14][0],response[14][1],response[14][2]],
                   [12,response[15][0],response[15][1],response[15][2]],
              ]);
              drawChart(data);
          },
          error: function () {
              alert("Servido indisponível. Por favor tente novamente mais tarde.");
            }
        });
    });
  });  

    </script>

@stop
