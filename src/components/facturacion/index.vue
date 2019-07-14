<template lang="html">
  <div class="">
    <div v-if="title==='graficas'" >
      <graficas/>
    </div>

  </div>
</template>

<script>
import graficas from './graficas'
export default {
  props:{
    title:String
  },
  components:{
    graficas
  }

}
</script>

<style lang="css" scoped>

</style>
