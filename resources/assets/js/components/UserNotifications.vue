<template>
  <li class="dropdown nav-item" v-if="notifications.length">
    <a href="#" class="dropdown nav-link" data-toggle="dropdown">
      <i class="fa fa-bell"></i>
    </a>
    <ul class="dropdown-menu">
      <li v-for="notification in notifications">
          <a href="#">FooBar</a>
      </li>
    </ul>
  </li>
</template>

<script>
  export default {
    data() {
      return { notifications: ['damage'] };
    },
    created() {
      axios.get("/profiles/" + window.App.user.name + "/notifications")
        then(response => this.notifications = response.data);
    }
  }
</script>
