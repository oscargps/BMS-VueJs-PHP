<template lang="html">
  <div class="container" id="body">
    <div class="card">
      <div class="card-header">
        <h1>Detalle de pedido</h1>
      </div>
      <div class="card-body">
        <div>
          <b-table stacked :items="items" :fields="fields">
          <template slot="productos"  slot-scope="row">
              <b-table :items="productos" :fields="fieldsProducts"></b-table>
            </template>
          </b-table>
        </div>
        <button type="button" class="btn btn-info" v-if="stateInfo === '006-Entrega'">Facturación</button>
        <button type="button" class="btn btn-warning" @click="state=true" >Actualizar estado</button>
        <b-button variant="primary" :to="{ name:'list'}">Cerrar</b-button>
      </div>
    </div>
    <div id="form" v-if="state">
      <state v-bind:id="id" :hideIt="hideState" v-bind:procesos="items[0].process"/>
    </div>

  </div>
</template>

<script>
import axios from 'axios'
import list_pedidos from '@/components/list_pedidos'
import state from '@/components/state'
export default {
  data() {
    return {
      serv: this.$route.params.serv,
      id: this.$route.params.id,
      state:false,
      stateInfo:'',
      productos:[],
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
        },
        {
          key: 'productos',
          label: 'Detalle del pedido'
        }
      ],
      fieldsProducts:[
        {key: 'descr', label: 'Producto'},
        {key: 'qa', label: 'Cantidad'}      ]
    }
  },
  components:{
    state
  },
  mounted() {
    this.getData()
  },
  methods: {
    getData() {
      let url= this.serv + '?id=' + this.id
      axios.get(url).then((response) => {
        this.items = response.data
        this.stateInfo = response.data[0].state
        this.productos=JSON.parse(response.data[0].productos)
      }).catch((error) => {
        console.log(error)
      })
    },
    hideState(){
      this.state=false
      this.getData()
    }
  }
}
</script>

<style lang="css" scoped>
#form{
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.8);
  z-index: 2;
}
</style>
