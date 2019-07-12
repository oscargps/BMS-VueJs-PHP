<template lang="html">
  <div class="container">
    <div class="card">
      <div class="card-header">
        <h1>Nueva factura</h1>
      </div>
      <div class="card-body">
        <div class="text-left">
          <h3>Factura N° {{id}}</h3>
          <hr>
          <h4>Informacion del cliente</h4>
          <div class="">
            <h6>Nombre: {{cliente}}</h6>
            <h6>Contacto: {{contacto}}</h6>
            <h6>Direccion: {{domicilio}}</h6>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data(){
    return{
      cliente:'cliente name',
      contacto:'telefono',
      domicilio:'direccion',
    }
  },
  props:{
    id:{String,default:'Id del pedido'}
  }
}
</script>

<style lang="css" scoped>
</style>
