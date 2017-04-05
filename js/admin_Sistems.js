//------------------------------------------------------------------------------------------------------//
//------------------------------------------------------------------------------------------------------//
//------------------------------------------------------------------------------------------------------//
//-------------------------Administración de usuarios -----------------------////////////////
if ($('div[name="sistems"]').length)
    {
       console.log("admin_sistems");
      // row 
      var RowNumber=0; 
      $('div[name="sistems"]').load("fetch_Sistems.php",{"Access":51},function () {
          $('.modal-trigger').leanModal();
      });


      ///function only for modals
      $(document).on('click', '.deleteUser', function(e){
        e.preventDefault();
        //clean the text
        $('.modal-content>p').text("");
        //get the data numbre of row
        RowNumber = $(this).data('row');
        //text by default
        var txt="confirma que desea borrar el sistema ";
        // set text and number's row
        txt=txt+RowNumber;
        //set text on modal
        $('.modal-content>p').text(txt);
      }); 
//-------------------------borrar sistemas -----------------------////////////////
//confirmación de borrado de usuario//               
     $(document).on('click', '.modal-delete-confirm', function(e){
        //alert('queriaas borrar el row '+RowNumber);
        if (RowNumber!=999 && RowNumber!=0)
        {
              $('#loadingmessage').show();
              $.post( "pro_delete_sistems.php", { id: RowNumber } )
              .done(function()
              {
                
                $('#loadingmessage').hide();
              
                $('div[name="sistems"]').load("fetch_Sistems.php",{"Access":51},function () {
                $('.modal-trigger').leanModal();
                  });
              });
        } 
        else
        {
            alert("no puede borrar el sistema debido a que es una directiva del sistema consulte al desarrollador");
        }
        
       
     });                
                                 
    } // end if exits users div   
                  
//-------------------------crear sistemas -----------------------////////////////
if ($('a[name="create_sistem"]').length)
    {
        var displayDate;
        var myDate = new Date();
        var formData;
        $('a[name="create_sistem"]').click( function()
        {
            $("#formSistems").valid();
            var errors = validator.numberOfInvalids();
        
            if (errors>0) 
            {
             console.log("hay "+errors+"en la pagina");   
            } 
            else 
            {
                console.log("No hay errores en la pagina");
                formData = new FormData($("#formSistems")[0]);
                 for(var pair of formData.entries()) 
                 {
                      console.log(pair[0]+ ', ' + pair[1]);
                 }
                  
                var request = new XMLHttpRequest();
                request.open('post', 'pro_create_sistems.php', true);
                request.send(formData);
                window.location.replace("admin_sistems.php");
                 
            }
        });


        
        


        var validator=$("#formSistems").validate({
                                      rules: {
                                        nombre_sistema: {
                                                        required: true,
                                                        },
                                        descripcion_sistema: {
                                                        required: true,
                                                        },
                                           
                                        
                                            },
                                    messages:{
                                        nombre_sistema: {
                                                        required:"debe registrar el nombre del sistema",
                                                        },
                                        descripcion_sistema: {
                                                        required:"debe escribir algo del sistema",
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
                                    }); //end of validate 
    }   
//-------------------------Actualizar usuarios -----------------------////////////////
if ($('a[name="update_sistems"]').length)
    {
        console.log("update");  
        var formData;
        $('a[name="update_sistems"]').click( function()
        {
            $("#formSistems").valid();
            var errors = validator.numberOfInvalids();
        
            if (errors>0) 
            {
             console.log("hay "+errors+"en la pagina");   
            } 
            else 
            {
                console.log("No hay errores en la pagina");
                formData = new FormData($("#formSistems")[0]);
                var id =$('input[name="id_sistems"]').val();
                formData.delete("id_sistems");
                formData.append("id",id);
                 for(var pair of formData.entries()) 
                 {
                      console.log(pair[0]+ ', ' + pair[1]);
                 }
                 $.ajax({
                          url: 'pro_update_sistems.php',
                          data: formData,
                          processData: false,
                          contentType: false,
                          type: 'POST',
                           // beforeSend: function () 
                           // {
                           //      //$('#modal1').leanModal();
                           //      $('#modal1').openModal({dismissible:false});
                           //      console.log("loading....");
                           //  },
                          success: function(data){
                            console.log(data);
                            //$('#modal1').closeModal();
                            window.location.replace("admin_sistems.php");
                          }
                        }); 
                
            }
        });


        
        


  var validator=$("#formSistems").validate({
                                      rules: {
                                        nombre_sistema: {
                                                        required: true,
                                                        },
                                        descripcion_sistema: {
                                                        required: true,
                                                        },
                                           
                                        
                                            },
                                    messages:{
                                        nombre_sistema: {
                                                        required:"debe registrar el nombre del sistema",
                                                        },
                                        descripcion_sistema: {
                                                        required:"debe escribir algo del sistema",
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
                                    }); //end of validate  
    }   