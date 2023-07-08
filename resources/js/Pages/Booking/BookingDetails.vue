<script setup>
  import BookingLayout from '@/Layouts/BookingLayout.vue';
  import SummaryPanel from '@/Components/Booking/SummaryPanel.vue';
</script>
<script>
  export default {
    data() {
      return {
        phone: null,
      }
    }
  }
</script>
<template>
  <BookingLayout>
    <div class="grid grid-cols-12 my-5 gap-7">
      <div class="col-span-8">
        <div class="border border-black bg-white p-5">
          <form action="">
            <h1 class="text-[2.5rem] font-bold">Booking Details</h1>
            <div class="grid grid-cols-2 gap-4 mt-2">
              <div class="input-field flex flex-col">
                <span class="text-[.75rem] font-bold mb-1">First Name*</span>
                <input 
                  type="text" 
                  placeholder="First Name"
                  class="border-black border bg-white text-[.875rem] p-3.5">
              </div>
              <div class="input-field flex flex-col">
                <span class="text-[.75rem] font-bold mb-1">Last Name*</span>
                <input 
                  type="text" 
                  placeholder="Last Name"
                  class="border-black border bg-white text-[.875rem] p-3.5">
              </div>
            </div>
            <div class="grid grid-cols-12 gap-4 mt-4">
              <div class="input-field col-span-6 flex flex-col">
                <span class="text-[.75rem] font-bold mb-1">Nationality*</span>
                <select 
                  name="" 
                  id="" 
                  class="border-black border bg-white text-[.875rem] p-3.5">
                  <option value="">Philippines</option>
                </select>
              </div>
              <div class="input-field col-span-6 flex flex-col">
                <span class="text-[.75rem] font-bold mb-1">Email*</span>
                <input 
                  type="text" 
                  placeholder="Enter your email"
                  class="border-black border bg-white text-[.875rem] p-3.5">
              </div>
            </div>
            <div class="flex flex-col mt-4">
              <span class="text-[.75rem] font-bold mb-1">Phone Number*</span>
              <vue-tel-input 
                class="phone"
                :inputOptions="{
                  showDialCode: true,
                  maxlength: 15,
                }"
                styleClasses="border-black border rounded-none bg-white text-[.875rem] p-2.5"
                mode="international"
                v-model="phone">
                </vue-tel-input>
            </div>
            <div class="input-field flex flex-col mt-4">
              <span class="text-[.75rem] font-bold mb-1">Special Requests*</span>
              <textarea 
                rows="3"
                placeholder="Please let us know if you have any special requests"
                class="border-black border bg-white text-[.875rem] p-3.5"></textarea>
            </div>

            <div class="mt-4">
              <label for="terms" class="cursor-pointer">
                <input name="terms" id="terms" type="checkbox">
                <span class="text-[.75rem] ml-2">
                  I agree to have read the Terms & 
                    <a href="" class="font-bold">Cancellation Policy</a>,
                    <a href="" class="font-bold">Privacy Policy</a> & 
                    <a href="" class="font-bold">Safety Standards</a>.* 
                </span>
              </label>
            </div>
            <div class="mt-4">
              <button 
                class="w-full hover:bg-opacity-90 transition-colors ease-in-out p-4 text-white bg-dark-green uppercase tracking-widest font-bold">
                Continue to payment
              </button>
            </div>
          </form>
        </div>
      </div>
      <div class="col-span-4">
        <SummaryPanel></SummaryPanel>
      </div>
    </div>
  </BookingLayout>
</template>
<style>
  .phone {
    border-radius: 0;
    border-color: black;
  }
</style>