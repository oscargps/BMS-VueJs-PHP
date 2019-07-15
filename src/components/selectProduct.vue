<template lang="html">
  <div class="container card">
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

        <b-col md="6" class="">
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
          <input type="number" min="1" id="qa" name="qa" v-bind:value="qa">
          <b-button size="sm"  variant="success" @click='clickAdd(row.item.id,row.item.descr,$event.target.parentNode.firstChild.value)' >Agregar </b-button>
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
<hr>
  <button type="button" @click="close()" class="btn btn-primary">Terminar</button>
    </b-container>


  </div>

</template>

<script>
import axios from 'axios'
export default {
  data(){
    return{
      url: `${process.env.BASE_URI}products.php`,
      dataTable: null,
      something:0,
      put:false,
      items: [],
      fields:[{
          key: 'id',
          label: 'Id de producto',
          sortable: true,
          sortdirection: 'desc'
        },
        {
          key: 'descr',
          label: 'Descripcion',
          sortable: true,
          class: 'text-center'
        },
        {
          key: 'actions',
          label: 'Actions'
        }],
        totalRows: 1,
        currentPage: 1,
        perPage: 5,
        pageOptions: [5, 10, 15],
        filter: null,
        qa:0
    }
  },

  computed: {
    sortOptions() {
      // Create an options list from our fields
      return this.fields
        .filter(f => f.sortable)
        .map(f => {
          return { text: f.label, value: f.key }
        })
    }
  },
  mounted() {

    this.getData()
    this.totalRows = this.items.length
  },
  props:{
    clickAdd : Function,
    close: Function
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
    }
  }

  }
</script>

<style lang="css" scoped>
</style>
