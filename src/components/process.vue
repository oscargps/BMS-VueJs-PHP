<template lang="html">
  <div>
    <div class="card pt-5">
      <div class="card-header text-center">
        <h2 class="float-left">Procesos </h2>
        <input type="image" class="refresh float-right" id="add" @click="toggle()" src="static/icons/add.png" title="Añatime proceso" />
      </div>
      <div class="card-body" id="users">
        <tableTemplate v-bind:serv='url' v-bind:field="fields" :clickDelete="deleteProcess" :clickEdit="editProcess" ref="table" />
      </div>
    </div>
    <div class="row align-items-center" id="form" v-if="showName">
      <div class="col">
        <div class="row justify-content-center">
          <form  class="col-4" id="form_add">
            <div class="pb-2">
              <b-input type="text" placeholder="Id proceso" class="form-control" required v-model.trim="form.id" :disabled="put"/>
              <div class="input-group">
                <input type="text" placeholder="Nombre"  class="form-control " required v-model.trim="form.name">
                <input type="text" v-if="put" placeholder="Tiempo(Horas)" class="form-control" v-model.trim="form.time">
                <input type="number" v-else min="1" max="24" placeholder="Tiempo(Horas)" class="form-control" v-model.trim="form.time">
              </div>
              <input type="text" placeholder="Descripción" class="form-control" v-model.trim="form.descr">
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
      url: `${process.env.BASE_URI}process.php`,
      showName: false,
      dataTable: null,
      items: [],
      put: false,
      fields: [{
          key: 'id',
          label: 'Id de proceso',
          sortable: true,
          sortdirection: 'desc'
        },
        {
          key: 'name',
          label: 'Proceso',
          sortable: true,
          class: 'text-center'
        },
        {
          key: 'descr',
          label: 'Descripcion',
          sortable: true
        },
        {
          key: 'time',
          label: 'Tiempo',
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
        descr: '',
        time: ''
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
        this.form.descr = '',
        this.form.time = ''
    },
    toggle() {
      if (this.put) {
        this.put = !this.put
      }
      this.showName = !this.showName
      this.clearForm()
    },
    deleteProcess(idUser) {
      const path = this.url + `?id=` + idUser
      swal("¿Desea eliminar el proceso?", {
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
                swal('Proceso Eliminado', '', 'success')
                this.$refs.table.getData()
              }).catch(err => {
                console.log(err);
                swal('No se pudo eliminar', '', 'error')
              })
              break;
          }
        });
    },
    editProcess(idUSer) {
      const serv = this.url + `?id=` + idUSer
      axios.get(serv).then((res) => {
        this.toggle()
        this.put = true
        this.form.id = res.data[0].id
        this.form.name = res.data[0].name
        this.form.descr = res.data[0].descr
        this.form.time = res.data[0].time
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
        formData.append('descr', this.form.descr)
        formData.append('time', this.form.time)
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
input[type=number]{
  margin-top: 2em;
}
</style>
