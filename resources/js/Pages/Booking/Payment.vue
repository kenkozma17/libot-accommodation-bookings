<script setup>
  import BookingLayout from '@/Layouts/BookingLayout.vue';
  import SummaryPanel from '@/Components/Booking/SummaryPanel.vue';
</script>
<template>
  <BookingLayout>
    <div class="grid grid-cols-12 my-5 gap-7">
      <div class="col-span-8">
        <div class="border border-black bg-white">
          <div class="border-b border-black text-center py-5 px-2">
            <p class="text-[.875rem] font-bold uppercase tracking-widest">Travel Details</p>
          </div>
          <div class="grid grid-cols-3 py-8 px-6 gap-4">
            <div class="flex flex-col">
              <span class="text-[1rem] font-bold">Name</span>
              <span class="text-[0.875rem]">Ken Kozma</span>
            </div>
            <div class="flex flex-col">
              <span class="text-[1rem] font-bold">Arrival</span>
              <span class="text-[0.875rem]">December 6, 2023</span>
            </div>
            <div class="flex flex-col">
              <span class="text-[1rem] font-bold">Departure</span>
              <span class="text-[0.875rem]">December 12, 2023</span>
            </div>
            <div class="flex flex-col">
              <span class="text-[1rem] font-bold">Email Address</span>
              <span class="text-[0.875rem]">kenkozma@gmail.com</span>
            </div>
            <div class="flex flex-col">
              <span class="text-[1rem] font-bold">Phone Number</span>
              <span class="text-[0.875rem]">+1 405 371 1742</span>
            </div>
            <div class="flex flex-col">
              <span class="text-[1rem] font-bold">Nationality</span>
              <span class="text-[0.875rem]">United States</span>
            </div>
          </div>
          <div class="border-b border-t border-black text-center py-5 px-2">
            <p class="text-[.875rem] font-bold uppercase tracking-widest">Travel Details</p>
          </div>
          <div class="room-details p-8 grid grid-cols-12 space-x-4">
            <div class="col-span-4">
              <img src="/storage/images/room.jpg" class="w-full" alt="">
            </div>
            <div class="col-span-8">
              <h3 class="text-[1.25rem] font-bold tracking-wider">Superior Grand Suite</h3>
              <p class="text-[.875rem] mt-2">Our Essence double room: cosy 30-35m² for feel-good moments. For you and your favourite person.</p>
              <div class="flex items-end">
                <div>test</div>
              </div>
            </div>
          </div>
        </div>
        
        <div class="border border-black bg-white p-5 mt-8">
          <form action="">
            <h1 class="text-[2.5rem] font-bold">Payment Details</h1>
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

            <div class="input-field flex flex-col mt-4">
              <span class="text-[.75rem] font-bold mb-1">Card Number*</span>
              <input 
                  type="text" 
                  placeholder="**** **** **** ****"
                  class="border-black border bg-white text-[.875rem] p-3.5">
            </div>

            <div class="grid grid-cols-2 gap-4 mt-4">
              <div class="input-field flex flex-col">
                <span class="text-[.75rem] font-bold mb-1">Expiration Date*</span>
                <input 
                  type="text" 
                  placeholder="**/**"
                  class="border-black border bg-white text-[.875rem] p-3.5">
              </div>
              <div class="input-field flex flex-col">
                <span class="text-[.75rem] font-bold mb-1">CVC*</span>
                <input 
                  type="text" 
                  placeholder="***"
                  class="border-black border bg-white text-[.875rem] p-3.5">
              </div>
            </div>

            <div class="mt-4">
              <button 
                class="w-full hover:bg-opacity-90 transition-colors ease-in-out p-4 text-white bg-dark-green uppercase tracking-widest font-bold">
                Complete Reservation
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