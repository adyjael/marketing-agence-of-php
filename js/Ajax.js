$(function () {
  $("#menu").on("click", function () {
    $(".sidenav").toggle("slide");
  });
  $("#index_menu").on("click", function () {
    $(".links").toggle("slide");
  });



  // Register
  $("#btn_register").on("click", function (e) {
    e.preventDefault();

    var campoNome = $("#formRegister #nome").val();
    var campoApelido = $("#formRegister #apelido").val();
    var campoEmail = $("#formRegister #email").val();
    var campoPassword = $("#formRegister #password").val();
    var campoTel = $("#formRegister #tel").val();
    var regex = /\S+@\S+\.\S+/;

    if (
      campoNome.trim() == "" ||
      campoApelido.trim() == "" ||
      campoTel.trim() == "" ||
      campoEmail.trim() == "" ||
      campoPassword.trim() == ""
    ) {
      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "Preecha todos os campos!",
      });
    } else if (campoNome.length < 3) {
      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "Nome invalido!",
      });
    } else if (campoApelido.length <= 3) {
      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "Apelido invalido!",
      });
    } else if (campoTel.length < 9) {
      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "Telemovel invalido!",
      });
    } else if (!regex.test(campoEmail)) {
      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "Email invalido!",
      });
    } else if (campoPassword.length <= 7) {
      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "A senha precisa ter mais de 8 caracteres!",
      });
    } else {
      $.ajax({
        type: "POST",
        url: "../account/checkUsers.php",
        data: {
          type: "register",
          nome: campoNome,
          apelido: campoApelido,
          tel: campoTel,
          email: campoEmail,
          senha: campoPassword,
        },

        success: function (retorno) {
          retorno = JSON.parse(retorno);

          if (retorno["erro"]) {
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: retorno["mensagem"],
            });
          } else {
            window.location = "../account/login.php";
          }
        },
        error: function () {
          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Erro ao conectar com o servidor!",
          });
        },
      });
    }
  });

  // Login
  $("#btn_login").on("click", function (e) {
    e.preventDefault();
    var campoEmail = $("#formLogin #email").val();
    var campoPassword = $("#formLogin #password").val();
    var regex = /\S+@\S+\.\S+/;

    if (campoEmail.trim() == "" || campoPassword.trim() == "") {
      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "Preecha todos os campos!",
      });
    } else if (!regex.test(campoEmail)) {
      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "Email invalido!",
      });
    } else {
      $.ajax({
        type: "POST",
        url: "../account/checkUsers.php",
        data: {
          type: "login",
          email: campoEmail,
          senha: campoPassword,
        },

        success: function (retorno) {
          retorno = JSON.parse(retorno);

          if (retorno["erro"]) {
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: retorno["mensagem"],
            });
          } else if (retorno["adm"]) {
            window.location = "../dashboard.php";
          } else {
            window.location = "../Admin/";
          }
        },
        error: function () {
          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Erro ao conectar com o servidor!",
          });
        },
      });
    }
  });

  $("#btn_agendar").on("click", function (e) {
    e.preventDefault();

    var campoTitulo = $("#formAgenda #titulo").val();
    var campoData = $("#formAgenda #data").val();
    var campoHora = $("#formAgenda #hora").val();
    var campoDescAgenda = $("#formAgenda #message-text").val();
    var utilizador_id = $("#formAgenda #utilizador_id").val();

    if (
      campoTitulo.trim() == "" ||
      campoData == "" ||
      campoDescAgenda.trim() == ""
    ) {
      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "Preencha todos os campos!",
      });
    }else if (
      campoHora == 0
    ) {
      Swal.fire({
        icon: "info",
        title: "Informação",
        text: "Preencha a hora!",
      });
    } else if (
      utilizador_id == 0
    ) {
      Swal.fire({
        icon: "info",
        title: "Informação",
        text: "Selecione o utilizador!",
      });
    }else {
      $.ajax({
        type: "POST",
        url: "checkAgendamento.php",
        data: {
          type: "marcar_agenda",
          titulo: campoTitulo,
          hora: campoHora,
          data: campoData,
          descricao: campoDescAgenda,
          utilizador_id: utilizador_id,
        },
        success: function (retorno) {
          retorno = JSON.parse(retorno);
          if (retorno["erro"] == 1) {
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: retorno["mensagem"],
            });
          } else {
            Swal.fire({
              icon: "success",
              title: "Boa",
              text: retorno["mensagem"],
            });
            setTimeout(function () {
              document.location.reload(true);
            }, 1700);
          }
        },
      });
    }
  });

  $("#btn_edit_agendar").on("click", function (e) {
    e.preventDefault();
    var id_update = $(this).attr("edit_id");
    // document.querySelector("#editData").value = edit_data;
    var data_update = $("#editData").val();
    var titulo_update = $("#editTitulo").val();
    var hora_update = $("#editHora").val();
    var descricao_update = $("#edit-message-text").val();

    Swal.fire({
      title: "Informação",
      text: "Tem certeza que quer editar a marcação?",
      icon: "info",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "Não",
      confirmButtonText: "Sim, Salvar!",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "POST",
          url: "checkAgendamento.php",
          data: {
            type: "edit",
            id: id_update,
            titulo: titulo_update,
            data: data_update,
            hora: hora_update,
            descricao: descricao_update,
          },
          success: function (retorno) {
            retorno = JSON.parse(retorno);

            if (retorno["erro"] == 1) {
              Swal.fire({
                icon: "error",
                title: "Oops...",
                text: retorno["mensagem"],
              });
            } else {
              Swal.fire({
                icon: "success",
                title: "Boa",
                text: retorno["mensagem"],
              });
              setTimeout(function () {
                document.location.reload(true);
              }, 1700);
            }
          },
        });
      }
    });
  });

  $(".btn_delete_agenda").on("click", function (e) {
    e.preventDefault();
    var id = $(this).attr("delete");

    Swal.fire({
      title: "Informação",
      text: "Tem certeza que quer anular a marcação?",
      icon: "info",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "Não",
      confirmButtonText: "Sim, Anular!",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "POST",
          url: "checkAgendamento.php",
          data: {
            type: "delete",
            id: id,
          },
          success: function (retorno) {
            retorno = JSON.parse(retorno);

            if (retorno["erro"] == 1) {
              Swal.fire({
                icon: "error",
                title: "Oops...",
                text: retorno["mensagem"],
              });
            } else {
              Swal.fire({
                icon: "success",
                title: "Boa",
                text: retorno["mensagem"],
              });
              setTimeout(function () {
                document.location.reload(true);
              }, 1700);
            }
          },
        });
      }
    });
  });

  // ADM --------------------------ADM--------------------ADM---------------ADM------------

  $("#btn_adm_cadastrar_utilizador").on("click", function (e) {
    e.preventDefault();

    var campoNome = $("#formAdmAddUtilizador #nome").val();
    var campoApelido = $("#formAdmAddUtilizador #apelido").val();
    var campoEmail = $("#formAdmAddUtilizador #email").val();
    var campoPassword = $("#formAdmAddUtilizador #password").val();
    var campoTel = $("#formAdmAddUtilizador #tel").val();
    var adm = $("#formAdmAddUtilizador #adm").val();
    var regex = /\S+@\S+\.\S+/;

    if (
      campoNome.trim() == "" ||
      campoApelido.trim() == "" ||
      campoTel.trim() == "" ||
      campoEmail.trim() == "" ||
      campoPassword.trim() == ""
    ) {
      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "Preecha todos os campos!",
      });
    } else if (campoNome.length < 3) {
      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "Nome invalido!",
      });
    } else if (campoApelido.length <= 3) {
      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "Apelido invalido!",
      });
    } else if (campoTel.length < 9) {
      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "Telemovel invalido!",
      });
    } else if (!regex.test(campoEmail)) {
      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "Email invalido!",
      });
    } else if (campoPassword.length <= 7) {
      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "A senha precisa ter mais de 8 caracteres!",
      });
    } else if (adm == "") {
      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "Selecione o campo ADM!",
      });
    } else {
      $.ajax({
        type: "POST",
        url: "../account/checkUsers.php",
        data: {
          type: "adm_add_utilizador",
          nome: campoNome,
          apelido: campoApelido,
          tel: campoTel,
          email: campoEmail,
          senha: campoPassword,
          adm: adm,
        },

        success: function (retorno) {
          retorno = JSON.parse(retorno);

          if (retorno["erro"]) {
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: retorno["mensagem"],
            });
          } else {
            Swal.fire({
              icon: "success",
              title: "Boa",
              text: "Novo utilizador cadastrado",
            });
            setTimeout(function () {
              document.location.reload(true);
            }, 1700);
          }
        },
        error: function () {
          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Erro ao conectar com o servidor!",
          });
        },
      });
    }
  });

  $("#btn_adm_edit_user").on("click", function (e) {
    e.preventDefault();
    var id = $(this).attr("adm_adit_id");

    var campoNome = $("#formAdmEditUtilizador #editUserName").val();
    var campoApelido = $("#formAdmEditUtilizador #userApelido").val();
    var campoTel = $("#formAdmEditUtilizador #editUserTel").val();
    var campoPassword = $("#formAdmEditUtilizador #editUserSenha").val();
    var campoEmail = $("#formAdmEditUtilizador #editUserEmail").val();

    var ws = /^ \\ s + $ /;
    var regex = /\S+@\S+\.\S+/;

    if (
      campoNome.trim() == "" ||
      campoApelido.trim() == "" ||
      campoTel.trim() == "" ||
      campoEmail.trim() == ""
    ) {
      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "Preecha todos os campos!",
      });
    } else if (campoNome.length < 3) {
      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "Nome invalido!",
      });
    } else if (campoApelido.length <= 3) {
      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "Apelido invalido!",
      });
    } else if (campoTel.length < 9) {
      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "Telemovel invalido!",
      });
    } else if (!regex.test(campoEmail)) {
      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "Email invalido!",
      });
    } else {
    
          $.ajax({
            type: "POST",
            url: "../account/checkUsers.php",
            data: {
              type: "adm_edit_user",
              id: id,
              email: campoEmail,
              apelido: campoApelido,
              tel: campoTel,
              nome: campoNome,
            },
            success: function (retorno) {
              retorno = JSON.parse(retorno);

              if (retorno["erro"] == 1) {
                Swal.fire({
                  icon: "error",
                  title: "Oops...",
                  text: retorno["mensagem"],
                });
              } else {
                Swal.fire({
                  icon: "success",
                  title: "Boa",
                  text: "Utilizador editado com successo!",
                });
                setTimeout(function () {
                  document.location.reload(true);
                }, 1700);
              }
            },
          });
    }
  });

  $(".btn_adm_delete_user").on("click", function (e) {
    e.preventDefault();
    var id = $(this).attr("delete");
    if (id == 3) {
      Swal.fire({
        icon: "info",
        title: "Informação",
        text: "Para remover este usuario entre em contacto com o Desenvolvedor do site",
      });
    } else {
      Swal.fire({
        title: "Informação",
        text: "Tem certeza que quer apagar o utilizador?",
        icon: "info",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Não",
        confirmButtonText: "Sim, Anular!",
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: "POST",
            url: "../account/checkUsers.php",
            data: {
              type: "adm_delete_user",
              id: id,
            },
            success: function (retorno) {
              retorno = JSON.parse(retorno);

              if (retorno["erro"] == 1) {
                Swal.fire({
                  icon: "error",
                  title: "Oops...",
                  text: retorno["mensagem"],
                });
              } else {
                Swal.fire({
                  icon: "success",
                  title: "Boa",
                  text: "Utilizador apagado com suceesso",
                });
                setTimeout(function () {
                  document.location.reload(true);
                }, 1700);
              }
            },
          });
        }
      });
    }
  });

      
  $("#btn_edit_user").on("click",function(){
    var nome = $("#formEditUser #nome").val();
    var apelido = $("#formEditUser #apelido").val();
    var tel = $("#formEditUser #tel").val();
    var id = $("#formEditUser #id").val();

    if(nome == "" || apelido == "" || tel== ""){
      Swal.fire({
        icon: "info",
        title: "Informação",
        text: "Preencha todos os campos",
      });
    }else{
      
      $.ajax({
        type: "POST",
        url: "./account/checkUsers.php",
        data: {
          type: "edit_user",
          id: id,
          apelido: apelido,
          tel: tel,
          nome: nome,
        },
        success: function (retorno) {
          retorno = JSON.parse(retorno);

          if (retorno["erro"] == 1) {
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: retorno["mensagem"],
            });
          } else {
            Swal.fire({
              icon: "success",
              title: "Boa",
              text: "Utilizador salvo com successo!",
            });
            setTimeout(function () {
              document.location.reload(true);
            }, 1700);
          }
        },
      });


    }


  })



  $("#btn_edit_user_senha").on("click",function(e){
    e.preventDefault();
     var id = $("#formEditSenhaUser #id").val();
     var senha = $("#formEditSenhaUser #nova_senha").val()
     var confirmar_senha = $("#formEditSenhaUser #confirmar_senha").val()
     
     if(senha == "" || confirmar_senha == ""){
      Swal.fire({
        icon: "info",
        title: "Informação",
        text: "Preencha todos os campos da senha",
      });
     }else if(senha.length < 8){
      Swal.fire({
        icon: "info",
        title: "Informação",
        text: "A senha precisa de ter pelo menos 8 caracteres",
      });
     }else if(senha != confirmar_senha){
      Swal.fire({
        icon: "error",
        title: "Erro",
        text: "As senhas tem que ser iguais",
      });
     }else{
       $.ajax({
        type: "POST",
        url: "./account/checkUsers.php",
        data: {
          type: "edit_user_senha",
          id: id,
          senha: senha,
        },
        success: function (retorno) {
          retorno = JSON.parse(retorno);

          if (retorno["erro"] == 1) {
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: retorno["mensagem"],
            });
          } else {
            Swal.fire({
              icon: "success",
              title: "Boa",
              text:  retorno["mensagem"],
            });
            setTimeout(function () {
              document.location.reload(true);
            }, 1700);
          }
        },
      });
     }
     

  })




  $("#btn_editar_noticias").on("click",function(e){
    e.preventDefault();
    var titulo = $("#FormEditarNoticias #titulo").val()
    var descricao = $("#FormEditarNoticias #descricao").val()
    var conteudo = $("#FormEditarNoticias #conteudo").val() 
    var categoria = $("#categoria option:selected").val();
    var id = $(this).attr("editar_noticias");

     if(titulo == "" || descricao == "" || conteudo== ""){
      Swal.fire({
        icon: "info",
        title: "Informação",
        text: "Preencha todos os campos da noticia",
      });
     }else{
       $.ajax({
        type: "POST",
        url: "../Admin/editar_noticias.php",
        data: {
          titulo: titulo,
          descricao: descricao,
          conteudo: conteudo,
          categoria: categoria,
          id: id
        },
        success: function (retorno) {
          retorno = JSON.parse(retorno);

          if (retorno["erro"] == 1) {
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: retorno["mensagem"],
            });
          } else {
            Swal.fire({
              icon: "success",
              title: "Boa",
              text:  retorno["mensagem"],
            });
            setTimeout(function () {
              document.location.reload(true);
            }, 1700);
          }
        },
      });
     }

  })

  // $("#btn_delete_noticias").on("click", function (e) {
  //   e.preventDefault();
  //   var id = $(this).attr("delete_noticias");
  //         $.ajax({
  //           type: "POST",
  //           url: "../Admin/delete_noticias.php",
  //           data: {
  //             id: id,
  //           },
  //           success: function (retorno) {
  //             retorno = JSON.parse(retorno);

  //             if (retorno["erro"] == 1) {
  //               Swal.fire({
  //                 icon: "error",
  //                 title: "Oops...",
  //                 text: retorno["mensagem"],
  //               });
  //             } else {
  //               Swal.fire({
  //                 icon: "success",
  //                 title: "Boa",
  //                 text: "Noticia deletada com successo!",
  //               });
  //               setTimeout(function () {
  //                 document.location.reload(true);
  //               }, 1700);
  //             }
  //           },
  //         });
  //       })
      
 
        $("#btn_editar_projetos").on("click",function(e){
          e.preventDefault();
          var nome = $("#FormEditarProjetos #nome").val()
          var descricao = $("#FormEditarProjetos #descricao").val()
          var data_inicio = $("#FormEditarProjetos #data_inicio").val() 
          var data_fim = $("#FormEditarProjetos #data_fim").val() 
          var tecnologias = $("#FormEditarProjetos #tecnologias_utilizadas").val();
          var mais_info = $("#FormEditarProjetos #mais_info").val();
          var id = $(this).attr("editar_projetos");
      
           if(nome == "" || descricao == "" || tecnologias== ""){
            Swal.fire({
              icon: "info",
              title: "Informação",
              text: "Preencha todos os campos do projetos",
            });
           }else{
             $.ajax({
              type: "POST",
              url: "../Admin/editar_projetos.php",
              data: {
                nome: nome,
                descricao: descricao,
                data_inicio: data_inicio,
               data_fim:data_fim,
               tecnologias: tecnologias,
                id: id,
                mais_info:mais_info
              },
              success: function (retorno) {
                retorno = JSON.parse(retorno);
      
                if (retorno["erro"] == 1) {
                  Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: retorno["mensagem"],
                  });
                } else {
                  Swal.fire({
                    icon: "success",
                    title: "Boa",
                    text:  retorno["mensagem"],
                  });
                  setTimeout(function () {
                    document.location.reload(true);
                  }, 1700);
                }
              },
            });
           }
      
        })

        // $("#btn_delete_projeto").on("click", function (e) {
        //   e.preventDefault();
        //   var id = $(this).attr("delete_projetos");
        //         $.ajax({
        //           type: "POST",
        //           url: "../Admin/delete_projetos.php",
        //           data: {
        //             id: id,
        //           },
        //           success: function (retorno) {
        //             retorno = JSON.parse(retorno);
      
        //             if (retorno["erro"] == 1) {
        //               Swal.fire({
        //                 icon: "error",
        //                 title: "Oops...",
        //                 text: retorno["mensagem"],
        //               });
        //             } else {
        //               Swal.fire({
        //                 icon: "success",
        //                 title: "Boa",
        //                 text: "Projeto deletado com successo!",
        //               });
        //               setTimeout(function () {
        //                 document.location.reload(true);
        //               }, 1700);
        //             }
        //           },
        //         });
        //       })
  

});
