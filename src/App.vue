<template>
  <div id="app">
  <navb/>
    <router-view/>
  </div>
</template>

<script>

import navb from '@/components/navb'

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
