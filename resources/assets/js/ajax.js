$(document).on( "click", "a", function() {
	//alert( $(this).attr('href') );
	var str = $(this).attr('href');
    var res = str.substring(0, 1);
	
	if(res != '#'){
		//alert($(this).attr('href')); 
		//event.defaultPrevented();
		event.preventDefault();
		//alert('aqw34353453535434533e');
		AjaxDiv( $(this).attr('href') );
	} else {
		event.preventDefault();
	}
					
});


$( document ).on( "click", ".cancelar", function() {
	event.preventDefault();
	AjaxDiv($(this).attr('href'));			
});

$( document ).on( "click", ".excluir", function() {
	event.preventDefault();
	AjaxDiv($(this).attr('href'));			
});


$( document ).delegate($('input[type="submit"]') , 'click', function (event) {	
	 //$('input[type="submit"]').remove();
	 //$('button[type="submit"]').hide();
	 //alert('submit');
	 $('form').ajaxForm({
		 // target: alert('#preview'),
		  success: function(data){ 
		  		$('#Work').html(data);
		  		//CarregarJsForms();
		  },
          error:function(){
        	 mensagem('Ajax','Não foi possível executar ação ): !');
             //alert("Não foi possível inserir/alterar o representante!");
         } 
  	});
});

/*
 	$("body").removeClass("skin-blue");
 	$("body").removeClass("skin-black");
    $("body").removeClass("skin-red");
    $("body").removeClass("skin-yellow");
    $("body").removeClass("skin-purple");
    $("body").removeClass("skin-green");
    $("body").removeClass("skin-blue-light");
    $("body").removeClass("skin-black-light");
    $("body").removeClass("skin-red-light");
    $("body").removeClass("skin-yellow-light");
    $("body").removeClass("skin-purple-light");
    $("body").removeClass("skin-green-light");
    
    $("body").addClass("skin-blue");
	*/
//$(document).on("click", function(event){
	    //event.preventDefault();
	    //alert($(this).attr('href'));
		//ajaxWork($(this).attr('href'));			
	//});	
	
$(document).ready(function() {

}); 
  	





	function AjaxDiv(destino){ 
		//alert('AjaxDiv=>'+destino);
		$.post(destino, function(data) {
		  	$('#Work').html(data);		
		  	var uri = new Array(); 
		    if(destino.length > 0){
		   	 	uri = destino.split('/');
		   	} 
		   	  	
//		  	if(uri[uri.length-2] == 'Excluir'){
//		  		desabilitarTodos();
//		  		$('input[type="hidden"]').removeAttr('disabled');
//		  	} 
		  	//CarregarJsForms();
		});
	}
	

	function Informar(vCabecalho,vTexto){
		$('#myModalMensagem #CabecalhoDiv').html(vCabecalho);
		$('#myModalMensagem #MensagemDiv').html(vTexto);
		$('#myModalMensagem').modal('show');	 
	}


	function Confirmar(vTipo,vId){
		var url= "Ajax/confirmar/"+vTipo+"/"+vId;
		//alert(url);
		
		var request = $.ajax({
		  url: url,
		  type: "GET",
		  dataType: "json"
		});
		 
		//alert('2');
		request.done(function(data) {
		//alert('3');

				$.each(data, function(i, c) { 
					$('#myModalConfirma #CabecalhoDiv').html(c.cabecalho);
					$('#myModalConfirma #MensagemDiv').html(c.mensagem);
					$('#myModalConfirma #RunDiv').html(c.run);
					
/*                    $('#myModalAlertaSo #alertaSoFrom').html(c.apelido);
					$('#myModalAlertaSo #alertaSoMensagemDiv').html(c.message);
					
					
					$('#myModalAlertaSo input[name="alertaSoId"]').val(idMensagem);
					$('#myModalAlertaSo input[name="alertaSoId_usuario_to"]').val(c.id_usuario_to);
					$('#myModalAlertaSo input[name="alertaSoId_usuario_from"]').val(c.id_usuario_from);
					$('#myModalAlertaSo input[name="alertaSoId_SO"]').val(c.id_so);
					$('#myModalAlertaSo input[name="alertaSoId_Mensagem"]').val(c.message);
					$('#myModalAlertaSo input[name="alertaSoInterno"]').val(c.interno);
					$('#myModalAlertaSo input[name="alertaSoRedireciona"]').val(c.redireciona);
					
					$('#myModalAlertaSo textarea[name="alertaSoMensagem"]').val('') */
					$('#myModalConfirma').modal('show');	 
                });
		});		
	}

	function ConfirmarRun(){
		var vEndereco = $(".RunDiv").text();
		var RetData = $('#myModalConfirma input[name="data"]').val();
		if(RetData !== undefined){
			if(RetData !== ''){
		  		alert(RetData);
				vEndereco = vEndereco +'/'+ RetData;
			}	
		}
		alert(vEndereco);
		
		AjaxDiv(vEndereco);
	}
	
	
	function SelecionaEmpresa(){
		$('#myModalSelectEmp').modal('show');	 
	}
	

	function unformatNumber(pNum){
	    //return String(pNum).replace(/\D/g, "").replace(/^0+/, "");
	    //return String(pNum).replace(/\D/g, "").replace(/^0+/, "");
	    exp = /\.|\-|_|\//g;
		pNum = pNum.toString().replace( exp, "" ); 
		return pNum;
	}
	function isCpf(cpf) {
		var soma;
		var resto;
		var i;
		 
		 if ( (cpf.length != 11) ||
		 (cpf == "00000000000") || (cpf == "11111111111") ||
		 (cpf == "22222222222") || (cpf == "33333333333") ||
		 (cpf == "44444444444") || (cpf == "55555555555") ||
		 (cpf == "66666666666") || (cpf == "77777777777") ||
		 (cpf == "88888888888") || (cpf == "99999999999") ) {
		 return false;
		 }
		 
		 soma = 0;
		 
		 for (i = 1; i <= 9; i++) {
		 soma += Math.floor(cpf.charAt(i-1)) * (11 - i);
		 }
		 
		 resto = 11 - (soma - (Math.floor(soma / 11) * 11));
		 
		 if ( (resto == 10) || (resto == 11) ) {
		 resto = 0;
		 }
		 
		 if ( resto != Math.floor(cpf.charAt(9)) ) {
		 return false;
		 }
		 
		 soma = 0;
		 
		 for (i = 1; i<=10; i++) {
		 soma += cpf.charAt(i-1) * (12 - i);
		 }
		 
		 resto = 11 - (soma - (Math.floor(soma / 11) * 11));
		 
		 if ( (resto == 10) || (resto == 11) ) {
		 resto = 0;
		 }
		 
		 if (resto != Math.floor(cpf.charAt(10)) ) {
		 return false;
		 }
		 
		 return true;
	}
	function isCnpj(s){
		var i;
		var c = s.substr(0,12);
		var dv = s.substr(12,2);
		var d1 = 0;
		 
		 for (i = 0; i < 12; i++){
		 d1 += c.charAt(11-i)*(2+(i % 8));
		 }
		 
		 if (d1 == 0) return false;
		 
		 d1 = 11 - (d1 % 11);
		 
		 if (d1 > 9) d1 = 0;
		 if (dv.charAt(0) != d1){
		 return false;
		 }
		 
		 d1 *= 2;
		 
		 for (i = 0; i < 12; i++){
		 d1 += c.charAt(11-i)*(2+((i+1) % 8));
		 }
		 
		 d1 = 11 - (d1 % 11);
		 
		 if (d1 > 9) d1 = 0;
		 if (dv.charAt(1) != d1){
		 return false;
		 }
		 
		 return true;
	}
	function isCpfCnpj() {
		 var retorno = false;
		 var numero  = $('.isCpfCnpj').val();
		 numero = unformatNumber(numero);
		 if(numero==""){ return false; };

		 if (numero.length > 11){
			 if (isCnpj(numero)) {
				 retorno = true;
			 } else {
			 	Informar('Validação CNPJ','CNPJ informado é inválido !  <br><br><b>' + $('.isCpfCnpj').val());
				$('.ValidaCpfCnpj').val('');
			 }
		 } else {
			 if (isCpf(numero)) {
				 retorno = true;
			 } else {
			 	Informar('Validação CPF/CNPJ','CPF informado é inválido !  <br><br><b>' + $('.isCpfCnpj').val());
				$('.isCpfCnpj').val('');
			 }
		 }
		 return retorno;
	}



try {xmlhttp = new XMLHttpRequest();} catch(ee) { 
        try{xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");} catch(e) { 
                try{xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");} catch(E) 
{xmlhttp = false;} 
        } 
} 

	function carrega(_idContainer, _endereco){ 
        var tag_container = document.getElementById(_idContainer); 
        tag_container.innerHTML = ''; 
         
        xmlhttp.open('GET',_endereco,true); 
        xmlhttp.onreadystatechange = function() { 
                if (xmlhttp.readyState == 4){ 
                        retorno = xmlhttp.responseText; 
                        tag_container.innerHTML = retorno; 
                } 
        } 
        xmlhttp.send(null) 
    } 


	
					



	
	
	
	
	
