<script setup>
  import BookingLayout from '@/Layouts/BookingLayout.vue';
  import RoomDetailsModal from '@/Components/Modals/RoomDetailsModal.vue';
  import PaginationList from '@/Components/PaginationList.vue';
  import { useModal } from 'vue-final-modal';
  import { router } from '@inertiajs/vue3';
  import { useBookingStore } from '@/stores/booking';

  const bookingStore = useBookingStore();

  const props = defineProps({
    availableRooms: {
      type: Array,
      default: []
    }
  });

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

  const isMainAmenity = (amenityName) => {
    const amenities = ['Free Wi-Fi', 'Air-Conditioned Unit', 'Satellite/Cable TV', 'Intercom'];
    return amenities.includes(amenityName);
  };

  const openModal = (room) => {
    const modal = useModal({
      component: RoomDetailsModal,
      attrs: {
        room,
        onClose() {
          modal.close()
        },
        onSelectRoom() {
          selectRoom(room);
          modal.close();
        }
      },
    });
    modal.open();
  };
</script>
<template>
  <BookingLayout>
    <div v-if="props.availableRooms.data.length">
      <h1 class="text-[1.25rem] font-bold tracking-wider mb-2">{{ props.availableRooms.total }} Rooms Found</h1>
      <div class="drop-shadow-lg grid grid-cols-12 bg-white mb-6" v-for="room in props.availableRooms.data">
        <div class="md:col-span-4 col-span-12 relative img-container">
          <img :src="room.cover_image_url" class="w-full cover-image" alt="">
        </div>
        <div class="md:col-span-5 col-span-12 p-4 flex flex-col justify-between">
          <div>
            <h2 class="md:text-[1.5rem] text-[1.25rem] font-bold tracking-wide">
              {{ room.name }}
            </h2>
            <p class="text-[.75rem]">
              {{ room.short_description }}
            </p>
            <ul class="text-[.75rem] mt-2">
              <template 
                v-for="amenity in room.amenities">
                <li v-if="isMainAmenity(amenity.name)">
                  {{ amenity.name }}
                </li>
              </template>
            </ul>
          </div>
          <div class="flex mt-6">
            <a href="#" @click="openModal(room)" class="text-black font-bold md:text-[1rem] text-[.85rem] bg-back-gray md:px-4 md:py-3.5 px-2 py-2">
              Room Details
            </a>
          </div>
        </div>
        <div class="md:col-span-3 col-span-12 md:border-l md:border-t-0 border-t border-black flex md:flex-col flex-row md:justify-end justify-between items-end p-4 md:space-y-3">
          <p class="text-dark-green font-bold md:text-[1.25rem] text-[1rem]">PHP {{ room.rate_formatted }} / night</p>
          <button
            @click="selectRoom(room)" 
            :class="{'bg-dark-green text-white' : isRoomSelected(room.id) }"
            class="uppercase border-2 border-dark-green font-bold md:text-[1rem] text-[.85rem] md:p-2.5 p-2 md:w-full w-1/2">
            {{ isRoomSelected(room.id) ? 'Selected' : 'Select' }}
          </button>
        </div>
      </div>
      <div v-if="props.availableRooms.links.length" class="flex justify-center bg-white rounded drop-shadow p-2">
        <PaginationList :links="props.availableRooms.links" />
      </div>
    </div>
    <div class="bg-white p-6" v-else>
      <h1 class="text-[1.25rem] font-bold tracking-wider">No Rooms Found</h1>
    </div>
  </BookingLayout>
</template>
<style>
  .img-container {
    min-height: 250px;
  }
  
  img.cover-image {
    position: absolute;
    inset: 0px;
    box-sizing: border-box;
    padding: 0px;
    border: none;
    margin: auto;
    display: block;
    width: 0px;
    height: 0px;
    min-width: 100%;
    max-width: 100%;
    min-height: 100%;
    max-height: 100%;
    object-fit: cover;
    object-position: center center;
  }
</style>