<template>
  <div v-if="notification" class="fixed top-4 right-4 bg-green-100 text-green-800 p-3 rounded shadow">
    <p style="background-color: greenyellow;color: white;padding: 10px;width: fit-content;"><strong>{{ notification.title }} updated Successfully</strong></p>
    <p>{{ notification.message }}</p>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const notification = ref(null);

onMounted(() => {
  window.Echo.channel('consultation-updates')
    .listen('ConsultationUpdated', (e) => {
      console.log('Received:', e); // Shows event data in browser console
      notification.value = {
        title: e.title,
        message: e.message
      };
      setTimeout(() => notification.value = null, 5000);
    });
});
</script>
