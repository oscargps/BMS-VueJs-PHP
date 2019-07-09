<template lang="html">
  <div class="">
    <div class="row justify-content-center pt-4">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header text-center">
                    <h3>Nuevo Pedido</h3>
                </div>
                <div class="card-body ">
                    <form action="" class=" " id="new" method="POST" >


                            <select name="" id="clientes" class="form-control" required>

                            </select>
                            <hr>
                            <div class="form-group">
                                <label for="">Fecha de Entrega</label>
                                <input type="date" id="time_exp"  class="form-control" required>
                            </div>

                            <hr>
                            <h4>Procesos Asociados</h4>
                            <div id="procesos"></div>
                            <hr>
                            <textarea name="" id="obs" cols="40" rows="10" required>Sin Observaciones</textarea>
                            <hr>

                    </form>
                    <button class="btn btn-success btn-block" id="crear">Enviar</button>
                </div>
            </div>

        </div>
        <div class="col-md-5 ">
            <div class="card">
                <div class="card-header">
                   <div class="">
                    <h4 class="float-left"  >Usuarios del Sistema</h4>
                    <input type="image" class="refresh float-right" id="refresh-users"src="static/icons/recargar.png" />
                </div>
                </div>
                <div class="card-body" id="tableUsers">

                </div>


            </div> <hr>
            <div class="card">
                <div class="card-header">
                    <h4 class="float-left">Procesos Activos</h4>
                    <input type="image" class="refresh float-right " id="refresh-process"src="static/icons/recargar.png" />
                </div>
                <div class="card-body" id="tableprocess">

                </div>
            </div>
        </div>
    </div>
  </div>
</template>

<script>
export default {
}
</script>

<style lang="css" scoped>
</style>
