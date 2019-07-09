$(document).ready(function(){
    
    function addOptions(domElement, array) {
        var select = document.getElementById(domElement);
       
        for (value in array) {
         var option = document.createElement("option");
         option.text = array[value];
         select.add(option);
        }
    }
    $.ajax({
        url:'php/clientes.php',
        type: 'POST',
        data:{key:'get'},
        success: function(response){
            const clientes = JSON.parse(response);
            var arr=[]
            clientes.forEach(cliente => {
                arr.push(cliente.name)
            })
            addOptions('clientes',arr);
        }

    })
    var arr1=[];
    $(document).on("click", "#add_users", function(e){
    let element= e.target
    arr1.push(element.name)
    element.remove();
        console.log(arr1)
    });
    var arr2=[];
    $(document).on("click", "#add_process", function(e){
    let element= e.target
    arr2.push(element.name)
    element.remove();
    console.log(arr2)
    });
    $('#crear').click(function(){
        let cliente = $('#clientes').children("option:selected").val();
        let date = new Date($('#time_exp').val()).toISOString();
        let auth_users= arr1.join(';');
        let proc_assoc= arr2.join(';');
        let obs = $('#obs').val()
        let born = new Date().toISOString();
        let user = '1063300726';
        let id= user + born
        let file= cliente+'*'+born+'.txt';
        //console.log(auth_users);
        $.ajax({
            url: 'php/new.php',
            type: 'POST',
            data:{
                cliente:cliente,
                date:date,
                auth_users:auth_users,
                proc_assoc:proc_assoc,
                obs:obs,
                born:born,
                user:user,
                id:id,
                file:file
            },
            success: function(response){
                $("body").overhang({
                    type: "success",
                    message: response
                  });
            }
        })
        
        
    })
    $('.refresh').click(function(){
       arr1=[];
       arr2=[];
    })
});
/*function addOptions(domElement, array) {
    var select = document.getElementById(domElement);
   
    for (value in array) {
     var option = document.createElement("option");
     option.text = array[value];
     select.add(option);
    }
}


var clientes=["San Agustin", "Virna Lisi", "hseq", 'katty'];
var select = document.getElementById('clientes');
addOptions('clientes',clientes);*/

