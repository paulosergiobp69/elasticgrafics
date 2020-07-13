@extends('layouts.app')

@section('content')
<div class="container">
<div class="card">
            <div class="card-header">
                Modelos de Veiculos - widget <small>({{ $fipe_modelos->count() }})</small>
            </div>
            <div class="card-body">
 <body>

<div  class="container-fluid cont-grafico">
<!--            <table class="table table-bordered table-striped text-center"> -->
            <table>
               <thead>
                <tr>
                  <th colspan="4" ><p class="text-left">Preço nos Portais</p></th>
                  <th colspan="3"><p class="text-left">Grafico Fipe</p></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                  <th colspan="4">
                  <table> 
                      <tr>
                        <th></th>
                        <th style="font-size:11px ">Menor Preço</th>
                        <th style="font-size:11px ">Preço Médio</th>
                        <th style="font-size:11px ">Maior Preço</th>
                      </tr>
                      <tr>
                        <th style="font-size:11px">iCarros</th>
                        <th style="background-color: #F0E68C;font-size:11px ">52.000,00</th>
                        <th style="background-color: #F0E68C;font-size:11px">55.000,00</th>
                        <th style="background-color: #F0E68C;font-size:11px">59.000,00</th>
                      </tr>
                      <tr>
                        <th style="font-size:11px">Web Motors</th>
                        <th style="background-color: #F0E68C;font-size:11px">52.000,00</th>
                        <th style="background-color: #F0E68C;font-size:11px">55.000,00</th>
                        <th style="background-color: #F0E68C;font-size:11px">59.000,00</th>
                      </tr>
                      <tr>
                        <th style="font-size:11px">RevendaMais</th>
                        <th style="background-color: #FFA500;font-size:11px">52.000,00</th>
                        <th style="background-color: #FFA500;font-size:11px">55.000,00</th>
                        <th style="background-color: #FFA500;font-size:11px">59.000,00</th>
                      </tr>
                    </table>
                  </th>
                  <th  colspan="4"><div id="grafics" style="border: none solid #ccc"></th>
                </tr>
                <tr>
                  <th colspan="4"  style="font-size:11px"><p class="text-left">Seu preço está 11% abaixo da FIPE (62.900,00)</p> <p class="text-left"> Seu preço está 6.8% acima da FIPE (62.900,00)</p></th>
                  <th colspan="3">
                    <table>
                      <tr>
                        <th style="font-size:11px">6 meses</th>
                        <th style="font-size:11px">12 meses</th>
                        <th style="font-size:11px">18 meses</th>
                        <th style="font-size:11px">Todos</th>
                      </tr>
                    </table>
                  </th>
                </tr>
                </tbody>
              </table>
            </div>


   <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
    

    var url_string = window.location.href;
    var url = new URL(url_string);
    var c = url.searchParams.get("Modelo_cod_fipe");
    var vModelo_cod_fipe = url.searchParams.get("Modelo_cod_fipe");
    var vAno_modelo = url.searchParams.get("Ano_modelo");

    console.log(vModelo_cod_fipe);
    console.log(vAno_modelo);


      google.charts.load('current', {'packages':['line']});
      google.charts.setOnLoadCallback(drawChart);
    

    function drawChart(data) {
//console.log('entrei 1');
//console.log(data);
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


      } 
     // chartArea:{left:20,top:0,width:'50%',height:'75%'}
     // original:
     /*
      var options = {
        chart: {
            title: 'Movimentação de Valores de Veiculos no Periodo',
            subtitle: 'preço em Reais'
        },
        width:  600,
        height: 300,
        axes: {
          x: {
            0: {side: 'botton'}
          }
        }
      };
      */
      var options = {
        chart: {
            title: 'Movimentação de Valores de Veiculos no Periodo',
            subtitle: 'preço em Reais'
        },
        width:  600,
        height: 300,
        axes: {
          x: {
            0: {side: 'botton'}
          }
        }
      };

//      var chart = new google.charts.Line(document.getElementById('line_top_x'));
      var chart = new google.charts.Line(document.getElementById('grafics'));
        // Instantiate and draw the chart for Sarah's pizza.

      chart.draw(data, google.charts.Line.convertOptions(options));
    }

// var _token = $('meta[name="_token"]').attr('content');
 $(document).ready(function(){
      //http://127.0.0.1:8000/search_widget?Modelo_cod_fipe=004384-2&Ano_modelo=2013
      var inputs = $('[type="checkbox"]'); // colocar os inputs em cache
      var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

      //inputs.on('click', function() {        
        var id = $(this).attr('id');
//        var vModelo_cod_fipe = id.substr(16, 8);
//        var vAno_modelo = id.substr(25, 4);


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
              //console.log(response[4][0] + ',' + response[4][1] + ',' + response[4][2]);
              //console.log(response);

              if (response[3] == null) {
                 response[3] = "2020";
              }

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
            // alert('E AI');
              drawChart(data);
          },
          error: function () {
              alert("Servido indisponível. Por favor tente novamente mais tarde.");
            }
        });
    //});
  });  

    </script>

@stop
