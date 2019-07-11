<template lang="html">
  <div class="container" id="body">
    <div class="card">
      <div class="card-header">
        <h1>Detalle de pedido</h1>
      </div>
      <div class="card-body">
        <div>
    <b-table stacked :items="items" :fields="fields"></b-table>
  </div>
      <button type="button" class="btn btn-primary" @click="hideIt(false)" name="button">Cerrar</button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
export default {
  data() {
    return {
      url: this.serv + '?id=' + this.id,
      items: [],
      fields: [{
          key: 'id',
          label: 'Id de pedido:',
          sortable: true,
          class: 'text-center'
        },
        {
          key: 'client',
          label: 'Cliente:'
        },
        {
          key: 'usercreate',
          label: 'Creado por:'
        },
        {
          key: 'born',
          label: 'Fecha de creacion:'
        },
        {
          key: 'expect',
          label: 'Fecha de entrega programada:'
        },
        {
          key: 'obs',
          label: 'Observaciones:'
        },
        {
          key: 'state',
          label: 'Estado del pedido:'
        }
      ],
    }
  },
  props: {
    id: {
      type: String
    },
    serv: String,
    hideIt: Function
  },
  mounted() {
    this.getData()
  },
  methods: {
    getData() {
      axios.get(this.url).then((response) => {
        this.items = response.data
      }).catch((error) => {
        console.log(error)
      })
    }
  }
}
</script>

<style lang="css" scoped>

</style>
