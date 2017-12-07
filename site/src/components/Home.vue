<template>
  <div class="home">
    <div class="intro">
      <div class="container">
        <h1 class="white">{{ msg }}</h1>
        <hr class="trasparent white">
        <h3 class="white">Christmas is almost here, you should get ready!</h3>
      </div>
    </div>

    <div class="container">
      <div class="row connect">
        <div class="col-sm-6 col-sm-push-6 banner no-gutters">
          <picture>
            <img style="display: none;" width="100%" src="../assets/gift-what.jpeg">
          </picture>
        </div>
        <div class="col-sm-6 col-sm-pull-6 no-padding">
          <div class="inner">
            <p class="lead">What is InterGift?</p>
            <hr class="trasparent black">
            <p>
              InterGift is a "<a class="white" href="https://en.wikipedia.org/wiki/Secret_Santa" target="_blank">Secret Santa</a>" type of thing, but of course you can use it no matter what time of the year it is. It is super simple to use. 
            </p>
            <div class="row">&nbsp;</div>

            <p class="lead">How to use InterGift you ask?</p>
            <p>
              Simple, just create a list, then add all the emails (and names in case you cannot recognize a person by its email address) of the persons that are going to be in the gift exhcange. After that you are just a click away. No kiding, right?
            </p>
            <div class="row">&nbsp;</div>
            <p class="text-center">
              <router-link class="btn btn-default" :to="{ name: 'Create' }">Get Started <br>It's free!</router-link>
            </p>
            <div class="row">&nbsp;</div>
          </div>
        </div>
      </div>
    </div>

    <div class="parallax"></div>

    <div class="container">
      <div class="row">
        <h3>Whant to run a test?</h3>
        <hr>
        <list :showMessage="show" route="/api/test"></list>
      </div>
    </div>
    
  </div>
</template>

<script>
import List from './List' 
let show = false;
export default {
  components: {List},
  name: 'Home',
  data () {
    return {
      msg: 'Welcome to InterGift',
      show: false
    }
  },
  created () {  
    document.title = 'Welcome to InterGift'  
    document.head.querySelector('meta[name=description]').content = 'Welcome to InterGift'  
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>
.parallax {
  background-image: url(../assets/after-intro.jpeg);
}
.white {
  color: #fff;
}
.home .connect {
  background-image: url(../assets/gift-what.jpeg);
  background-color: rgba(52, 177, 206, 0.5);
  background-size: 100%;
  color: #fff;
}
.no-padding {
  padding: 0;
}
.inner {
  background-color: rgba(241, 63, 98, 1);
  padding: 15px;
}
.intro {
  height: 400px;
  line-height: 400px;
  /*text-shadow: 0px 0px 5px rgba(0, 0, 0, 1);*/
  text-align: center;
  color: #fff;
  background: rgba(52, 177, 206, 0.5), url("../assets/cover.png");
  background: -webkit-gradient(left top, right bottom, color-stop(0%, rgba(52, 177, 206, 0.5)), color-stop(0%, rgba(52, 177, 206, 0.5)), color-stop(100%, rgba(241, 63, 98, 0.5))), url("../assets/cover.png");
  background: linear-gradient(135deg, rgba(52, 177, 206, 0.5) 0%, rgba(52, 177, 206, 0.5) 0%, rgba(241, 63, 98, 0.5) 100%), url("../assets/cover.png");
  filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#015961', endColorstr='#2888ab', GradientType=1 );
  padding-top: 110px;
  margin-bottom: 20px;
  -webkit-box-shadow: 0px 0px 5px 0px rgba(0,0,0,.5);
  -moz-box-shadow: 0px 0px 5px 0px rgba(0,0,0,.5);
  box-shadow: 0px 0px 5px 0px rgba(0,0,0,.5);
}
.trasparent.black {
  border-top: 1px solid rgba(0, 0, 0, 0.1);
}
.trasparent.white {
  border-top: 1px solid rgba(255, 255, 255, 0.4);
}
.trasparent {
  display: block;
  height: 1px;
  border: 0;
  margin: 1em 0;
  padding: 0;
}
</style>
