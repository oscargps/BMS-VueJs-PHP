$(document).ready(function(){
    function auht(){
        $.ajax({
            url:'php/login.php',
            data:{mode:'auth'},
            type:'POST',
            success:function(response){
                /*if(response=='false'){
                    location.href="index.html";
                }else{
                   // const user = JSON.parse(response); 
                   
                }*/ console.log(response);
            }
        })
    }
    auht();
    function getpedidos(){
        $.ajax({
            url:'php/list_pedidos.php',
            success: function(response){
                const pedidos = JSON.parse(response); //decodifica la info que viene en JSON y la guarda en array
          let template = '';
          pedidos.forEach(pedido => {
            
            template += `
                    <tr>
                    <td>${pedido.id}</td>
                    <td>${pedido.cliente}</td>
                    <td>${pedido.born}</td>
                    <td>${pedido.state}</td>
                   
                    </tr>
                  `
          });
          $('#pedidos').html(template);
          $('#grid').DataTable();
            }
        })
    }
    getpedidos();
    
    $('document').click(function(e){
        console.log(e.target);
    })
});