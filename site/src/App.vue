<template>
  <div id="app">
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <router-link class="navbar-brand" :to="{ name: 'Home' }">
            <img width="35" class="logo" src="./assets/logo.png" alt="logo">
          </router-link>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="navbar-collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><router-link @click.native="closeMenu()" :to="{ name: 'Home' }">Home</router-link></li>
            <li><router-link @click.native="closeMenu()" :to="{ name: 'Create' }">Create your list</router-link></li>
            <li><router-link @click.native="closeMenu()" :to="{ name: 'Get' }">Get your list</router-link></li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
    <div id="content">
      <router-view/>
    </div>
    <footer class="text-center footer">
      <p>
        If you want <a href="//intergift.adro.rocks/">InterGift</a> to have more features please let me know, write me a note at <a href="mailto:me@adro.rocks">me@adro.rocks</a>
        <br><br>
        &copy; {{ year }} <a href="https://github.com/adrorocker" target="_blank">Alejandro Morelos</a>.
      </p>
    </footer>
    <div class="version">Version: {{ version }}</div>
  </div>
</template>

<script>
import Vue from 'vue'
export default {
  name: 'app',
  data () {
    return {
      version: '0.0.0'
    }
  },
  created(){
    this.getVersion()
  },
  computed: {
    year() {
      return (new Date()).getFullYear()
    }
  },
  methods: {
    getVersion() {
      let that = this
      Vue.http.get('/api/version').then(response => {
        that.version = response.body.version
      }, response => {
      })
    },
    closeMenu() {
      $('#navbar-collapse').collapse('hide');
    }
  },
}
</script>

<style>
.version {
  position: fixed;
  bottom: 0;
  right: 0;
  padding: 10px;
  color: #f13f62;
}
.footer {
  padding: 10px 0;
  background-color: #fff;
  -webkit-box-shadow: 0px 0px 5px 0px rgba(0,0,0,.15);
  -moz-box-shadow: 0px 0px 5px 0px rgba(0,0,0,.15);
  box-shadow: 0px 0px 5px 0px rgba(0,0,0,.15);
}
</style>
