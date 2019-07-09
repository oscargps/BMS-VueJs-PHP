$(document).ready(function(){
$('#login').click(function(){
    let username= $('#username').val();
    let pw= $('#pw').val();
    $.ajax({
        url: 'php/login.php',
        data:{user:username,pw:pw,mode:'login'},
        type:'POST',
        success:function(response){
            console.log(response)
            if(response == "true"){
               location.href="pedidos.html";
                
            }else{
               
                $("body").overhang({
                    type: "error",
                    message: 'Verifique su Ususario y Contraseña'
                  });
            }
        }
    })
})

});