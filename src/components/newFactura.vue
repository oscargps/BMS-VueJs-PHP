<template lang="html">
  <div class="container">
    <div class="card">
      <div class="card-header">
        <h1>Factura</h1>
      </div>
      <div class="card-body">
        <div class="text-left">
          <h3>Factura N° {{id}}</h3>
          <hr>
          <h4>Informacion del cliente</h4>
          <div class="">
            <h6>Nombre: {{cliente}}</h6>
            <h6>Nit: {{nit}}</h6>
            <h6>Contacto: {{contacto}}</h6>
            <h6>Direccion: {{domicilio}}</h6>
          </div>
        </div>
        <div class="card">
          <div class="card-header">
            <h3>Detalle del pedido</h3>
          </div>
          <div class="card-body">
            <b-table :items="items" :fields="fields"></b-table>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col ">
                <h4 class="">Subtotal:</h4>
              </div>
              <div class="col ">
                <h5 class="float-right">${{subTotal}}</h5>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col ">
                <h4 class="">Iva:</h4>
              </div>
              <div class="col ">
                <h5 class="float-right">${{total-subTotal}}</h5>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <div class="row">
              <div class="col ">
                <h2 class="">Total:</h2>
              </div>
              <div class="col ">
                <h3 class="float-right">${{total}}</h3>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer" >
        <b-button v-if="crear" variant="success" @click="saveFactura()">Generar Factura</b-button>
        <b-button v-else variant="primary" @click="pagar()">Verificar pago</b-button>

      </div>

    </div>
  </div>
</template>

<script>
import axios from 'axios'
export default {
  data() {
    return {
      serv: this.$route.params.serv,
      id: this.$route.params.id,
      crear: this.$route.params.crear,
      fullCliente:'',
      cliente: '',
      nit:'',
      contacto: '',
      domicilio: '',
      productos: [],
      subTotal: 0,
      total:0,
      items: [],
      fields: [{
          key: 'descr',
          label: 'Producto'
        },
        {
          key: 'qa',
          label: 'Cantidad'
        },
        {
          key: 'price',
          label: 'Precio Unidad'
        },
        {
          key: 'total',
          label: 'Total'
        }
      ]
    }
  },

  mounted() {
    this.getData()

  },
  methods: {
    getData() {
      let url =  `${process.env.BASE_URI}list_pedidos.php` + '?id=' + this.id
      let cliente = []
      axios.get(url).then((response) => {
        cliente = response.data[0].client.split('-', 2)
        this.nit = cliente[0]
        this.cliente = cliente[1]
        this.fullCliente = response.data[0].client
        this.productos = JSON.parse(response.data[0].productos)
        this.getInfoCliente()
      }).catch((error) => {
        console.log(error)
      })
    },
    getInfoCliente() {
      let url = `${process.env.BASE_URI}cliente.php` + '?id=' + this.nit
      axios.get(url).then((response) => {
        this.contacto = response.data[0].tel
        this.domicilio = response.data[0].dir
        this.getProducts()
      }).catch((error) => {
        console.log(error)
      })
    },
    getProducts() {
        this.productos.forEach((producto) => {
        let url = `${process.env.BASE_URI}products.php` + '?id=' + producto.id_producto
        let price = 0
        let item = ['']
        //let items =[]
        let total = 0
        axios.get(url).then((response) => {
          price = response.data[0].price
          total = price * producto.qa
          this.subTotal += total
          this.calcIva()
          item.descr = producto.descr
          item.qa = producto.qa ;
          item.price ='$'+ price
          item.total ='$'+ total
          this.items.push(item);
        }).catch((error) => {
          console.log(error)
        })

      })
    },
    calcIva(){
      this.total = this.subTotal + ((this.subTotal*19)/100)
    },
    saveFactura(){
      let formData = new FormData();
      let url = `${process.env.BASE_URI}facturas.php`
      formData.append('mode','new')
      formData.append('id',this.id)
      formData.append('client', this.fullCliente)
      formData.append('total',this.total)
      axios.post(url, formData).then((response) => {
          swal('Factura creada exitosamente', '', 'success')
          location.href='/facturacion/facturas'
        })
        .catch((error) => {
          console.log(error)
          swal('Ha ocurrido un eror', '', 'error')
        })
    },
    pagar(){
        let url = `${process.env.BASE_URI}facturas.php`
        let formData = new FormData();
        formData.append('mode','pay')
        formData.append('id',this.id)
        axios.post(url, formData).then((response) => {
            swal('Pago ingresado', '', 'success')
            location.href='/facturacion/facturas'
          })
          .catch((error) => {
            console.log(error)
            swal('Ha ocurrido un eror', '', 'error')
          })
    }
  }
}
</script>

<style lang="css" scoped>
</style>
