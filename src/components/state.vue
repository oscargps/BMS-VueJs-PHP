<template>
<div class="card">
  <div class="card-header">
    <h1>Actualizar estado de pedido</h1>
  </div class="container">
  <div class="card-body">
    <select class="custom-select" v-model='selected'>
      <option v-for="item in items" :value="item" :key="">
        {{ item }}
      </option>
    </select>
    <hr>
    <div class="">
      <button type="button" class="btn btn-success" @click="updateState()">Actualizar</button>
      <button type="button" @click="hideIt()" class="btn btn-primary">Cerrar</button>
    </div>
  </div>
</div>
</template>
<script>
import axios from 'axios'
export default {
  data() {

    return {
      selected: null,
      items: []
    }
  },
  props: {
    id: String,
    hideIt: Function,
    procesos: String
  },
  methods: {
    getData() {
      let array1 = this.procesos.split(',')
      var array2 = []
      array1.forEach(function(element) {
        let serv = `${process.env.BASE_URI}process.php` + '?id=' + element
        axios.get(serv).then((response) => {
            array2.push(element + '-' + response.data[0].name)
          })
          .catch((error) => {
            console.log(error)
          })
      });
      this.items = array2
    },
    updateState(){
        let url = `${process.env.BASE_URI}new.php`
        let formData = new FormData();
        formData.append('mode','update')
        formData.append('id', this.id)
        formData.append('state', this.selected)
        axios.post(url, formData).then((response) => {
            swal('Acción Exitosa', '', 'success')
            this.hideIt();
          })
          .catch((error) => {
            console.log(error)
            swal('Ha ocurrido un eror', '', 'error')
          })
    }
  },
  mounted() {
    this.getData()
  }
}
</script>
<style lang="css">

</style>
