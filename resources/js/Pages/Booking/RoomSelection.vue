<script setup>
  import BookingLayout from '@/Layouts/BookingLayout.vue';
  import RoomDetailsModal from '@/Components/Modals/RoomDetailsModal.vue';
  import { useModal } from 'vue-final-modal';
  import { reactive } from 'vue';
  import { router } from '@inertiajs/vue3';
  import { useBookingStore } from '@/stores/booking';

  const bookingStore = useBookingStore();

  const availableRooms = reactive([
    {
      id: 1,
      name: "Superior Grand Suite",
      description: "Our Essence double room: cosy 30-35m² for feel-good moments. For you and your favourite person.",
      images: [],
      price: 1000,
      currency: "PHP"
    },
    {
      id: 2,
      name: "Big Grand Suite",
      description: "Our Essence double room: cosy 30-35m² for feel-good moments. For you and your favourite person.",
      images: [],
      price: 3000,
      currency: "PHP"
    },
  ]);

  function selectRoom(room) {
    bookingStore.setRoom(room);
    router.get('/booking-details', room);
  };

  function isRoomSelected(id) {
    if(bookingStore.room.id == id) {
      return true;
    }
    return false;
  }

  const { open, close } = useModal({
    component: RoomDetailsModal,
    attrs: {
      onConfirm() {
        close()
      },
    },
    slots: {
      default: '<p>UseModal: The content of the modal</p>',
    },
  });
</script>
<template>
  <BookingLayout>
    <div class="border-black border grid grid-cols-12 bg-white mb-6" v-for="room in availableRooms">
      <div class="col-span-4">
        <img src="/storage/images/room.jpg" class="w-full" alt="">
      </div>
      <div class="col-span-5 p-4 flex flex-col justify-between">
        <div>
          <h2 class="text-[1.5rem] font-bold tracking-wide">
            {{ room.name }}
          </h2>
          <p class="text-[.75rem]">
            {{ room.description }}
          </p>
        </div>
        <div class="flex">
          <a href="#" @click="open" class="text-black font-bold text-[1rem] bg-back-gray px-4 py-3.5">
            Room Details
          </a>
        </div>
      </div>
      <div class="col-span-3 border-l border-black flex flex-col justify-end items-end p-4 space-y-3">
        <p class="text-dark-green font-bold text-[1.25rem]">{{ room.currency }} {{ room.price.toLocaleString() }} / night</p>
        <button
          @click="selectRoom(room)" 
          :class="{'bg-dark-green text-white' : isRoomSelected(room.id) }"
          class="uppercase border-2 border-dark-green font-bold text-[1rem] p-2.5 w-full">
          {{ isRoomSelected(room.id) ? 'Selected' : 'Select' }}
        </button>
      </div>
    </div>
  </BookingLayout>
</template>