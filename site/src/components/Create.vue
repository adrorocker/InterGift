<template>
  <div class="crate">
    <div class="container">
      <h1>{{ msg }}</h1>
    </div>
    <div class="parallax"></div>
    <div class="container">
      <list route="/api/create"></list>
    </div>
  </div>
</template>

<script>
import List from './List' 
export default {
  name: 'Create',
  components: {List},
  data () {
    return {
      msg: 'Crate your list'
    }
  },
  created () {  
    document.title = 'Create your list | InterGift'  
    document.head.querySelector('meta[name=description]').content = 'Welcome to InterGift'  
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.parallax {
  background-image: url(../assets/create-list.jpeg);
}
</style>
