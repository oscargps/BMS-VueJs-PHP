<template>
  <div class="container">
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
          <b-button variant="success" :disabled="!selected" @click="updateState()">Actualizar</b-button>
          <button type="button" @click="hideIt()" class="btn btn-primary">Cerrar</button>
        </div>
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
      var array2 = ['000-Entregado']
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
      swal("¿Desea actualizar el estado a: " + this.selected + '?', {
          buttons: {
            cancel: "Cancelar",
            catch: {
              text: "Confirmar",
              value: "catch",
            },
            defeat: false,
          },
        })
        .then((value) => {
          switch (value) {
            case "catch":
        let url = `${process.env.BASE_URI}new.php`
        let formData = new FormData();
        formData.append('mode','update')
        formData.append('id', this.id)
        formData.append('state', this.selected)
        axios.post(url, formData).then((response) => {
          if (this.selected == '000-Entregado') {
              this.endDate()
          }else {
            swal('Cambio Exitoso', '', 'success')
          }
          })
          .catch((error) => {
            console.log(error)
            swal('Ha ocurrido un eror', '', 'error')
          })
          break;
      }

    });
  },
  endDate(){
    let url = `${process.env.BASE_URI}new.php`
    let formData = new FormData();
    formData.append('mode','endDate')
    formData.append('id', this.id)
    axios.post(url, formData).then((response) => {
      swal('Cambio Exitoso', '', 'success')
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
