<template>
  <Notification />
  <router-view />
</template>

<script>
import Notification from './Components/Notification.vue';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
  broadcaster: 'pusher',
  key: '02ca81af562d8b12bb15',
  cluster: 'mt1',
  forceTLS: true,
});

export default {
  name: 'App',
  components: {
    Notification,
  }
};
</script>
