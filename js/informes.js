var informe=null;
//------------------------------------------------------------------------------------------------------//
//------------------------------------------------------------------------------------------------------//
//------------------------------------------------------------------------------------------------------//
//-------------------------informe de Errores -----------------------////////////////
$("a[name='Search_Error_inform']").click(function(){
    $("#error_form").valid();
    var errors = validator.numberOfInvalids();
    if (errors==0) 
        {
            var sistema=$("select[name='Error_sistema']").val();
            var claves=$("input[name='error_clave']").val();
            informe="Errores";
            localStorage.setItem("informe", informe);
            claves=(claves.length>0)?claves : 0;
            post('info_pdf.php',{sistem: sistema, pass: claves , informe: informe}); 
        } 
    else
    {
        console.log("hay errores en el formulario ("+errors+")");
    }
    
});
//-------------------------informe de Soluciones -----------------------////////////////

$("a[name='Search_Solve_Inform']").click(function(){
    $("#solve_form").valid();
    var errors = validator_solve.numberOfInvalids();
    if (errors==0) 
        {
            var sistema=$("select[name='solve_sistema']").val();
            var claves=$("input[name='solve_clave']").val();
            var cod_sol=$("input[name='solve_codigo']").val();
            informe="solves";
            localStorage.setItem("informe", informe);
            claves=(claves.length>0)?claves : 0; 
            cod_sol=(cod_sol.length>0)?cod_sol :0; 
            console.log(sistema+"--"+cod_sol);
            post('info_pdf.php',{sistem: sistema, pass: claves , informe: informe, codigo_sol: cod_sol});        
        } 
    else 
    {
         console.log("hay errores en el formulario ("+errors+")");
    }
       
});
//-------------------------informe de Versiones -----------------------////////////////

$("a[name='Search_ver_inform']").click(function(){
    $("#ver_form").valid();
    var errors = validator_ver.numberOfInvalids();
    if (errors==0) 
        {
            var sistema=$("select[name='ver_sistema']").val();
            var claves=$("input[name='ver_clave']").val();
            informe="versiones";
            localStorage.setItem("informe", informe);
            claves=(claves.length>0)?claves : 0; 
            console.log(sistema+"--"+claves);
            post('info_pdf.php',{sistem: sistema, pass: claves , informe: informe});        
        } 
    else 
    {
         console.log("hay errores en el formulario ("+errors+")");
    }
       
});


// validar formulario de informes de errores 
 if ($("#error_form").length) 
        {
           var validator=$("#error_form").validate({
                                      rules: {
                                        Error_sistema: {
                                                        required: true,
                                                        },
                                        
                                            },
                                    messages:{
                                        Error_sistema: {
                                                        required:"debe seleccionar un sistema para consultar",
                                                        }
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
// validar formulario de informes de Solciones 
 if ($("#solve_form").length) 
        {
           var validator_solve=$("#solve_form").validate({
                                      rules: {
                                        solve_sistema: {
                                                        required: true,
                                                        },
                                        
                                            },
                                    messages:{
                                        solve_sistema: {
                                                        required:"debe seleccionar un sistema para consultar",
                                                        }
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
// validar formulario de informes de Solciones 
 if ($("#ver_form").length) 
        {
           var validator_ver=$("#ver_form").validate({
                                      rules: {
                                        ver_sistema: {
                                                        required: true,
                                                        },
                                        
                                            },
                                    messages:{
                                        ver_sistema: {
                                                        required:"debe seleccionar un sistema para consultar",
                                                        }
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

//funcion  post para generar los reportes 
function post(path, params, method) {
                method = method || "post"; // Set method to post by default if not specified.

                // The rest of this code assumes you are not using a library.
                // It can be made less wordy if you use one.
                var form = document.createElement("form");
                form.setAttribute("method", method);
                form.setAttribute("action", path);
                form.setAttribute("target", "_blank");

                for(var key in params) {
                    if(params.hasOwnProperty(key)) {
                        var hiddenField = document.createElement("input");
                        hiddenField.setAttribute("type", "hidden");
                        hiddenField.setAttribute("name", key);
                        hiddenField.setAttribute("value", params[key]);

                        form.appendChild(hiddenField);
                     }
                }

                document.body.appendChild(form);
                form.submit();
            }
//------------------------------------------------------------------------------------------------------//
//------------------------------------------------------------------------------------------------------//
//------------------------------------------------------------------------------------------------------//
//-------------------------informes paso a pdf -----------------------////////////////
//body > div.container > div:nth-child(1) > a
$("a[name='craft_pdf']").click(function(){
    //arrays to send to pdf
    informe=localStorage.getItem("informe");
    console.log(informe)
    var myTableArray =  new Array();
    var titles= new Array();
    var widthTitles= new Array();
    var titlehead= $("div.container>div:nth-child(2)>H3").text();
    
    //getdata of table's info_pdf
        $("div.container>div:nth-child(2)>table tr").each(function() {
            var arrayOfThisRow = [];
            var tableData = $(this).find('td');
            if (tableData.length > 0) {
                tableData.each(function() { arrayOfThisRow.push($(this).text()); });
                myTableArray.push(arrayOfThisRow);
            }
        });
    //array of titles
    //getdata of thead 
    $("div.container>div:nth-child(2)>table>thead>tr").each(function() {
            var arrayOfThisRow = [];
            var tableData = $(this).find('th');
            if (tableData.length > 0) {
                tableData.each(function() { arrayOfThisRow.push($(this).text()); });
                titles=arrayOfThisRow;
            }
        });


        //titles whidth's must sum 195
        console.log(titles.length);
       
        if (titles.length==7) 
        {
                widthTitles= [10,25,25, 55,30,30,20]; //195
        }
        else if(titles.length==8 && informe!="solves") 
        {
        	console.log("benderama");
        	console.log(informe);
        	widthTitles= [10,10,25,25, 45,30,30,20]; //195
         }
         else if(informe=="solves") 
        {
        	console.log("benderama2");
        	widthTitles= [10,10,25,55,30,30,15,20]; //195
         }     
         else 
        {
            widthTitles= [10,35, 75,35,20,20];   //180
        }
        
        var arrayJson = JSON.stringify(myTableArray);
        var arraytitles = JSON.stringify(titles);
        var arrayWtitles = JSON.stringify(widthTitles);
        //console.log(arrayJson);
        post('pro_create_pdf.php',{head: titlehead,widthTitles: arrayWtitles ,titles: arraytitles,data: arrayJson}); 
});