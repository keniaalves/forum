<template>
<div class="alert alert-success alert-flash alert-dismissible fade show" role="alert" v-show="show">
  <strong>Success!</strong> {{body}}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
</template>

<script>
    export default {
        props:['message'],
        data(){
            return {
                body: '',
                show:false,
            }
        },
        created(){
            if(this.message){
                this.body = this.message;
                this.show = true;

                setTimeout(() => {
                    this.show = false;
                }, 3000);
            }
        }
    };
</script>

<style>
    .alert-flash{
        position: fixed;
        right: 25px;
        bottom: 25px;
    }
</style>
