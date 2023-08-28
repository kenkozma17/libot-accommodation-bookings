<script setup>
  import { onMounted } from 'vue';
  import { useBookingStore } from '@/stores/booking';

  const bookingStore = useBookingStore();

  onMounted(() => {
    bookingStore.resetBooking();
  });
</script>