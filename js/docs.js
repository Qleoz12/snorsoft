//get informative data from DB for Version charge
// number of pages
var count;
// number of records
var Tcount;
// sistem select
var TypeSistem;
//value of pagination bar
var Rpage;
//value of pagination bar
var i_p_pages;

////////////////////////////////////////////////////////////////////////////////////////////
//-------------------------log de errores resultados-----------------------////////////////
if ($('.listanav_docs').length)
    {
	    console.log("modulo de documentación");
	    $.post("other.php", {basspass:4})
	            .done(function( data ) 
	            {
	                count=data.data.pages;
	                Tcount=data.data.TotalRecords;
	                i_p_pages=data.data.item_per_page;
	                console.log(count+"---"+Tcount+"---"+i_p_pages);
	                
	                  
	                if (count>0) 
	                {
	                    $('.listanav_docs').materializePagination({
	                        align: 'left',
	                        lastPage: count,
	                        firstPage:  1,
	                        urlParameter: 'page',
	                        useUrlParameter: true,
	                        onClickCallback: function(requestedPage)
	                        {
	                            $(".lista_docs").load("fetch_docs_mcc.php",{"page":requestedPage, "item_per_page":i_p_pages},function(){
	                                    
	                            });
	                            Rpage=requestedPage;
	                            
	                        }   
	                    }); //end pagination
	                }
	                else
	                {
	                	$('.lista_docs').empty();
	                 	console.log("no hay  info wey");
	                 	var temple="No hay documentos cargados!!!";
	                 	$('.lista_docs').text(temple);
	                } 
	            });  //end done
     }

//-------------------------code for redirec to upload a doc -----------------------////////////////
$("a[name='cargar_docs']").click( function(){

	window.location.replace("docs_cargar.php");

});

//-------------------------code for upload a doc -----------------------////////////////

$("a[name='subir_doc']").click( function(){

		var displayDate;
        var myDate = new Date();	
		var formData;
        //cargar_log(nombre_error,sistema,E_error,fecha_error,desc_error);        
        formData = new FormData($("#formDocs")[0]);
        displayDate = (myDate.getDate())+"-"+(myDate.getMonth()+1)+"-"+ myDate.getFullYear()+'--'+myDate.getHours()+'!'+myDate.getMinutes()+'!'+myDate.getSeconds();        
        formData.append("fechaactual",displayDate);
        for(var pair of formData.entries()) 
        {
             console.log(pair[0]+ ', ' + pair[1]);
        }
        $.ajax({
                  url: 'pro_cargar_doc.php',
                  data: formData,
                  processData: false,
                  contentType: false,
                  type: 'POST',
                   beforeSend: function () 
                   {
                        //$('#modal1').leanModal();
                        $('#modal1').openModal({dismissible:false});
                        console.log("loading....");
                    },
                  success: function(data){
                    console.log(data);
                    $('#modal1').closeModal();
                    window.location.replace("docs_mcc.php");
                  }
                });

});

// //------------------------------------------------------------------------------------------------------//
// //------------------------------------------------------------------------------------------------------//
// //------------------------------------------------------------------------------------------------------//
// //-------------------------searh by keydata docs -----------------------////////////////
if ($('#key_search_doc').length) 
{
     
    $('#key_search_doc').keyup(function() 
    {   


        // valor de  el dato buscado en log de errores
        var val=$(this).val();
        console.log("keyup filter");
            $.post("other.php", {basspass:4,keyval:val})
                .done(function( data ) 
                {
                    count=data.data.pages;
                    Tcount=data.data.TotalRecords;
                    console.log(count+"---"+Tcount+"---"+val);
                    $('.listanav_docs').empty();
                     if (count>0) 
                     {
                        $('.listanav_docs').materializePagination({
                            align: 'left',
                            lastPage: count,
                            firstPage:  1,
                            urlParameter: 'page',
                            useUrlParameter: true,
                            onClickCallback: function(requestedPage)
                            {
                                
                                $(".lista_docs").load("fetch_docs_mcc.php",{"page":requestedPage, "keyval":val},function(){
                                
                                });
                                Rpage=requestedPage;
                                
                            }   
                        }); //end pagination 
                        }
                                });
                                 
    }); // end keyup        
} 
