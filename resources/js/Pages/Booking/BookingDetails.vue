<script setup>
import BookingLayout from "@/Layouts/BookingLayout.vue";
import SummaryPanel from "@/Components/Booking/SummaryPanel.vue";
import { reactive, computed, onMounted } from "vue";
import { router } from "@inertiajs/vue3";
import { useBookingStore } from "@/Stores/booking";
import { useToast } from "vue-toast-notification";
import countries from "@/countries";
import { Head } from "@inertiajs/vue3";

const listOfCountries = reactive(countries);

const bookingStore = useBookingStore();
const $toast = useToast({
    position: "top-right",
});

const props = defineProps({ errors: Object });

let contactDetails = reactive({
    firstName: null,
    lastName: null,
    nationality: "Philippines (the)",
    email: null,
    phone: null,
    terms: false,
    requests: null,
});

function submitContact() {
    bookingStore.setContactDetails(contactDetails);
    router.post(
        "/booking-details",
        {
            contactDetails,
            room: bookingStore.room,
        },
        {
            onError: (errors) => {
                for (let key in errors) {
                    $toast.error(errors[key]);
                }
            },
        }
    );
}

const validationErrors = computed(() => {
    return props.errors;
});
</script>
<template>
    <BookingLayout>
        <Head title="Booking Details" />
        <div class="grid grid-cols-12 my-5 gap-7">
            <div class="md:col-span-8 col-span-12">
                <div class="border border-black bg-white p-5">
                    <form @submit.prevent="submitContact">
                        <h1 class="text-[2.5rem] font-bold">Booking Details</h1>
                        <div class="grid grid-cols-2 gap-4 mt-2">
                            <div
                                class="input-field flex flex-col md:col-span-1 col-span-2"
                            >
                                <span class="text-[.75rem] font-bold mb-1"
                                    >First Name*</span
                                >
                                <input
                                    v-model="contactDetails.firstName"
                                    type="text"
                                    placeholder="First Name"
                                    :class="
                                        validationErrors[
                                            'contactDetails.firstName'
                                        ]
                                            ? 'border-red-700'
                                            : 'border-black'
                                    "
                                    class="border bg-white text-[.875rem] p-3.5"
                                />
                            </div>
                            <div
                                class="input-field flex flex-col md:col-span-1 col-span-2"
                            >
                                <span class="text-[.75rem] font-bold mb-1"
                                    >Last Name*</span
                                >
                                <input
                                    v-model="contactDetails.lastName"
                                    type="text"
                                    placeholder="Last Name"
                                    :class="
                                        validationErrors[
                                            'contactDetails.lastName'
                                        ]
                                            ? 'border-red-700'
                                            : 'border-black'
                                    "
                                    class="border bg-white text-[.875rem] p-3.5"
                                />
                            </div>
                        </div>
                        <div class="grid grid-cols-12 gap-4 mt-4">
                            <div
                                class="input-field md:col-span-6 col-span-12 flex flex-col"
                            >
                                <span class="text-[.75rem] font-bold mb-1"
                                    >Nationality*</span
                                >
                                <select
                                    v-model="contactDetails.nationality"
                                    :class="
                                        validationErrors[
                                            'contactDetails.nationality'
                                        ]
                                            ? 'border-red-700'
                                            : 'border-black'
                                    "
                                    class="border bg-white text-[.875rem] p-3.5"
                                >
                                    <option
                                        v-for="country in listOfCountries"
                                        :value="country"
                                    >
                                        {{ country }}
                                    </option>
                                </select>
                            </div>
                            <div
                                class="input-field md:col-span-6 col-span-12 flex flex-col"
                            >
                                <span class="text-[.75rem] font-bold mb-1"
                                    >Email*</span
                                >
                                <input
                                    v-model="contactDetails.email"
                                    type="email"
                                    placeholder="Enter your email"
                                    :class="
                                        validationErrors['contactDetails.email']
                                            ? 'border-red-700'
                                            : 'border-black'
                                    "
                                    class="border bg-white text-[.875rem] p-3.5"
                                />
                            </div>
                        </div>
                        <div class="flex flex-col mt-4">
                            <span class="text-[.75rem] font-bold mb-1"
                                >Phone Number*</span
                            >
                            <vue-tel-input
                                class="phone"
                                :inputOptions="{
                                    showDialCode: true,
                                    maxlength: 15,
                                }"
                                :class="
                                    validationErrors['contactDetails.phone']
                                        ? 'error'
                                        : 'border-black'
                                "
                                styleClasses="border rounded-none bg-white text-[.875rem] p-2.5"
                                mode="international"
                                v-model="contactDetails.phone"
                            >
                            </vue-tel-input>
                        </div>
                        <div class="input-field flex flex-col mt-4">
                            <span class="text-[.75rem] font-bold mb-1"
                                >Special Requests</span
                            >
                            <textarea
                                v-model="contactDetails.requests"
                                rows="3"
                                placeholder="Please let us know if you have any special requests"
                                class="border-black border bg-white text-[.875rem] p-3.5"
                            ></textarea>
                        </div>

                        <div class="mt-4">
                            <label for="terms" class="cursor-pointer">
                                <input
                                    name="terms"
                                    id="terms"
                                    type="checkbox"
                                    v-model="contactDetails.terms"
                                />
                                <span class="text-[.75rem] ml-2">
                                    I agree to have read the Terms &
                                    <a
                                        href="/cancellation-policy"
                                        class="font-bold"
                                        >Cancellation Policy</a
                                    >,
                                    <a href="" class="font-bold"
                                        >Privacy Policy</a
                                    >
                                    &
                                    <a href="" class="font-bold"
                                        >Safety Standards</a
                                    >.*
                                </span>
                            </label>
                        </div>
                        <div class="mt-4">
                            <button
                                class="w-full hover:bg-opacity-90 transition-colors ease-in-out p-4 text-white bg-dark-green uppercase tracking-widest font-bold"
                            >
                                Review Your Stay
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="md:col-span-4 col-span-12 md:order-last order-first">
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
.phone.error {
    border-color: rgb(185 28 28);
}
</style>
