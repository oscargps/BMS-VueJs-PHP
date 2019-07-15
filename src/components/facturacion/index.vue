<template lang="html">
  <div class="">
    <div v-if="title==='graficas'" >
      <graficas/>
    </div>
    <div  v-if="title==='facturas'">
    <facturas/>
    </div>

  </div>
</template>

<script>
import graficas from './graficas'
import facturas from './facturas'
export default {
  props:{
    title:String
  },
  components:{
    graficas, facturas
  }

}
</script>

<style lang="css" scoped>

</style>
