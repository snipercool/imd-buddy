<template>
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="card" style="max-height: 900px;">
        <div class="card-body overflow-auto d-flex flex-column chat">
            <div class="alert w-75" :class="{'bg-light' :message.from_id == buddyid, 'bg-primary align-self-end text-white' : message.from_id != buddyid }"  v-for="message in messages" >
                <p class="mb-0" v-if="message.from_id == buddyid"><b>{{buddyname}}</b></p>
                <p class="mb-0" v-else><b>{{username}}</b></p>
                <p class="mb-0">{{message.message}}</p>
            </div>
        </div>
      </div>
      <div class="mt-3">
        <div class="form-group">
          <div class="input-group mb-3">
            <input
              type="text"
              class="form-control"
              v-bind:placeholder="placeholder"
              aria-label="Recipient's username"
              aria-describedby="button-addon2"
              v-model="messageField"
            />
            <div class="input-group-append">
              <button class="btn btn-primary" type="button" id="button-addon2" @click.prevent="postMessage">{{submit}}</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
let messages = {};
export default {
  data() {
      return{
          messages: {},
        messageField: ""
      }
  },
  props:[
      'placeholder',
      'submit',
      'buddyid',
      'buddyname',
      'username'
  ],
  mounted() {
    this.getMessagess();
    this.scrollToEnd();
    this.listen();
  },
  methods: {
    getMessagess() {
      axios
        .get("/messagefetch")
        .then(response => {
          this.messages = response.data;
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    postMessage() {
      axios
        .post("/messagesend", {
          api_token:  window.Laravel.csrfToken,
          message: this.messageField
        })
        .then(response => {
          this.message.push(response.data);
          this.messageField = "";
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    scrollToEnd() {    	
      setTimeout(() => {
                this.$el
                    .getElementsByClassName("chat")
                    [
                        this.$el.getElementsByClassName("chat").length -
                            1
                    ].scrollIntoView();
            }, 3000);
    },
    listen(){
        Echo.channel('chat')
            .listen('MessageSent', (addMessage) => {
                this.messages.push(addMessage);
            })
    }
  }
};
</script>