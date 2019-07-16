<template>
    <div>
       <div class="card pt-5">
      <div class="card-header text-center">
        <h2 class="float-left">Jefes de area</h2>
        <input type="image" class="refresh float-right" id="add" @click="toggle()" src="static/icons/agregar-usuario.png" title="Añadir Usuario" />
      </div>
      <div class="card-body" id="users">
        <tableTemplate v-bind:serv='url' v-bind:user="true" v-bind:field="fields" :clickDelete="deleteUser" :clickEdit="editUser" ref="table" />
      </div>
    </div>
    <div class="row align-items-center" id="form" v-if="showName">
      <div class="col">
        <div class="row justify-content-center">
          <form  class="col-4" id="form_add">
            <div class="pb-2">
              <b-input type="text" placeholder="Identificación de usuario" class="form-control" required v-model.trim="form.id" :disabled="put"/>
              <input type="text" placeholder="Nombre de usuario"  class="form-control " required v-model.trim="form.name">
              <input type="text" placeholder="Cargo asignado" class="form-control" v-model.trim="form.cargo">
              <b-form-checkbox v-model="form.super" name="check-button" switch> <b style="color:white;">Permisos de Admnistrador</b> </b-form-checkbox>
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
   </div>
</template>
<script>
import axios from 'axios';
import swal from 'sweetalert'
import tableTemplate from '@/components/tableTemplate'
export default {
    data() {
        return {
      url: `${process.env.BASE_URI}user.php`,
      showName: false,
      dataTable: null,
      items: [],
      put: false,
      fields: [{
          key: 'id',
          label: 'Id',
          sortable: true,
          sortDirection: 'desc'
        },
        {
          key: 'name',
          label: 'Usuario',
          sortable: true,
          class: 'text-center'
        },
        {
          key: 'cargo',
          label: 'Cargo Asignado',
          sortable: true
        },
        {
          key: 'super',
          label: 'SU',
          sortable: true
        },
        {
          key: 'actions',
          label: 'Actions'
        }
      ],
      form: {
        id: '',
        name: '',
        cargo: '',
        super: false
      }
        }
    },
    components: {
    tableTemplate
    },
    methods: {
    clearForm() {
      this.form.id = '',
        this.form.name = '',
        this.form.cargo = ''
    },
    toggle() {
      if (this.put) {
        this.put = !this.put
      }
      this.showName = !this.showName
      this.clearForm()
    },
    deleteUser(iduser) {
      const path = this.url + `?id=` + iduser
      swal("¿Desea eliminar el usuario?", {
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
                swal('Usuario Eliminado', '', 'success')
                this.$refs.table.getData()
              }).catch(err => {
                console.log(err);
                swal('No se pudo eliminar', '', 'error')
              })
              break;
          }
        });
    },
    editUser(iduser) {
      const serv = this.url + `?id=` + iduser
      axios.get(serv).then((res) => {
        this.toggle()
        this.put = true
        this.form.id = res.data[0].id
        this.form.name = res.data[0].name
        this.form.cargo = res.data[0].cargo
        this.form.super = res.data[0].super
      }).catch((error) => {
        console.log(error)
      })
    },
    onSubmit(mode) {
      if ((this.form.id == '') || (this.form.name == '')) {
        swal('¡Falta Información!', '', 'warning')
      } else {
        let formData = new FormData();
        formData.append('mode',mode)
        formData.append('id', this.form.id)
        formData.append('name', this.form.name)
        formData.append('cargo', this.form.cargo)
        formData.append('super', this.form.super)
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
    },

}
</script>
<style lang="css">
    #form{
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.8);
  z-index: 2;
}
#form input[type=text]{
  margin-top: 2em;
}
</style>
