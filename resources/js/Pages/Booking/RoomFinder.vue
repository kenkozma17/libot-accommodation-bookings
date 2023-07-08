<script setup>
  import BookingLayout from '@/Layouts/BookingLayout.vue';
</script>
<script>
  export default {
    data() {
      return {
        date: null,
        columns: 2,
      }
    }
  }
</script>
<template>
  <BookingLayout>
    <div class="grid grid-cols-12 my-5 gap-7">
      <div class="col-span-8">
        <div class="border border-black bg-white">
          <div class="border-b border-black text-center py-5 px-2">
            <p class="text-[.875rem] font-bold uppercase tracking-widest">Select your dates</p>
          </div>
          <div class="m-4">
            <VDatePicker
              expanded
              transparent
              borderless
              :step="1"
              :min-date="new Date()"
              v-model.range="date"
              mode="date"
              :columns="columns" />
          </div>
        </div>
      </div>
      <div class="col-span-4">
        <div class="grid grid-cols-2 border-black border">
          <div class="border-black border-r">
            <div class="bg-light-brown py-1 text-center">
              <span class="text-[.875rem] font-bold text-white uppercase tracking-widest">Arrival</span>
            </div>
            <div class="bg-white text-center py-4">
              <p class="text-[5.65rem] leading-none">13</p>
              <p class="text-[.75rem] uppercase">July</p>
            </div>
          </div>
          <div>
            <div class="bg-light-brown py-1 text-center">
              <span class="text-[.875rem] font-bold text-white uppercase tracking-widest">Departure</span>
            </div>
            <div class="bg-white text-center py-4">
              <p class="text-[5.65rem] leading-none">18</p>
              <p class="text-[.75rem] uppercase">July</p>
            </div>
          </div>
        </div>

        <div>
          <form action="">
            <div class="input-field mt-3">
              <select 
                name="" 
                id="" 
                class="border-black border bg-white text-[.875rem] p-3.5 w-full">
                <option value="">1 Room</option>
              </select>
            </div>

            <div class="input-field mt-3">
              <select 
                name="" 
                id="" 
                class="border-black border bg-white text-[.875rem] p-3.5 w-full">
                <option value="">1 Adult</option>
              </select>
            </div>
            
            <div class="input-field mt-3">
              <select 
                name="" 
                id="" 
                class="border-black border bg-white text-[.875rem] p-3.5 w-full">
                <option value="">0 Children</option>
              </select>
            </div>

            <div class="mt-4">
              <button 
                class="w-full hover:bg-opacity-90 transition-colors ease-in-out p-4 text-white bg-dark-green uppercase tracking-widest font-bold">
                Check Availability
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </BookingLayout>
</template>
<style scoped>
  .vc-container {
    font-family: "Poppins", "sans-serif";
  }
  .vc-pane.column-1 {
    border-right: 1px solid rgba(0,0,0,0.5);
  }
</style>
