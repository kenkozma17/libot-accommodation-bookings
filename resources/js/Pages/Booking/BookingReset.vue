<script setup>
import { onMounted } from "vue";
import { useBookingStore } from "@/Stores/booking";

const bookingStore = useBookingStore();

onMounted(() => {
    bookingStore.resetBooking();
});
</script>
