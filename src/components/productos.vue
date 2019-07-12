<template lang="html">
  <div>
    <div class="card pt-5">
      <div class="card-header text-center">
        <h2 class="float-left">Productos</h2>
        <input type="image" class="refresh float-right" id="add" @click="toggle()" src="static/icons/add.png" />
      </div>
      <div class="card-body" id="users">
        <tableTemplate v-bind:serv='url' v-bind:field="fields" :clickDelete="deleteProduct" :clickEdit="editProduct" ref="table" />
      </div>
    </div>
    <div class="row align-items-center" id="form" v-if="showName">
      <div class="col">
        <div class="row justify-content-center">
          <form  class="col-4" id="form_add">
            <div class="pb-2">
                  <b-input type="text" placeholder="Id Producto" class="form-control" required v-model.trim="form.id" :disabled="put"/>
                  <input type="text" placeholder="Descripcion"  class="form-control " required v-model.trim="form.descr">
                <div class="input-group">
                  <div class="input-group-prepend" style="margin-top: 2em;">
                    <div class="input-group-text">$</div>
                  </div>
                  <input type="number" class="form-control" placeholder="Precio" v-model.trim="form.price">
                </div>
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
  data(){
    return{
      url: `${process.env.BASE_URI}products.php`,
      showName: false,
      dataTable: null,
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
          key: 'price',
          label: 'Precio',
          sortable: true
        },
        {
          key: 'actions',
          label: 'Actions'
        }],
      form: {
        id: '',
        descr: '',
        price: 0,
      }
    }
  },
    components: {
      tableTemplate
    },
    methods: {
      clearForm() {
        this.form.id = '',
          this.form.descr = '',
          this.form.price = ''
      },
      toggle() {
        if (this.put) {
          this.put = !this.put
        }
        this.showName = !this.showName
        this.clearForm()
      },
      deleteProduct(idProduct) {
        const path = this.url + `?id=` + idProduct
        swal("¿Desea eliminar el producto?", {
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
                  swal('Producto Eliminado', '', 'success')
                  this.$refs.table.getData()
                }).catch(err => {
                  console.log(err);
                  swal('No se pudo eliminar', '', 'error')
                })
                break;
            }
          });
      },
      editProduct(idProduct) {
        const serv = this.url + `?id=` + idProduct
        axios.get(serv).then((res) => {
          this.toggle()
          this.put = true
          this.form.id = res.data[0].id
          this.form.descr = res.data[0].descr
          this.form.price = res.data[0].price
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
          formData.append('descr', this.form.descr)
          formData.append('price', this.form.price)
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
