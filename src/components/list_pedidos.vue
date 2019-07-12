<template lang="html">
  <div class="">
    <b-container fluid>
      <!-- User Interface controls -->
      <b-row>
          <b-col md="6" class="my-1">
            <b-form-group label-cols-sm="3" label="Filtrar" class="mb-0">
              <b-input-group>
                <b-form-input v-model="filter" placeholder="Buscar.."></b-form-input>
                <b-input-group-append>
                  <b-button :disabled="!filter" variant="primary" @click="filter = ''">Limpiar</b-button>
                </b-input-group-append>
              </b-input-group>
            </b-form-group>
          </b-col>

        <b-col md="6" class="my-1">
          <b-form-group label-cols-sm="3" label="Mostrar" class="mb-1">
            <b-form-select v-model="perPage" :options="pageOptions"></b-form-select>
          </b-form-group>
        </b-col>
      </b-row>

      <!-- Main table element -->
      <b-table
        show-empty
        stacked="md"
        :items="items"
        :fields="fields"
        :current-page="currentPage"
        :per-page="perPage"
        :filter="filter"
        @filtered="onFiltered"
      >
        <template slot="actions" slot-scope="row">
          <b-button size="sm" variant="primary" @click='showDetails(row.item.id,true)' >Ver </b-button>
        </template>

      </b-table>

      <b-row>
        <b-col md="6" class="my-1">
          <b-pagination
            v-model="currentPage"
            :total-rows="totalRows"
            :per-page="perPage"
            class="my-0"
          ></b-pagination>
        </b-col>
      </b-row>


    </b-container>
    <div class="" v-if="details" id="details">
      <detailsPedido v-bind:serv="url" v-bind:id="idDetails" :hideIt="showDetails"/>

    </div>
  </div>

  </template>

  <script>
import axios from 'axios'
import detailsPedido from '@/components/detailsPedido'

    export default {
      data() {
        return {
          url: `${process.env.BASE_URI}list_pedidos.php`,
          details: false,
          showName: false,
          idDetails: '',
          items: [],
          fields:[
            { key: 'client', label: 'Cliente', sortable: true, class: 'text-center' },
            { key: 'born', label: 'Fecha de Entrega', sortable: true },
            { key: 'state', label: 'Estado' , sortable: true},
            { key: 'actions', label: 'Opciones' }
          ],
          totalRows: 1,
          currentPage: 1,
          perPage: 10,
          pageOptions: [5, 10, 15],
          filter: null
        }
      },components:{detailsPedido},
      mounted() {
        this.getData()
        this.totalRows = this.items.length
      },
      methods: {
        getData(){
          axios.get(this.url).then((response)=>{
            this.items = response.data
          }).catch((error) => {console.log(error)})
        },
        onFiltered(filteredItems) {
          // Trigger pagination to update the number of buttons/pages due to filtering
          this.totalRows = filteredItems.length
          this.currentPage = 1
        },
        showDetails(id,mode){
          this.idDetails = id
          this.details=mode
          this.getData()
        }
      }
    }
  </script>

<style lang="css" scoped>
#details{
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.8);
  z-index: 2;
}
</style>
