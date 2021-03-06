//------------------------------------------------------------------------------------------------------//
//------------------------------------------------------------------------------------------------------//
//------------------------------------------------------------------------------------------------------//
//-------------------------Administración de usuarios -----------------------////////////////
if ($('div[name="users"]').length)
    {
       
      // row 
      var RowNumber=0; 
      $('div[name="users"]').load("fetch_users.php",{"Access":51},function () {
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
        var txt="confirma que desea borrar el usuario ";
        // set text and number's row
        txt=txt+RowNumber;
        //set text on modal
        $('.modal-content>p').text(txt);
      }); 
//-------------------------borrar usuarios -----------------------////////////////
//confirmación de borrado de usuario//               
     $(document).on('click', '.modal-delete-confirm', function(e){
        //alert('queriaas borrar el row '+RowNumber);
        $('#loadingmessage').show();
        $.post( "pro_delete_user.php", { id: RowNumber } )
        .done(function()
        {
          
          $('#loadingmessage').hide();
        
          $('div[name="users"]').load("fetch_users.php",{"Access":51},function () {
          $('.modal-trigger').leanModal();
            });
        });
       
     });                
                                 
    } // end if exits users div   
                  
//-------------------------crear usuarios -----------------------////////////////
if ($('a[name="create_user"]').length)
    {
        var displayDate;
        var myDate = new Date();
        var formData;
        $('a[name="create_user"]').click( function()
        {
            $("#formUser").valid();
            var errors = validator.numberOfInvalids();
        
            if (errors>0) 
            {
             console.log("hay "+errors+"en la pagina");   
            } 
            else 
            {
                console.log("No hay errores en la pagina");
                formData = new FormData($("#formUser")[0]);
                displayDate = (myDate.getDate())+"-"+(myDate.getMonth()+1)+"-"+ myDate.getFullYear()+' '+myDate.getHours()+':'+myDate.getMinutes()+':'+myDate.getSeconds();        
                var privilegio =$('#privilegio').prop('checked');
                formData.append("fechaactual",displayDate);

                formData.append("privilegio",privilegio);
                 for(var pair of formData.entries()) 
                 {
                      console.log(pair[0]+ ', ' + pair[1]);
                 }
                  
                var request = new XMLHttpRequest();
                request.open('post', 'pro_create_user.php', true);
                request.send(formData);
                window.location.replace("admin_users.php");
                 
            }
        });


        
        


        var validator=$("#formUser").validate({
                                      rules: {
                                        nombre_usuario: {
                                                        required: true,
                                                        },
                                        contraseña_usuario: {
                                                        required: true,
                                                        },
                                        email_usuario: {
                                                        required: true,
                                                        },    
                                        
                                            },
                                    messages:{
                                        nombre_usuario: {
                                                        required:"debe registrar el nombre del usuario",
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
if ($('a[name="update_user"]').length)
    {
        var displayDate;
        var myDate = new Date();
        var formData;
        $('a[name="update_user"]').click( function()
        {
            $("#formUser").valid();
            var errors = validator.numberOfInvalids();
        
            if (errors>0) 
            {
             console.log("hay "+errors+"en la pagina");   
            } 
            else 
            {
                console.log("No hay errores en la pagina");
                formData = new FormData($("#formUser")[0]);
                displayDate = (myDate.getDate())+"-"+(myDate.getMonth()+1)+"-"+ myDate.getFullYear()+' '+myDate.getHours()+':'+myDate.getMinutes()+':'+myDate.getSeconds();        
                var id =$('input[name="id_usuario"]').val();
                var privilegio =$('#privilegio').prop('checked');
                formData.delete("id_usuario");
                formData.append("id",id);
                formData.append("privilegio",privilegio);
                 for(var pair of formData.entries()) 
                 {
                      console.log(pair[0]+ ', ' + pair[1]);
                 }
                 $.ajax({
                          url: 'pro_update_user.php',
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
                            window.location.replace("admin_users.php");
                          }
                        }); 
                
            }
        });


        
        


        var validator=$("#formUser").validate({
                                      rules: {
                                        nombre_usuario: {
                                                        required: true,
                                                        },
                                        contraseña_usuario: {
                                                        required: true,
                                                        },
                                        email_usuario: {
                                                        required: true,
                                                        },    
                                        
                                            },
                                    messages:{
                                        nombre_usuario: {
                                                        required:"debe registrar el nombre del usuario",
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