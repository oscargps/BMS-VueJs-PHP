<template>
  <div id="app">
  <navb/>
    <router-view/>
  </div>
</template>

<script>

import navb from '@/components/navb'
// Importamos JQuery
const $ = require('jquery')
window.dt = require('datatables.net');
window.dt2 = require('datatables.net-dt');
// Lo declaramos globalmente
window.$ = $
export default {
  name: 'App',
  components:{
    navb
  }
  }

</script>

<style>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
