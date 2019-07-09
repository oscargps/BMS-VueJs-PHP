<template lang="html">
  <div class="">
    <div class="card pt-5" v-if="showName" id="add_cliente" >
            <div class="card-header text-center">
                <h4>Añadir Cliente</h4>
            </div>
            <div class="card-body">
                    <form action=""class="pt-4" id="form_add">
                            <div class="form-inline input-group pb-2">
                                    <input type="text" placeholder="Nit Cliente" id="nit" class="form-control" required v-model.trim="form.nit">
                                    <input type="text" placeholder="Nombre de Cliente" id="name" class="form-control " required v-model.trim="form.name">
                            </div>
                            <div class="form-inline input-group pb-2">
                                    <input type="text" placeholder="Tel de Contacto (Opcional)" id="tel" class="form-control form-group" v-model.trim="form.phone">
                                    <input type="text" placeholder="Domicilio (Opcional)" id="dir" class="form-control form-group" v-model.trim="form.dir">
                            </div>

                        </form>
                        <button class="btn btn-success" id="add_btn" @click='onSubmit()'>Añadir</button>
                        <button type="button" class="btn btn-secondary" name="button" @click="toggle()">Cancelar</button>
            </div>
        </div>
        <hr>
<div class="card pt-5">
    <div class="card-header text-center">
        <h2 class="float-left">Clientes Registrados</h2>
        <input type="image" class="refresh float-right" id="add" @click="toggle()" src="static/icons/agregar-usuario.png"  title="Añadir Usuario"/>
    </div>
    <div class="card-body" id="users">
      <tableTemplate v-bind:serv='url' v-bind:field="fields" :clickDelete="deleteClient" ref="table"/>
    </div>
</div>

  </div>
</template>

<script>
import axios from 'axios';
import swal from 'sweetalert'
import tableTemplate from '@/components/tableTemplate'
export default {
  data() {
    return {
      url: 'http://localhost/pedidos/static/php/API/V1/api.php',
      showName: false,
      dataTable:null,
      items:[],
      test:'test',
      fields: [
        { key: 'nit', label: 'Nit', sortable: true, sortDirection: 'desc' },
        { key: 'name', label: 'Cliente', sortable: true, class: 'text-center' },
        { key: 'tel', label: 'Contacto',sortable: true },
        { key: 'dir', label: 'Domicilio',sortable: true },
        { key: 'actions', label: 'Actions' }
      ],
      form:{
        nit:'',
        name:'',
        phone:'',
        dir:''
      }
    }
  },
  components:{
    tableTemplate
  },
  methods:{
    clearForm(){
      this.form.nit='',
      this.form.name='',
      this.form.phone='',
      this.form.dir=''
    },
    toggle(){
      this.showName = !this.showName
    },
    deleteClient(nitClient){
      const path = this.url +`?id=`+ nitClient
      swal("¿Desea eliminar el cliente?", {
          buttons: {
            cancel: "Cancelar",
            catch: {
              text: "Eliminar",
              value: "catch",
            },
            defeat: false,
          },
        })
        .then((value) => {
          switch (value) {
            case "catch":
              axios.delete(path).then((response) => {
                swal('Cliente Eliminado', '', 'success')
                this.$refs.table.getData()
              }).catch(err => {
                console.log(err);
                swal('no se pudo eliminar', '', 'error')
              })
              break;
          }
        });
    },
    onSubmit(){
      if ((this.form.nit=='')||(this.form.name=='')) {
        swal('¡Falta Información!', '', 'warning')
      }else{
        let formData = new FormData();
          formData.append('nit', this.form.nit)
          formData.append('name', this.form.name)
          formData.append('phone', this.form.phone)
          formData.append('dir', this.form.dir)
        axios.post(this.url, formData).then((response)=>{
            this.$refs.table.getData()
            this.clearForm()
            this.toggle()
          swal('Cliente añadido', '', 'success')
        })
        .catch((error)=>{
          console.log(error)
          swal('Ha ocurrido un eror','','error')
        })
      }
    }
  }
}

</script>

<style lang="css" scoped>

</style>
