<template>
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
    <template v-if="user" slot="super" slot-scope="row">
     {{ row.item.super ? 'Si' : 'No' }}
   </template>
      <template slot="actions" slot-scope="row">
        <b-button size="sm" variant="primary" @click='clickEdit(row.item.id)' >Editar </b-button>
        <b-button size="sm" variant="danger" @click='clickDelete(row.item.id)' >Eliminar </b-button>
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
</template>

<script>
import axios from 'axios';
  export default {
    data() {
      return {
        items: [],
        fields: this.field,
        totalRows: 1,
        currentPage: 1,
        perPage: 10,
        pageOptions: [5, 10, 15],
        filter: null,

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
      // Set the initial number of items
      this.totalRows = this.items.length
    },
    props:{
      serv:{
        type: String
      },
      field:{
        type: Array
      },
      clickDelete: Function,
      clickEdit: Function,
      user:false
    },
    methods: {
      getData(){
        axios.get(this.serv).then((response)=>{
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
<style lang="css">

</style>
