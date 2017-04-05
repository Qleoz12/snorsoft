//------------------------------------------------------------------------------------------------------//
//------------------------------------------------------------------------------------------------------//
//------------------------------------------------------------------------------------------------------//
//-------------------------codigo para empresas-----------------------////////////////

        var dataTable = $('#employee-grid').DataTable( {
          "pageLength": 50,
          "processing": true,
          "serverSide": true,
          "ajax":{
		            url :"fetch_empresas.php", // json datasource
		            type: "post",  // method  , by default get
		            error: function(){  // error handling
		              console.log("error ajax");
		              
		            }
          		},
           "columns": [
					    {"data" : 1},
					    {"data" : 2},
					    {"data" : 3},
					    {"data" : 4,  "defaultContent": "sin-datos"},
					    {"data" : 5,  "defaultContent": "sin-datos"},
					    {"data" : 6,  "defaultContent": "sin-datos"},
					    {"data" : null,  "defaultContent": "sin-datos", "visible":false},
					    {"data" : 7,  "defaultContent": "sin-datos"},
					    //{"data" : null,  "defaultContent": "<button>Click!</button>"} 
					    {"data" : null,  "defaultContent": '<a class="btn-floating btn waves-effect waves-light red"><i class="material-icons">add</i></a>'}
					  ]
	
        } );



      $("select").val('50');
  		$('select').addClass("browser-default");
  		$('select').material_select();


  		 $('#employee-grid tbody').on( 'click', 'a', function () {
		        var data = dataTable.row( $(this).parents('tr')).data();
		        var id=data[0];
		        console.log(data);
		        var url = "update_empresas.php?id="+id; 
				$(location).attr('href',url);
    		} );


  	/***************************************
  	code  for update_empresas.php update_empresas.html*/
  	

  	//versiones del financiero
	if($("[id=slctFnncr]").length)
	{
	    $("[id=slctFnncr]").load("fetch_sistems_financiero.php", function() {
	        $('select').material_select();
          var setop=$("[id=slctFnncr]").data("setted");
          setop=setop.toString();
          setop=reverseString(setop);
          setop=setop.slice(8);
          setop=reverseString(setop);
          var arrayvalues=[];
          $("select[id=slctFnncr] option").each(function()
          {
              arrayvalues.push($(this).val()); //to your list
          });
           if (setop.length==0 || arrayvalues.indexOf(setop)<0) 
           {
             $("[id=slctFnncr]").val();
           }
           else
           {
             $("[id=slctFnncr]").val(setop);
           }
		 });
	}
	//versiones del Comercial
	 if($("[id=slctCmrcl]").length)
	{
	    $("[id=slctCmrcl]").load("fetch_sistems_comercial.php", function() {
	        $('select').material_select();

          var setop=$("[id=slctCmrcl]").data("setted");
          setop=setop.toString();
          setop=reverseString(setop);
          setop=setop.slice(8);
          setop=reverseString(setop);
          var arrayvalues=[];
          $("select[id=slctCmrcl] option").each(function()
          {
              arrayvalues.push($(this).val()); //to your list
          });
           if (setop.length==0 || arrayvalues.indexOf(setop)<0) 
           {
             $("[id=slctCmrcl]").val();
           }
           else
           {
             $("[id=slctCmrcl]").val(setop);
           }
          

		 });
	}       

	// estado de pagos
	 if($("[id=slctpaid]").length)
	{
	    $("[id=slctpaid]").load("fetch_states_paids.php", function() {
	        $('select').material_select();
          var setop=$("[id=slctpaid]").data("setted");
          if (typeof setop !== 'undefined') 
          {
                  // the variable is defined
                  setop=setop.toString();
                  var arrayvalues=[];
                  $("select[id=slctpaid] option").each(function()
                  {
                      arrayvalues.push($(this).val()); //to your list
                  });
                   if (setop.length==0 || arrayvalues.indexOf(setop)<0) 
                   {
                     $("[id=slctpaid]").val();
                   }
                   else
                   {
                     $("[id=slctpaid]").val(setop);
                   }
          }
           

		 });
	}
  //state of the soft in the  companies
   if($("[id=slct_stt_s]").length)
  {
      var html="<option value='1'>No Actualizado</option>";
      html+="<option value='2'>Actualizado</option>";
      $("[id=slct_stt_s]").append(html);
  }


/***************************************
code  for lobby_informes.php */
if($("[id=empresa]").length)
{
     console.log($("[id=empresa]").length);
     $("[id=empresa]").load("fetch_sistemas.php", function() {
        $('select').material_select();
        //delete option in form of empresas
           var defa=$("[id=empresa]").find("option").eq(1).prev();
           var comer=$("[id=empresa]").find("option").eq(2);
           var finan=$("[id=empresa]").find("option").eq(6);
           $("[id=empresa]").find("option").remove();
           // $("[id=empresa]").append(sistems[0]);
           // $("[id=empresa]").append(sistems[1]);
           // console.log(comer);
           // console.log(finan);
           $("[id=empresa]").append(comer);
           $("[id=empresa]").append(finan);
            $("[id=empresa]").append(defa);
            
    });
}

// validar formulario de informes de Solciones 
 if ($("#empresas_form").length) 
        {
           var validator_empresas=$("#empresas_form").validate({
                                      rules: {
                                        slct_stt_s: {
                                                        required: true,
                                                        },
                                        empresas_sistema:{
                                                        required: true,
                                                        },
                                        slctpaid:{
                                                        required: true,
                                                        },              
                                        
                                            },
                                    messages:{
                                        slct_stt_s: {
                                                        required:"debe seleccionar un estado !!",
                                                        },
                                        empresas_sistema: {
                                                        required:"debe seleccionar un sistema a filtrar",
                                                        },
                                        slctpaid: {
                                                        required:"debe seleccionar un tipo de pago",
                                                        },

                                    },
                                    errorElement : 'div',
                                    errorPlacement: function(error, element) {
                                      var placement = $(element).data('error');
                                      if (placement) {
                                        $(placement).append(error)
                                      } else {
                                        error.insertAfter(element);
                                      }
                                    }
                                    });    
        }
//-------------------------code for generate informs-----------------------////////////////

$("a[name='Search_Empresas_inform']").click( function(){
  $("#empresas_form").valid();
  var errors = validator_empresas.numberOfInvalids();
   if (errors==0) 
   {
      console.log(errors);   
       var pago=$("select[name=slctpaid]").val();
       var estado=$("select[name=slct_stt_s]").val();
       var TipoSistema=$("select[name=empresas_sistema]").val();
       console.log(pago+"--"+estado+"--"+TipoSistema);
       var informe="Empresas";
       localStorage.setItem("informe", informe);
       post('info_pdf.php',{sistem: TipoSistema, informe: informe, pago: pago, estado: estado});
        
   }
   else
   {
     console.log("hay errores en el formulario ("+errors+")");
   }


});

//-------------------------codigo para  guardar cambios de empresas-----------------------////////////////

$( "a[name='update_empresas']").click( function() 
     {
         

        var formData;
        //cargar_log(nombre_error,sistema,E_error,fecha_error,desc_error);        
        formData = new FormData($("#formEmpresa")[0]);
        var version_financiero=$("select[name=sistema_f#] option:selected").text();
        var version_comercial=$("select[name=sistema_c#] option:selected").text();
        formData.append("version_financiero",version_financiero);
        formData.append("version_comercial",version_comercial);
        for(var pair of formData.entries()) 
        {
             console.log(pair[0]+ ', ' + pair[1]);
        }
        
        $.ajax({
                  url: 'pro_update_sistems_empresas.php',
                  data: formData,
                  processData: false,
                  contentType: false,
                  type: 'POST',
                   beforeSend: function () 
                   {
                        //$('#modal1').leanModal();
                        //$('#modal1').openModal({dismissible:false});
                        console.log("loading....");
                    },
                  success: function(data){
                    console.log(data);
                    //$('#modal1').closeModal();
                    window.location.replace("act_empresas.php");
                    
                  }
                });
                      
     });


/*

*/
function reverseString(str) {
    return str.split("").reverse().join("");
}
