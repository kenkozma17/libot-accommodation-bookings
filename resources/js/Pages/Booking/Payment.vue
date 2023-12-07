<script setup>
import BookingLayout from "@/Layouts/BookingLayout.vue";
import SummaryPanel from "@/Components/Booking/SummaryPanel.vue";
import RoomDetailsModal from "@/Components/Modals/RoomDetailsModal.vue";
import { useBookingStore } from "@/Stores/booking";
import { useForm } from "@inertiajs/vue3";
import { useModal } from "vue-final-modal";
import { Head } from "@inertiajs/vue3";

const bookingStore = useBookingStore();

const form = useForm({
    reservation: {
        dates: bookingStore.dates,
        guests: bookingStore.guests,
        room: bookingStore.room,
        stayCount: bookingStore.stayCount,
    },
});

const submit = () => {
    form.post(route("payment.create"), {
        errorBag: "createPayment",
        preserveScroll: true,
    });
    bookingStore.resetBooking();
};

const openModal = (room) => {
    const modal = useModal({
        component: RoomDetailsModal,
        attrs: {
            room,
            onClose() {
                modal.close();
            },
            onSelectRoom() {
                selectRoom(room);
                modal.close();
            },
        },
    });
    modal.open();
};
</script>
<template>
    <BookingLayout>
        <div class="grid grid-cols-12 my-5 gap-7">
            <Head title="Payment" />

            <div class="md:col-span-8 col-span-12">
                <div class="border border-black bg-white">
                    <div class="border-b border-black text-center py-5 px-2">
                        <p
                            class="text-[.875rem] font-bold uppercase tracking-widest"
                        >
                            Travel Details
                        </p>
                    </div>
                    <div class="grid grid-cols-6 py-8 px-6 gap-4">
                        <div class="flex flex-col lg:col-span-2 col-span-3">
                            <span class="text-[1rem] font-bold">Name</span>
                            <span class="text-[0.875rem]">
                                {{
                                    bookingStore.guests.contactDetails
                                        .firstName +
                                    " " +
                                    bookingStore.guests.contactDetails.lastName
                                }}
                            </span>
                        </div>
                        <div class="flex flex-col lg:col-span-2 col-span-3">
                            <span class="text-[1rem] font-bold">Arrival</span>
                            <span class="text-[0.875rem]">
                                {{ bookingStore.checkInDate }}
                            </span>
                        </div>
                        <div class="flex flex-col lg:col-span-2 col-span-3">
                            <span class="text-[1rem] font-bold">Departure</span>
                            <span class="text-[0.875rem]">
                                {{ bookingStore.checkOutDate }}
                            </span>
                        </div>
                        <div class="flex flex-col lg:col-span-2 col-span-3">
                            <span class="text-[1rem] font-bold"
                                >Email Address</span
                            >
                            <span class="text-[0.875rem]">
                                {{ bookingStore.guests.contactDetails.email }}
                            </span>
                        </div>
                        <div class="flex flex-col lg:col-span-2 col-span-3">
                            <span class="text-[1rem] font-bold"
                                >Phone Number</span
                            >
                            <span class="text-[0.875rem]">
                                {{ bookingStore.guests.contactDetails.phone }}
                            </span>
                        </div>
                        <div class="flex flex-col lg:col-span-2 col-span-3">
                            <span class="text-[1rem] font-bold"
                                >Nationality</span
                            >
                            <span class="text-[0.875rem]">
                                {{
                                    bookingStore.guests.contactDetails
                                        .nationality
                                }}
                            </span>
                        </div>
                    </div>
                    <div
                        class="border-b border-t border-black text-center py-5 px-2"
                    >
                        <p
                            class="text-[.875rem] font-bold uppercase tracking-widest"
                        >
                            Room Details
                        </p>
                    </div>
                    <div
                        class="room-details relative p-8 grid grid-cols-12 space-x-4"
                    >
                        <div class="col-span-4 relative">
                            <img
                                :src="bookingStore.room.cover_image_url"
                                class="w-full"
                                alt=""
                            />
                        </div>
                        <div class="col-span-8 flex flex-col justify-between">
                            <div class="mb-2">
                                <h3
                                    class="text-[1.25rem] font-bold tracking-wider"
                                >
                                    {{ bookingStore.room.name }}
                                </h3>
                                <p class="text-[.875rem] mt-2">
                                    {{ bookingStore.room.short_description }}
                                </p>
                            </div>
                            <div class="flex">
                                <a
                                    @click="openModal(bookingStore.room)"
                                    class="cursor-pointer text-black font-bold text-[1rem] bg-back-gray px-4 py-3.5"
                                >
                                    Room Details
                                </a>
                            </div>
                        </div>
                    </div>
                    <form class="pb-4 px-8" @submit.prevent="submit">
                        <div>
                            <button
                                class="w-full hover:bg-opacity-90 transition-colors ease-in-out p-4 text-white bg-dark-green uppercase tracking-widest font-bold"
                            >
                                Continue to Payment
                            </button>
                        </div>
                    </form>
                </div>

                <!-- <div class="border border-black bg-white p-5 mt-8">
            <h1 class="md:text-[2.5rem] text-[1.5rem] font-bold">Payment Details</h1>
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

            <form @submit.prevent="submit">
              <div class="mt-4">
                <button 
                  class="w-full hover:bg-opacity-90 transition-colors ease-in-out p-4 text-white bg-dark-green uppercase tracking-widest font-bold">
                  Continue to Payment
                </button>
              </div>
            </form>
        </div> -->
            </div>
            <div class="md:col-span-4 col-span-12 md:order-last order-first">
                <SummaryPanel></SummaryPanel>
            </div>
        </div>
    </BookingLayout>
</template>
