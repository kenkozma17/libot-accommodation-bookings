<script setup>
import { Link } from "@inertiajs/vue3";
import CalendarIcon from "@/Components/Icons/CalendarIcon.vue";
import TagIcon from "@/Components/Icons/TagIcon.vue";
import UserIcon from "@/Components/Icons/UserIcon.vue";
import FileIcon from "@/Components/Icons/FileIcon.vue";

import { useBookingStore } from "@/Stores/booking";

const bookingStore = useBookingStore();
</script>

<script>
export default {
  data() {
    return {
      url: this.$page.url,
    };
  },
  computed: {
    currentStep() {
      if (this.url === "/") return 1;
      else if (this.url.includes("/available-rooms")) return 2;
      else if (this.url.includes("/booking-details")) return 3;
      else if (this.url.includes("/payment")) return 4;
      else return 1;
    },
  },
  methods: {
    isCurrentStep(step) {
      if (step >= this.currentStep) {
        return true;
      }
      return false;
    },
  },
};
</script>
<template>
  <div class="border border-gray-200 w-full bg-white">
    <div class="grid grid-cols-4">
      <Link
        href="/"
        class="text-black flex flex-col items-center border border-black md:py-5 p-2 hover:bg-gray-200 cursor-pointer"
      >
        <CalendarIcon class="md:w-auto w-5 h-5"></CalendarIcon>
        <span class="md:text-[0.875rem] text-[0.7rem] font-bold mt-1">Dates</span>
      </Link>
      <Link
        replace
        href="/available-rooms"
        :data="{
          dates: bookingStore.dates,
          guests: bookingStore.guests,
        }"
        class="text-black flex flex-col items-center border border-black border-l-0 md:py-5 p-2 hover:bg-gray-200 cursor-pointer"
      >
        <TagIcon class="md:w-auto w-5 h-5"></TagIcon>
        <span
          class="md:text-[0.875rem] text-[0.7rem] mt-1"
          :class="{ 'font-bold': !isCurrentStep(1) }"
        >
          Room
        </span>
      </Link>
      <Link
        href="/booking-details"
        :data="bookingStore.room"
        class="text-black flex flex-col items-center border border-black border-l-0 md:py-5 p-2 hover:bg-gray-200 cursor-pointer"
      >
        <UserIcon class="md:w-auto w-5 h-5"></UserIcon>
        <span
          class="md:text-[0.875rem] text-[0.7rem] mt-1"
          :class="{ 'font-bold': !isCurrentStep(2) }"
        >
          Details
        </span>
      </Link>
      <Link
        href="#"
        class="text-black flex flex-col items-center border border-black border-l-0 md:py-5 p-2 hover:bg-gray-200 cursor-pointer"
      >
        <FileIcon class="md:w-auto w-5 h-5"></FileIcon>
        <span
          class="md:text-[0.875rem] text-[0.7rem] mt-1"
          :class="{ 'font-bold': !isCurrentStep(3) }"
        >
          Payment
        </span>
      </Link>
    </div>
    <div class="grid grid-cols-4">
      <div class="border-b-4 border-black"></div>
      <div
        class="border-b-4 border-black"
        :class="{ 'border-opacity-25': isCurrentStep(1) }"
      ></div>
      <div
        class="border-b-4 border-black"
        :class="{ 'border-opacity-25': isCurrentStep(2) }"
      ></div>
      <div
        class="border-b-4 border-black"
        :class="{ 'border-opacity-25': isCurrentStep(3) }"
      ></div>
    </div>
  </div>
</template>
