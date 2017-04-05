//get informative data from DB for Version charge
// number of item per page
var i_p_pages;
// number of pages
var count;
// number of records
var Tcount;
// sistem select
var TypeSistem;
//value of pagination bar
var Rpage;
    if ($('.listanav').length)
    {
     $.post( "other.php", {basspass:1})
            .done(function( data ) 
            {
                count=data.data.pages;
                Tcount=data.data.TotalRecords;
                i_p_pages=data.data.item_per_page;
                console.log("inicio");
                console.log(count+"---"+Tcount+"---"+i_p_pages);
                
                    $('.listanav').materializePagination({
                        align: 'left',
                        lastPage: count,
                        firstPage:  1,
                        urlParameter: 'page',
                        useUrlParameter: true,
                        onClickCallback: function(requestedPage)
                        {
                            $(".lista").load("fetch_pages.php",{"page":requestedPage, "item_per_page":i_p_pages},function(){});
                            Rpage=requestedPage;
                            console.log("inicio "+Rpage);
                        }   
                    });
                  
            });
            
    }
//------------------------------------------------------------------------------------------------------//
//------------------------------------------------------------------------------------------------------//
//------------------------------------------------------------------------------------------------------//
//-------------------------Cargar Selects con sistemas-----------------------////////////////
//variables para la pagination

if($("[id='sistemaContent']").length)
{
    $("[id=sistemaContent]").load("fetch_sistemas.php", function() {
        $('select').material_select();
        
        //delete option in form of version
        if($('select[name="sistema"]').length) 
        { 
            
            $('select[name="sistema"]').find("option").eq(1).remove();
            $('select[name="sistema"]').find("option").last().remove();
        } 
        
        //delete option in form of log
         if ($('select[name="log_sistema"]').length) 
        { 
            
            $('select[name="log_sistema"]').find("option").eq(1).remove();
            $('select[name="log_sistema"]').find("option").last().remove();
        } 
        
        //delete option in form of log
         if ($('select[name="sistema_update"]').length) 
        { 
            $('select[name="sistema_update"]').find("option").eq(1).remove();
            $('select[name="sistema_update"]').find("option").last().remove();
            var op=$('select[name="sistema_update"]').data("sistema");
            $('select[name="sistema_update"]').val(op);
        } 
        
    });

    
}



//-------------------------Code for events -----------------------////////////////


// function add_select_event() 
//  {
        
    //select sistems events
    $('.sistema').on('change', function(e) 
    {
        TypeSistem=this.value;         
        if (TypeSistem==999) 
        {   console.log("meh!");
            console.log("page"+Rpage+"--sistema"+TypeSistem);
            TypeSistem=null;
            $(".lista").load("fetch_pages.php",{"page":Rpage, "item_per_page":i_p_pages},function(){});
            $('.listanav').empty();
            $.post( "other.php", {basspass:1})
            .done(function( data ) 
            {
                count=data.data.pages;
                Tcount=data.data.TotalRecords;
                console.log("inicio");
                console.log(count+"---"+Tcount);
                
                    $('.listanav').materializePagination({
                        align: 'left',
                        lastPage: count,
                        firstPage:  1,
                        urlParameter: 'page',
                        useUrlParameter: true,
                        onClickCallback: function(requestedPage)
                        {
                            $(".lista").load("fetch_pages.php",{"page":requestedPage, "item_per_page":i_p_pages},function(){});
                            Rpage=requestedPage;
                            console.log("inicio "+Rpage);
                        }   
                    });
                  
                
                
            }); 
        }
        else
        {
            console.log("page"+Rpage+"--sistema"+TypeSistem);
            $(".lista").load("fetch_pages.php",{"page":Rpage, "item_per_page":i_p_pages, "sistema":TypeSistem},function(){});
             $.post( "other.php", {basspass:1, sistema:TypeSistem })
            .done(function( data ) 
            {
                count=data.data.pages;
                //when count is zero convert it to one because materializePagination no allow lastpage<firstPage
                if (count<1) 
                {
                    count=1;
                }
                Tcount=data.data.TotalRecords;
                console.log("numero de paginas"+count+"--- recors"+Tcount);
                $('.listanav').empty();
                
                    $('.listanav').materializePagination({
                        align: 'left',
                        lastPage: count,
                        firstPage:  1,
                        urlParameter: 'page',
                        useUrlParameter: true,
                        onClickCallback: function(requestedPage)
                        {
                            $(".lista").load("fetch_pages.php",{"page":requestedPage,"item_per_page":i_p_pages,  "sistema":TypeSistem},function(){});
                            Rpage=requestedPage;
                            console.log(Rpage+"---"+TypeSistem);
                        }   
                    }); //emd pagination
                  
            });  //end done
        }
    });
// }

  
$( "a[name='subir_Version']").click( function() 
     {
         

        var formData;
        //cargar_log(nombre_error,sistema,E_error,fecha_error,desc_error);        
        formData = new FormData($("#FormVersion")[0]);
        for(var pair of formData.entries()) 
        {
             console.log(pair[0]+ ', ' + pair[1]);
        }
        $.ajax({
                  url: 'upload.php',
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
                    window.location.replace("v.php");
                  }
                });
                      
     });