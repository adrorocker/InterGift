<template>
  <div class="hello">
    <h1>{{ msg }}</h1>
  </div>
</template>

<script>
export default {
  name: 'Get',
  data () {
    return {
      msg: 'Get your list'
    }
  },
  created () {  
    document.title = 'Get your list | InterGift'  
    document.head.querySelector('meta[name=description]').content = 'Welcome to InterGift'  
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
