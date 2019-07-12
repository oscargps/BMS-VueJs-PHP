<template lang="html">
  <div>
    <div class="card pt-5">
      <div class="card-header text-center">
        <h2 class="float-left">Clientes Registrados</h2>
        <input type="image" class="refresh float-right" id="add" @click="toggle()" src="static/icons/agregar-usuario.png" title="Añadir cliente" />
      </div>
      <div class="card-body" id="users">
        <tableTemplate v-bind:serv='url' v-bind:field="fields" :clickDelete="deleteClient" :clickEdit="editClient" ref="table" />
      </div>
    </div>
    <div class="row align-items-center" id="form" v-if="showName">
      <div class="col">
        <div class="row justify-content-center">
          <form  class="col-4" id="form_add">
            <div class="pb-2">
              <b-input type="text" placeholder="Nit Cliente" class="form-control" required v-model.trim="form.nit" :disabled="put"/>
              <input type="text" placeholder="Nombre de Cliente"  class="form-control " required v-model.trim="form.name">
              <input type="text" placeholder="Tel de Contacto (Opcional)" class="form-control" v-model.trim="form.phone">
              <input type="text" placeholder="Domicilio (Opcional)" class="form-control" v-model.trim="form.dir">
            </div>
          </form>
        </div>
        <div class="row ">
          <div class="col align-self-center">
            <button class="btn btn-primary btn-lg" v-if="put" @click='onSubmit("put")'>Actualizar</button>
            <button class="btn btn-success btn-lg" v-else  @click='onSubmit("add")'>Añadir</button>
            <button type="button" class="btn btn-secondary btn-lg" @click="toggle()">Cancelar</button>
          </div>
        </div>
      </div>
    </div>
    {{url}}
  </div>
</template>
<script>
import axios from 'axios';
import swal from 'sweetalert'
import tableTemplate from '@/components/tableTemplate'
export default {
  data() {
    return {
      url: `${process.env.BASE_URI}cliente.php`,
      showName: false,
      dataTable: null,
      items: [],
      put: false,
      fields: [{
          key: 'nit',
          label: 'Nit',
          sortable: true,
          sortDirection: 'desc'
        },
        {
          key: 'name',
          label: 'Cliente',
          sortable: true,
          class: 'text-center'
        },
        {
          key: 'tel',
          label: 'Contacto',
          sortable: true
        },
        {
          key: 'dir',
          label: 'Domicilio',
          sortable: true
        },
        {
          key: 'actions',
          label: 'Actions'
        }
      ],
      form: {
        nit: '',
        name: '',
        phone: '',
        dir: ''
      }
    }
  },
  components: {
    tableTemplate
  },
  methods: {
    clearForm() {
      this.form.nit = '',
        this.form.name = '',
        this.form.phone = '',
        this.form.dir = ''
    },
    toggle() {
      if (this.put) {
        this.put = !this.put
      }
      this.showName = !this.showName
      this.clearForm()
    },
    deleteClient(nitClient) {
      const path = this.url + `?id=` + nitClient
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
    editClient(nitClient) {
      const serv = this.url + `?id=` + nitClient
      axios.get(serv).then((res) => {
        this.toggle()
        this.put = true
        this.form.nit = res.data[0].nit
        this.form.name = res.data[0].name
        this.form.phone = res.data[0].tel
        this.form.dir = res.data[0].dir
      }).catch((error) => {
        console.log(error)
      })
    },
    onSubmit(mode) {
      if ((this.form.nit == '') || (this.form.name == '')) {
        swal('¡Falta Información!', '', 'warning')
      } else {
        let formData = new FormData();
        formData.append('mode',mode)
        formData.append('nit', this.form.nit)
        formData.append('name', this.form.name)
        formData.append('phone', this.form.phone)
        formData.append('dir', this.form.dir)
        axios.post(this.url, formData).then((response) => {
            this.$refs.table.getData()
            this.clearForm()
            this.toggle()
            swal('Acción Exitosa', '', 'success')
          })
          .catch((error) => {
            console.log(error)
            swal('Ha ocurrido un eror', '', 'error')
          })
      }
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
input[type=text]{
  margin-top: 2em;
}
</style>
