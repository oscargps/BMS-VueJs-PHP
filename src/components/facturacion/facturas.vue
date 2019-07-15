<template lang="html">
  <div class="card">
    <div class="card-header">
      <h2>Facturas</h2>
    </div>
    <div class="card-body">
      <tableTemplate v-bind:serv='url' v-bind:field="fields" v-bind:factura="true" ref="table" />
    </div>
  </div>
</template>

<script>
import tableTemplate from '@/components/tableTemplate'
export default {
  data(){
    return{
    url: `${process.env.BASE_URI}facturas.php`,
    dataTable: null,
    items:[],
    fields:[
      {key: 'id', label: 'Id Factura'},
      {key : 'cliente', label: 'Cliente'},
      {key: 'born', label: 'Fecha de genearcion'},
      {key: 'total', label: 'Total'},
      {key: 'state', label: 'Estado del pago'},
      {key: 'pago', label: 'Fecha de pago'},
      {key: 'actions', label: 'Acciones'}
    ]
    }
  },
  components:{
    tableTemplate
  }, methods:{
    toFactura(){

    }
  }
}
</script>

<style lang="css" scoped>
</style>
