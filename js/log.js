//get informative data from DB for Version charge
// number of pages
var count;
// number of records
var Tcount;
// sistem select
var TypeSistem;
//value of pagination bar
var Rpage;
////////////////////////////////////////////////////////////////////////////////////////////
//-------------------------log de errores resultados-----------------------////////////////
if ($('.listanav_log').length)
    {
	    console.log("log de errores");
	    $.post("other.php", {basspass:2})
	            .done(function( data ) 
	            {
	                count=data.data.pages;
	                Tcount=data.data.TotalRecords;
	                console.log(count+"---"+Tcount);
	                
	                    $('.listanav_log').materializePagination({
	                        align: 'left',
	                        lastPage: count,
	                        firstPage:  1,
	                        urlParameter: 'page',
	                        useUrlParameter: true,
	                        onClickCallback: function(requestedPage)
	                        {
	                            $(".lista_log").load("fetch_pages_log.php",{"page":requestedPage},function(){
	                                //images make more cool this is for log_errores    
	                            $('img.materialboxed').materialbox();
	                            $( "a[name='response']").click(function() 
	                            {
	                                id_response=this.dataset.row;
	                                id_sis=this.dataset.sis;
	                                localStorage.setItem("id_response", id_response);
	                                localStorage.setItem("id_sis", id_sis);
	                                
	                                window.location.replace("response.php");
	                            
	                            });
	                            });
	                            Rpage=requestedPage;
	                            
	                        }   
	                    }); //end pagination 
	            });  //end done
     }
//     else 
//     {
//         console.log("no log  or no lista_log");
//    }   



//-------------------------eventos  del select-----------------------////////////////
//select sistems events
    $('.sistema_log').on('change', function(e) 
    { 
        TypeSistem=this.value;
        
        if (TypeSistem==999) 
        {

            console.log("999");
	    	
	    	$.post("other.php", {basspass:2})
	            .done(function( data ) 
	            {
	                count=data.data.pages;
	                Tcount=data.data.TotalRecords;
	                console.log(count+"---"+Tcount);
	                	$('.listanav_log').empty();
	                    $('.listanav_log').materializePagination({
	                        align: 'left',
	                        lastPage: count,
	                        firstPage:  1,
	                        urlParameter: 'page',
	                        useUrlParameter: true,
	                        onClickCallback: function(requestedPage)
	                        {
	                        	
	                            $(".lista_log").load("fetch_pages_log.php",{"page":requestedPage},function(){
	                                //images make more cool this is for log_errores    
	                            $('img.materialboxed').materialbox();
	                            $( "a[name='response']").click(function() 
	                            {
	                                id_response=this.dataset.row;
	                                id_sis=this.dataset.sis;
	                                localStorage.setItem("id_response", id_response);
	                                localStorage.setItem("id_sis", id_sis);
	                                
	                                window.location.replace("response.php");
	                            
	                            });
	                            });
	                            Rpage=requestedPage;
	                            
	                        }   
	                    }); //end pagination 
	            });  //end done
        }
        else
        {
            console.log("filter");
	    	console.log(TypeSistem);
	    	$.post("other.php", {basspass:2,sistema:TypeSistem})
	            .done(function( data ) 
	            {
	                count=data.data.pages;
	                Tcount=data.data.TotalRecords;
	                console.log(count+"---"+Tcount);
	                $('.listanav_log').empty();
	                 if (count>0) 
	                 {
	                 	$('.listanav_log').materializePagination({
	                        align: 'left',
	                        lastPage: count,
	                        firstPage:  1,
	                        urlParameter: 'page',
	                        useUrlParameter: true,
	                        onClickCallback: function(requestedPage)
	                        {
	                        	
	                            $(".lista_log").load("fetch_pages_log.php",{"page":requestedPage,"sistema": TypeSistem},function(){
	                                //images make more cool this is for log_errores    
	                            $('img.materialboxed').materialbox();
	                            $( "a[name='response']").click(function() 
	                            {
	                                id_response=this.dataset.row;
	                                id_sis=this.dataset.sis;
	                                localStorage.setItem("id_response", id_response);
	                                localStorage.setItem("id_sis", id_sis);
	                                
	                                window.location.replace("response.php");
	                            
	                            });
	                            });
	                            Rpage=requestedPage;
	                            
	                        }   
	                    }); //end pagination 
	                 } 
	                 else 
	                 {
	                 	$('.lista_docs').empty();
	                 	console.log("no hay  info wey");
	                 	var temple="No hay información para el sistema seleccionado";
	                 	$('.lista_docs').text(temple);
	                 }
	                    
	            });  //end done
        }
    });
 /////////////////////////////////////////////////////////////////
    //-------------------------log de errores-----------------------/
     if ($("#formValidate").length ) 
        {
            var validator =$("#formValidate").validate({
                    rules: {
                        nombre_error: {
                            required: true,
                            minlength: 5
                        },
                        E_error: {
                            required: true,
                            minlength: 5  
                        },
                        log_sistema:"required",
                        log_descrip: {
                            required: true,
                            minlength: 20, 
                            maxlength: 1000
                        },
                        fecha_error:"required",
                    
                    },
                    //For custom messages
                    messages: {
                        nombre_error:{
                            required: "ingrese un nombre de error",
                            minlength: "debe contener almenos 5 caracteres"
                        },
                        E_error: {
                            required: "debe ingresar por lo menos una etiqueta",
                            minlength: "debe contener almenos 5 caracteres"  
                        },
                        log_sistema: {
                            required: "debe seleccionar un sistema",
                        },
                        log_descrip: {
                            required: "debe explicar algo del error",
                            minlength: "debe ser mas larga la descripcion",
                            maxlength: "se ha pasado del tamaño permitido"  
                        },
                        fecha_error:
                        {
                            required: "debe selccionar la fecha del suceso",
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
$('.datepicker').pickadate({
                                selectMonths: true, // Creates a dropdown to control month
                                selectYears: 25 // Creates a dropdown of 15 years to control year
                                });


//-------------------------Crear Log de Error-----------------------////////////////
     $( "a[name='subir_log']").click( function() 
     {
         // body...
        var displayDate;
        var myDate = new Date();
        var formData;
        //cargar_log(nombre_error,sistema,E_error,fecha_error,desc_error);
        $("#formValidate").valid();
        var errors = validator.numberOfInvalids();
        
        if (errors>0) 
        {
         console.log("hay "+errors+"en la pagina");   
        } 
        else 
        {
            console.log("No hay errores en la pagina");
            formData = new FormData($("#formValidate")[0]);
            displayDate = (myDate.getDate())+"-"+(myDate.getMonth()+1)+"-"+ myDate.getFullYear()+'--'+myDate.getHours()+'!'+myDate.getMinutes()+'!'+myDate.getSeconds();        
            formData.append("fechaactual",displayDate);
            fileCollectionD.sort(sortNumber);
            fileCollectionD.reverse();
            // process to delete imges remove by user
            for(index in fileCollectionD)
            {   
                
                fileCollection.splice(fileCollectionD[index],1);   
            }
            // delete the images loaded from page
            formData.delete("images[]");
            //load the images for to upload
            for(index in fileCollection)
            {
                formData.append("images[]",fileCollection[index]);
            }

            for(var pair of formData.entries()) 
            {
                 console.log(pair[0]+ ', ' + pair[1]);
            }
            
            
            var request = new XMLHttpRequest();
            request.open('post', 'pro_cargar_log.php', true);
            request.send(formData);
            window.location.replace("log.php");
        }
        
        
     });



//------------------------------------------------------------------------------------------------------//
//------------------------------------------------------------------------------------------------------//
//------------------------------------------------------------------------------------------------------//
// diseño de cargue de imagenes
 

//------------------------------------------------------------------------------------------------------//
    //Cargue de imagenes para crear log de errores 
//------------------------------------------------------------------------------------------------------//
//indirect ajax
        //file collection array
        var fileCollection = new Array();
        //file collection array the files to delete
        var fileCollectionD = new Array();
        function sortNumber(a,b) 
        {
            return a - b;
        }
        $('#images').on('change',function(e)
        {
            var files = e.target.files;
            $.each(files, function(i, file){
                fileCollection.push(file);
                var index=fileCollection.indexOf(file);
                var reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function(e){
                    var template ='<div>'+'<div class="col s12 blue darken-3 mycenter"> <img class="materialboxed responsive-img" data-caption=" " width="190" src="'+e.target.result+'"> </div> '+
                        '<label>descripcion de imagen</label>'+
                        '<input type="text" name="title">'+
                        '<a class="waves-light btn"  data-index="'+index+'" name="removeimg">Remove</a>'+' <br><br></div> ';
                    $('#images-to-upload').append(template);
                    $('.materialboxed').materialbox();
                    document.getElementById("images").value = "";
                };
            });
        });
        
    
//         // agregar caption a la imagen    
//         $("div[name='images-to-upload']").on('keyup', "input[name='title']", function (e) {
//             //console.log($(this).prev().prev().find(".materialboxed"));
//             $(this).prev().prev().find(".materialboxed").data("caption",$(this).val());
//         });

        // quitar imagenes cargadas por error
        $("div[name='images-to-upload']").on('click', "a[name='removeimg']", function (e) {            
            $(this).parent().remove();
            var index=$(this).data("index");
            fileCollectionD.unshift(index);
            
        });
//------------------------------------------------------------------------------------------------------//
    //Cargue de archivos para soluciones a log de errores 
//------------------------------------------------------------------------------------------------------//
//indirect ajax
       
//file collection array
        var fileCollection_sol = new Array();
        //file collection array the files to delete
        var fileCollectionD_sol = new Array();
        $('#files_sol').on('change',function(e)
        {
            var files = e.target.files;
            $.each(files, function(i, file){
                fileCollection_sol.push(file);
                var index=fileCollection_sol.indexOf(file);
                var reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function(e){
                    var template ='<div>'+'<div class="chip" data-index="'+index+'">'+file.name+'<i class="close material-icons">close</i></div>'+'</div>';
                    $('#files_sol-to-upload').append(template);
                                        
                };
            });            
        });

        // quitar imagenes cargadas por error
        $("div[name='files_sol-to-upload']").on('click', "div[class='chip']", function (e) {            
            var index=$(this).data("index");
            fileCollectionD_sol.unshift(index);
            
        });

// //------------------------------------------------------------------------------------------------------//
// //------------------------------------------------------------------------------------------------------//
// //------------------------------------------------------------------------------------------------------//
// //-------------------------soluciones a logs cargue-----------------------////////////////

$( "a[name='subir_response']").click(function() 
{
    
    var id=localStorage.getItem("id_response");
    var id_sis=localStorage.getItem("id_sis");
    var form=$("#form_response"[0]);
    var form_Data = new FormData($("#form_response")[0]);
    var myDate = new Date();

    form_Data.append("id",id);
    form_Data.append("id_sistema",id_sis);
    displayDate = (myDate.getDate())+"-"+(myDate.getMonth()+1)+"-"+ myDate.getFullYear()+'--'+myDate.getHours()+'!'+myDate.getMinutes()+'!'+myDate.getSeconds();        
    form_Data.append("fechaactual",displayDate);
    fileCollectionD_sol.sort(sortNumber);
    fileCollectionD_sol.reverse();
    // process to delete imges remove by user
    for(index in fileCollectionD_sol)
    {   
        fileCollection_sol.splice(fileCollectionD_sol[index],1);   
    }
    // delete the files loaded from page
    form_Data.delete("files_sol[]");
    //load the images for to upload
    for(index in fileCollection_sol)
    {
        form_Data.append("files_sol[]",fileCollection_sol[index]);
    }
    for(var pair of form_Data.entries()) 
    {
          console.log(pair[0]+ ', ' + pair[1]);
    }
    console.log(id+"----"+id_sis);
    var request = new XMLHttpRequest();
    request.open('post', 'pro_response_log.php', false);
    request.send(form_Data);
    $( ".Form_R").fadeOut( "slow" );
    $( "a[name='open_form']").fadeIn( "slow" );
    $(".lista_response").load("fetch_response_log.php",{"id_response":id,"id_sis":id_sis },function(){});
});

$( "a[name='return_response']").click(function()
    {
     window.location.replace("log.php");   
 });

// //------------------------------------------------------------------------------------------------------//
// //------------------------------------------------------------------------------------------------------//
// //------------------------------------------------------------------------------------------------------//
// //-------------------------resultados a logs -----------------------////////////////
if ($('.lista_response').length) 
{       var id=localStorage.getItem("id_response");
        var id_sis=localStorage.getItem("id_sis");
        $(".lista_response").load("fetch_response_log.php",{"id_response":id,"id_sis":id_sis },function(){}); 
        $( ".Form_R").hide();
} 
$( "a[name='open_form']").click(function()
{
     $( ".Form_R").fadeIn( "slow" );
     $(this).fadeOut( "slow" );
});
    

// //------------------------------------------------------------------------------------------------------//
// //------------------------------------------------------------------------------------------------------//
// //------------------------------------------------------------------------------------------------------//
// //-------------------------searh by keydata logs -----------------------////////////////
if ($('#key_search_log').length) 
{
     
    $('#key_search_log').keyup(function() 
    {   


        // valor de  el dato buscado en log de errores
        var val=$(this).val();
        console.log("keyup filter");
            console.log(TypeSistem);
            $.post("other.php", {basspass:2,keyval:val})
                .done(function( data ) 
                {
                    count=data.data.pages;
                    Tcount=data.data.TotalRecords;
                    console.log(count+"---"+Tcount);
                    $('.listanav_log').empty();
                     if (count>0) 
                     {
                        $('.listanav_log').materializePagination({
                            align: 'left',
                            lastPage: count,
                            firstPage:  1,
                            urlParameter: 'page',
                            useUrlParameter: true,
                            onClickCallback: function(requestedPage)
                            {
                                
                                $(".lista_log").load("fetch_pages_log.php",{"page":requestedPage, "keyval":val},function(){
                                    //images make more cool this is for log_errores    
                                $('img.materialboxed').materialbox();
                                $( "a[name='response']").click(function() 
                                {
                                    id_response=this.dataset.row;
                                    id_sis=this.dataset.sis;
                                    localStorage.setItem("id_response", id_response);
                                    localStorage.setItem("id_sis", id_sis);
                                    
                                    window.location.replace("response.php");
                                
                                });
                                });
                                Rpage=requestedPage;
                                
                            }   
                        }); //end pagination 
                        }
                                });
                                 
    }); // end keyup        
} 


    

// //     (function () {
// //     var ids   = {};
// //     var found = false;
// //     $('[name]').each(function () {
// //         var id = $(this).attr("id");
// //         if (id && ids[id]) {
// //             found = true;
// //             console.warn('Duplicate ID #' + id);
// //         }
// //         ids[id] = 1;
// //     });
// //     if (!found) console.log('No duplicate IDs found');
// // })();  