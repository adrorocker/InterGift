<template>
  <div class="list">
    <p class="lead">Add people to the list (Name and e-mail address):</p>
    <p>At least 3 people are needed.</p>
    <br>
    <form class="form-inline" autocomplete="off">
      <div class="form-group">
        <label for="name">Name:</label>
        <input v-model="name" type="text" class="form-control" id="name">
      </div>
      <div class="form-group">
        <label for="email">Email address:</label>
        <input v-model="email" type="email" class="form-control" id="email">
      </div>
      <a @click.prevent="addPeople()" class="btn btn-default">Add person to list</a>
    </form>
    <hr>
    List of people ( <b>{{ count }}</b> ).
    <br>
    <ul>
      <li v-for="person in people">
        <b>{{ person.name }}</b> ( {{ person.email }} ) <button class="btn" v-on:click="remove(person)">X</button>
      </li>
    </ul>

    <div v-show="ready">
      <a class="btn btn-default" @click="create"> Create</a>
    </div>

    <div v-show="display">
      <h4>The result</h4>
      <ul>
        <li v-for="item in exchange">
          {{ item.giver }} => {{ item.reciver }}
        </li>
      </ul>
    </div>

    <div v-show="showMessageNow">
      <h4>Congratulation! </h4>
      <hr>
      <p>We have send an email to all the people in the list, If you are one of then please check your email to see who's the chosen one for you.</p>
      {{ result.id }}
    </div>

    <!-- Modal -->
    <div class="modal fade" id="error-modal" tabindex="-1" role="dialog" aria-labelledby="error-modal-level">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="error-modal-level">Error</h4>
          </div>
          <div class="modal-body">
            <span v-html="error"></span>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Vue from 'vue'
export default {
  name: 'List',
  props: {
    route: {
      type: String,
      default: '/api/create'
    },
    showMessage: {
      type: Boolean,
      default: true
    } 
  },
  data () {
    return {
      result: {},
      exchange: [],
      name: '',
      email: '',
      nextId: 1,
      people: [],
      error: '',
    }
  },
  computed: { 
    count () {
      return this.people.length
    } ,
    ready () {
      return this.people.length > 2 ? true : false
    },
    display () {
      if (this.showMessage == true) {
        return false
      }
      return this.exchange.length > 1 ? true : false
    },
    showMessageNow () {
      if (this.showMessage == false) {
        return false
      }
      return this.exchange.length > 1 ? true : false
    }
  },
  methods: {
    addPeople() {
      if (this.validateName() && this.validateEmail()) {
        this.people.push({
          id: this.nextId++,
          name: this.name,
          email: this.email
        })
        this.name = ''
        this.email = ''
      } else {
        $('#error-modal').modal('show')
      }
    },
    remove (person) {
      let index = this.people.indexOf(person);

      if (index > -1) {
        this.people.splice(index, 1)
      }
    },
    validateName() {
      if (this.name.length > 3) {
        return true
      }
      this.error = 'Name must be at least 4 letters'
      return false
    },
    validateEmail() {
      var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
      if (!re.test(this.email)) {
        this.error = '<b>' + this.email + '</b>  is not a valid email'
        return false
      }
      return true
    },
    create () {
      this.exchange = []
      let that = this
      Vue.http.post(that.route, {people: that.people}).then(response => {
        that.result = response.body
        that.arrange()
      }, response => {
        that.error = 'Something went wrong!'
        $('#error-modal').modal('show')
      })
    },
    arrange () {
      let that = this
      this.result.people.forEach(function(item, index) {
        that.exchange.push({giver: item.Sender.name, reciver: item.Reciver.name})
      })
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
