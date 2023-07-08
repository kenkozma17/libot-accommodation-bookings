<script>
export default {
  data() {
    return {
      date: null,
      showDatePicker: false,
    }
  },
  methods: {
    toggleDatePicker() {
      this.showDatePicker = !this.showDatePicker;
    }
  }
}
</script>
<template>
  <div>
    <div class="relative border-black border w-full grid grid-cols-4 bg-white">
      <div class="flex flex-col py-4 px-6 cursor-pointer">
        <span class="font-bold text-[.75rem]">Hotel</span>
        <span class="text-[.75rem]">Catanduanes Midtown Inn</span>
      </div>
      <div class="border-black border-l flex flex-col py-4 px-6 cursor-pointer">
        <span class="font-bold text-[.75rem]">Guests/Room</span>
        <span class="text-[.75rem]">2 Guests/1 Room</span>
      </div>
      <div @click="toggleDatePicker" class="border-black border-l flex flex-col py-4 px-6 cursor-pointer">
        <span class="font-bold text-[.75rem]">Check In</span>
        <span class="text-[.75rem]">December 6, 2023</span>
      </div>
      <div @click="toggleDatePicker" class="border-black border-l flex flex-col py-4 px-6 cursor-pointer">
        <span class="font-bold text-[.75rem]">Check Out</span>
        <span class="text-[.75rem]">December 13, 2023</span>
      </div>
      <div v-if="showDatePicker" class="bg-white border-black border block absolute right-0 top-full w-1/2 z-50">
        <VDatePicker
          expanded
          transparent
          borderless
          :step="1"
          :min-date="new Date()"
          v-model.range="date"
          mode="date"
          :columns="2" />
      </div>
    </div>
    <div class="grid grid-cols-4">
      <div class="col-span-4 col-start-4">
        <a 
          href="" 
          class="transition-colors ease-in-out hover:bg-opacity-90 py-4 px-2 bg-dark-green justify-center text-white uppercase flex text-[1rem] font-bold tracking-widest"
            >Update Availabiltiy
          </a>
      </div>
    </div>
  </div>
</template>