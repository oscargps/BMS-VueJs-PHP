<template lang="html">
  <div class="">
    <div class="row justify-content-center pt-4">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header text-center">
                    <h3>Nuevo Pedido</h3>
                </div>
                <div class="card-body ">
                    <form >
                      <select class="custom-select" v-model='selected'>
                        <option v-for="cliente in clientes" :value="cliente.name" :key="cliente.name">
                        {{ cliente.name }}
                        </option>
                        </select>
                            <hr>
                            <div class="form-group">
                                <label for="">Fecha de Entrega</label>
                                <input type="date" id="time_exp"  class="form-control" required v-model="date">
                            </div>
                            <hr>
                            <h4>Procesos Asociados</h4>
                            <div id="procesos"></div>
                            <hr>
                            <textarea v-model='obs'  cols="40" rows="10" required>Sin Observaciones</textarea>
                            <hr>

                    </form>
                    <button class="btn btn-success btn-block" @click="savePedido()">Enviar</button>
                </div>
            </div>

        </div>
        <div class="col-md-5 ">
            <div class="card">
                <div class="card-header">
                   <div class="">
                    <h4 class="float-left"  >Usuarios del Sistema</h4>
                    <input type="image" class="refresh float-right" @click="resetUser()"  id="refresh-users"src="static/icons/recargar.png" />
                    </div>
                </div>
                <div class="card-body" v-for="user in users" id="tableUsers">
                    {{user.name}} <button type="button" class="btn btn-success float-right" @click="addUser(user.id,users.indexOf(user))"name="button">Añadir</button>
                </div>
            </div> <hr>
            <div class="card">
                <div class="card-header">
                    <h4 class="float-left">Procesos Activos</h4>
                    <input type="image" class="refresh float-right " @click="resetProcess()" id="refresh-process"src="static/icons/recargar.png" />
                </div>
                <div class="card-body" v-for="proceso in procesos" id="tableprocess">
                  {{proceso.name}} <button type="button" class="btn btn-success float-right" @click="addProcess(proceso.id,procesos.indexOf(proceso))"name="button">Añadir</button>
                </div>
            </div>
        </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import swal from 'sweetalert'
export default {
  data() {
    return {
      procesos: [],
      users: [],
      clientes: [],
      addedProcesos: [],
      addedUsers: [],
      selected: '',
      date: '',
      obs: ''
    }
  },
  mounted() {
    this.getProcesos()
    this.getUsers()
    this.getClientes()
  },
  methods: {
    savePedido() {
      if ((this.selected == '') || (this.date == '')) {
        swal('¡Falta Información!', '', 'warning')
      } else {
        let born = new Date().toISOString();
        let formData = new FormData();
        let user = '1063300726'
        let id = user + born
        let file = this.selected + '-' + born + '.txt'
        let url = `${process.env.BASE_URI}new.php`
        formData.append('mode','new')
        formData.append('cliente', this.selected)
        formData.append('date', this.date)
        formData.append('auth_users', this.addedUsers)
        formData.append('proc_assoc', this.addedProcesos)
        formData.append('obs', this.obs)
        formData.append('born', born)
        formData.append('user', user)
        formData.append('id', id)
        formData.append('file', file)
        axios.post(url, formData).then((response) => {
            this.clearAll()
            swal('Acción Exitosa', '', 'success')
          })
          .catch((error) => {
            console.log(error)
            swal('Ha ocurrido un eror', '', 'error')
          })
      }
    },
    getClientes() {
      const url = `${process.env.BASE_URI}cliente.php`
      axios.get(url).then((response) => {
        this.clientes = response.data
        console.log(response);
      }).catch((error) => {
        console.log(error)
      })
    },
    getProcesos() {
      const url = `${process.env.BASE_URI}process.php`
      axios.get(url).then((response) => {
        this.procesos = response.data
      }).catch((error) => {
        console.log(error)
      })
    },
    getUsers() {
      const url = `${process.env.BASE_URI}user.php`
      axios.get(url).then((response) => {
        this.users = response.data
      }).catch((error) => {
        console.log(error)
      })
    },
    addProcess(proceso, index) {
      this.addedProcesos.push(proceso)
      this.procesos.splice(index, 1)
    },
    addUser(user, index) {
      this.addedUsers.push(user)
      this.users.splice(index, 1)
    },
    resetProcess() {
      this.addedProcesos = []
      this.getProcesos()
    },
    resetUser() {
      this.addedUsers = []
      this.getUsers()
    },
    clearAll() {
      this.resetProcess()
      this.resetUser()
      this.selected = ''
      this.date = ''
      this.obs = ''
    }
  }
}
</script>

<style lang="css" scoped>
</style>
