$(document).ready(function(){
//console.log(document.title)
function getUsers(){
 
  //console.log(data);
  $.ajax({
    url:'php/user.php',
    data:{key:'get'},
    type:'POST',
    success:function(response){
      const users = JSON.parse(response); //decodifica la info que viene en JSON y la guarda en array
          let template = '';
          users.forEach(user => {
            if(document.title == 'Usuarios'){
            template += `
                    <tr>
                    <td>${user.id}</td>
                    <td>${user.nombre}</td>
                    <td>${user.cargo}</td>
                    <td>${user.permisos}</td>
                    <td>
                      <button class="btn btn-warning edit-btn" id="edit" name="${user.id}">
                       Editar 
                      </button>
                    
                      <button class=" btn btn-danger" id="delete" name="${user.id}">
                       Delete 
                      </button>
                    </td>
                    </tr>
                  `}else{
                    template += `
                    <div>${user.nombre}/${user.cargo}<button name="${user.id}"class="btn btn-success float-right" id="add_users">Añadir</button></div><hr>
                  `
                  }
          });
          $('#tableUsers').html(template);
          if(document.title == 'Usuarios'){
          $('#grid').DataTable();}
    }
  })
 
}
getUsers();
$('#add_btn').click(function(){
      let ident = $('#id').val()
    let name= $('#name').val();
    let carg = $('#cargo').val()
    if ($('#superuser').is(":checked"))
    {
      var su = true;
    }
    else{var su = false;}
    
    $.ajax({
        url:'php/user.php',
        type:'POST',
        data: {key:'new',id:ident,nombre:name, cargo:carg, sup:su},
        success:function(response) {
          console.log(response)
          if(response=='true'){
            $("body").overhang({
              type: "success",
              message: 'Usuario añadido correctamente'
            });
            $('input').val('');
            $('#add_user').hide()
            getUsers()
          }else{
            $("body").overhang({
              type: "error",
              message: 'Ha ocurrido un error'
            });
          }
          
  
        }
        
      });

})
$('#add').click(function(){$('#add_user').show()})
$(document).on("click", "#edit", function(e){
 let element= e.target
 let fun = "edit-"+element.name;
  console.log(fun)
});
$(document).on("click", "#delete", function(e){
  let element= e.target
  let id = element.name;
  let fun = "delete-"+element.name;
  let conf= confirm('¿Desea eliminar el proceso'+element.name)
   if (conf){
      $.ajax({
          url: 'php/user.php',
          data: {key:'delete',id:id},
          type: 'POST',
          success:function(response){
             $("body").overhang({
                 type: "warn",
                 message: 'Usuario Eliminado'})
             getUsers();
          }
      }) 
   }
 
 });
$('#refresh-users').click(function(){
  getUsers();
})

});
