$(document).ready(function(){

    function listProcess(){
        $.ajax({
            url:'php/process.php',
            data:{key:'get'},
            type:'POST',
            success:function(response){
                const proccess = JSON.parse(response); //decodifica la info que viene en JSON y la guarda en array
                let template = '';
                proccess.forEach(proc => {
                    if(document.title == 'Procesos'){
                  template += `
                          <tr>
                          <td>${proc.id}</td>
                          <td>${proc.nombre}</td>
                          <td>${proc.desc}</td>
                          <td>${proc.time}</td>
                          <td>
                            <button class="btn btn-warning edit-btn" id="edit" name="${proc.id} Horas">
                             Editar 
                            </button>
                          
                            <button class=" btn btn-danger" id="delete" name="${proc.id}">
                             Delete 
                            </button>
                          </td>
                          </tr>
                        `}else{
                            template += `
                            <div>${proc.nombre}<button name="${proc.id}"class="btn btn-success float-right" id="add_process">Añadir</button></div><hr>
                          `
                          }
                  });
                $('#tableprocess').html(template);
                if(document.title == 'Procesos'){
                    $('#grid').DataTable();}
            }
        })
    }
    listProcess();
    $('#add_process').click(function(){
        let name= $('#new_name').val()
        let id= $('#new_id').val()
        let desc= $('#new_desc').val()
        let time= $('#new_time').val()
        if(!id||!name||!time){
            alert('Espacios Obligatorios')
            return;
        }
        $.ajax({
            url:'php/process.php',
            data:{key:'new',id:id, name:name, desc:desc, time:time},
            type:'POST',
            success:function(response){
                console.log(response)
                if(response=='true'){
                    $("body").overhang({
                        type: "success",
                        message: 'Proceso añadido correctamente'})
                    listProcess();
                    $('input').val('');
                    $('#add_window').hide();
                }else{
                    $("body").overhang({
                      type: "error",
                      message: 'Ha ocurrido un error'
                    });
                  }
                
            }
            
        })
        
    })
    $('#refresh-process').click(function(){
        listProcess();
       
      })
    $('#add_btn').click(function(){
     
        $('#add_window').show();
        })
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
                     url: 'php/process.php',
                     data: {key:'delete',id:id},
                     type: 'POST',
                     success:function(response){
                        $("body").overhang({
                            type: "warn",
                            message: 'Proceso Eliminado'})
                        listProcess();
                     }
                 }) 
              }
            });
});