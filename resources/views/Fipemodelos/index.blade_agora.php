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
                
                    @forelse ($fipe_modelos as $fipe_modelo)
                  
                    <article class="mb-3">
                        <!-- Default unchecked -->
                          <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" id="estaSelecionado-{{ $fipe_modelo['codigo_fipe'] }}-{{ $fipe_modelo->ano_modelo }}">
                             
                              <label class="custom-control-label" for="estaSelecionado-{{ $fipe_modelo->modelo_cod_fipe }}-{{ $fipe_modelo->ano_modelo }}"><h4>{{ $fipe_modelo->modelo_desc }} </h4></label>
                          </div>
                          <div id="confirmacao-{{ $fipe_modelo->modelo_cod_fipe }}-{{ $fipe_modelo->ano_modelo }}" style="display:none">O checkbox está selecionado</div>
                        <p class="m-0">{{ $fipe_modelo->modelo_cod_fipe }}</body>

                        <div>
                        Ano: {{ $fipe_modelo->ano_modelo }} - Tipo: {{ $fipe_modelo->tipo_id }}
                        </div>
                    </article>
                    @empty
                        <p>No articles found</p>
                    @endforelse
                </div>
                <div class="row">
                  <div class="col-md-3">
                      
                  </div>
                  <div class="col-md-3">
                
                  </div>
                </div>
  <!--
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
-->
            </div>
        </div>
    </div>

   <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
    /*
    $("#GridDepartamento").dataTable({
        "oLanguage": {
            "sLengthMenu": 'Mostrar <select>' +
                    '<option value="05">05</option>' +
                    '<option value="10">10</option>' +
                    '<option value="15">15</option>' +
                    '<option value="20">20</option>' +
                    '<option value="25">25</option>' +
                    '<option value="30">30</option>' +
                    '<option value="35">35</option>' +
                    '<option value="40">40</option>' +
                    '<option value="45">45</option>' +
                    '<option value="-1">Todos</option>' +
                    '</select> registros',
            "sZeroRecords": "Nenhum registro encontrado - desculpe",
            "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando 0 a 0 de 0 registros",
            "sInfoFiltered": "(Filtrado de _MAX_ registros no total)",
            "sSearch": "Pesquisar",
            "sEmptyTable": "Não existe registros",
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "oPaginate": {
                "sFirst": "Primeira",
                "sPrevious": "Anterior",
                "sNext": "Próxima",
                "sLast": "Última",
            }
        },
        "bPaginate": true,
        "aaSorting": [[0, "asc"]]
    });
    */



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

       console.log(data);

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
