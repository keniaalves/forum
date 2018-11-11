<template>
  <div>
    <div v-if="signedIn">
      <textarea name="body"
                id="body"
                cols="30"
                rows="4"
                class="form-control"
                placeholder="Have something to say?"
                required
                v-model="body"></textarea>
      <br>
      <button type="submit"
              class="btn btn-default"
                  @click="addReply">Post</button>

    </div>
    <p v-else>Please  <a href="/login">sign in</a> to participate in this discussion.</p>
  </div>
</template>

<script>
  export default {
    props: ['endpoint'],
    data() {
      return {
        body: ''
      };
    },
    computed: {
      signedIn() {
        return window.App.signedIn;
      }
    },
    methods: {
      addReply() {
        axios.post(this.endpoint, { body: this.body })
          .then( ({data}) => {
            this.body = '';

            this.$emit('created', data);
          });
      }
    }
  }
</script>
