
$(document).ready(function() {


  function getClientes() {

    $.ajax({
      url: 'http://localhost/pedidos/static/php/clientes.php',

      data:{key:'get'},
      type:'POST',
      success: function(response) {
        //console.log(response)
        const users = JSON.parse(response);
        //decodifica la info que viene en JSON y la guarda en array
        let template = '';
        users.forEach(user => {

          template += `
                    <tr>
                    <td>${user.id}</td>
                    <td>${user.name}</td>
                    <td>${user.nit}</td>
                    <td>${user.tel}</td>
                    <td>${user.dir}</td>
                    <td>
                      <button class="btn btn-warning edit-btn" id="edit" name="${user.id}">
                       Editar
                      </button>

                      <button class=" btn btn-danger" id="delete" name="${user.id}">
                       Delete
                      </button>
                    </td>
                    </tr>
                  `
        });
        $('#tableUsers').html(template);

        $('#grid').DataTable();
      }
    })

  }

  getClientes();
  $('#add').click(function() {
    $('#add_cliente').show();
    console.log(' le has dado click');
  })
  $('#add_btn').click(function() {
    let nit = $('#nit').val();
    let tel = $('#tel').val();
    let name = $('#name').val();
    let dir = $('#dir').val();
    $.ajax({
      url: 'http://localhost/pedidos/static/php/clientes.php',
      data: {
        key: 'new',
        nit: nit,
        name: name,
        tel: tel,
        dir: dir
      },
      type: 'POST',
      success: function(response) {
        if (response == 'true') {
          $('input').val('');
          $('#add_cliente').hide();
          getClientes();
        } else {
          console.log('error')
        }

      }
    })




  })
  $(document).on("click", "#edit", function(e) {
    let element = e.target
    let fun = "edit-" + element.name;
    console.log(fun)
  });
  $(document).on("click", "#delete", function(e) {
    let element = e.target
    let id = element.name;
    let fun = "delete-" + element.name;
    let conf = confirm('¿Desea eliminar el Cliente ' + element.name)
    if (conf) {
      $.ajax({
        url: 'http://localhost/pedidos/static/php/clientes.php',
        data: {
          key: 'delete',
          id: id
        },
        type: 'POST',
        success: function(response) {
          getClientes();
        }
      })
    }

  });

});
