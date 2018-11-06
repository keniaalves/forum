<template>
  <div :id="'reply-'+id" class="alert alert-default">
      <div class="level">
          <div class="flex">
              {{data.created_at}} |
              <a :href="'/profiles/' + data.owner.name"
              v-text="data.owner.name"></a>
          </div>
          <div class="level">
            <div v-if="signedIn">
              <favorite :reply="data"></favorite>
            </div>
            <div v-if="canUpdate">
              <button class="btn btn-success btn-xs" @click="editing = true">Editar</button>
              <button class="btn btn-danger btn-xs" @click="destroy">Delete</button>
            </div>
        </div>
        </div>
            <div v-if="editing">
                <div class="form-group">
                    <textarea class="form-control" v-model="body"></textarea>

                    <button class="btn btn-link btn-xs" @click="editing = false">Cancel</button>
                    <button class="btn btn-success btn-xs" @click="update">Update</button>
                </div>
            </div>
            <div v-else v-text="body"></div>
        <hr>
  </div>
</template>
<script>
import Favorite from './Favorite.vue';
export default {
    props: ['data'],

    components: { Favorite },

    data() {
        return{
            editing: false,
            id: this.data.id,
            body: this.data.body
        };
    },

    computed: {
      signedIn() {
        return window.App.signedIn;
      },
      canUpdate() {
        return this.authorize(user => this.data.user_id == user.id);
      }
    },

    methods: {
        update() {
            axios.patch('/replies/' + this.data.id, {
                body: this.body
            });
            this.editing = false;

            flash('Updated!');
        },
        destroy(){
            axios.delete('/replies/' + this.data.id);
            this.$emit('deleted', this.data.id);
            // $(this.$el).fadeOut(300);
            // flash('Deleted!');
        }
    }
}
</script>
