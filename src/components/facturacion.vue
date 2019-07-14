<template lang="html">
  <div >
    <b-nav tabs fill>
      <b-nav-item ><router-link to="/facturacion/facturas">Facturas Generadas</router-link></b-nav-item>
      <b-nav-item><router-link to="/facturacion/ingresos">Ingresos</router-link></b-nav-item>
      <b-nav-item><router-link to="/facturacion/compras">Compras</router-link></b-nav-item>
      <b-nav-item ><router-link to="/facturacion/graficas">Graficas</router-link></b-nav-item>
    </b-nav>
        <router-view></router-view>
  </div>
</template>

<script>
export default {
  name: 'facturacion',
  components:{

  }

}
</script>

<style lang="css" scoped>
</style>
