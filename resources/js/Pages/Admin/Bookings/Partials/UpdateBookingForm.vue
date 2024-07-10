<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import FormSection from "@/Components/FormSection.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";

const isReadOnly = ref(true);

const props = defineProps({
    booking: Object,
});

const form = useForm({
    id: props.booking.id,
    booking_confirmation: props.booking.booking_confirmation,
    check_in: props.booking.check_in_formatted,
    check_out: props.booking.check_out_formatted,
    total_price: props.booking.payment ? props.booking.payment.payment_amount_formatted : "PHP " + props.booking.total_price,
    rate_per_night: "PHP " + props.booking.rate_per_night_formatted,
    booking_status: props.booking.booking_status,
    special_requests: props.booking.special_requests,
    adults_count: props.booking.adults_count,
    children_count: props.booking.children_count,
    stay_length: props.booking.stay_length,
});
</script>
<template>
    <FormSection>
        <template #title> Booking Information </template>

        <template #description> The reservation details. </template>

        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="booking_date" value="Booking Date" />
                <TextInput
                    :disabled="true"
                    :class="{ 'bg-gray-100': true }"
                    id="date_placed"
                    v-model="props.booking.created_at_formatted"
                    type="text"
                    class="block w-full mt-1"
                    autofocus
                />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <InputLabel
                    for="booking_confirmation"
                    value="Booking Confirmation"
                />
                <TextInput
                    :disabled="isReadOnly"
                    :class="{ 'bg-gray-100': isReadOnly }"
                    id="booking_confirmation"
                    v-model="form.booking_confirmation"
                    type="text"
                    class="block w-full mt-1"
                    autofocus
                />
                <InputError
                    :message="form.errors.booking_confirmation"
                    class="mt-2"
                />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="check_in" value="Check In Date" />
                <TextInput
                    :disabled="isReadOnly"
                    :class="{ 'bg-gray-100': isReadOnly }"
                    id="check_in"
                    v-model="form.check_in"
                    type="text"
                    class="block w-full mt-1"
                    autofocus
                />
                <InputError :message="form.errors.check_in" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="check_out" value="Check Out Date" />
                <TextInput
                    :disabled="isReadOnly"
                    :class="{ 'bg-gray-100': isReadOnly }"
                    id="check_out"
                    v-model="form.check_out"
                    type="text"
                    class="block w-full mt-1"
                    autofocus
                />
                <InputError :message="form.errors.check_out" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="stay_length" value="Stay Length" />
                <TextInput
                    :disabled="isReadOnly"
                    :class="{ 'bg-gray-100': isReadOnly }"
                    id="stay_length"
                    v-model="form.stay_length"
                    type="text"
                    class="block w-full mt-1"
                    autofocus
                />
                <InputError :message="form.errors.stay_length" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="rate_per_night" value="Rate (Per Night PHP)" />
                <TextInput
                    :disabled="isReadOnly"
                    :class="{ 'bg-gray-100': isReadOnly }"
                    id="rate_per_night"
                    v-model="form.rate_per_night"
                    type="text"
                    class="block w-full mt-1"
                    autofocus
                />
                <InputError
                    :message="form.errors.rate_per_night"
                    class="mt-2"
                />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="total_price" value="Total Amount Paid (PHP)" />
                <TextInput
                    :disabled="isReadOnly"
                    :class="{ 'bg-gray-100': isReadOnly }"
                    id="total_price"
                    v-model="form.total_price"
                    type="text"
                    class="block w-full mt-1"
                    autofocus
                />
                <InputError :message="form.errors.total_price" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="booking_status" value="Booking Status" />
                <TextInput
                    :disabled="isReadOnly"
                    :class="{ 'bg-gray-100': isReadOnly }"
                    id="booking_status"
                    v-model="form.booking_status"
                    type="text"
                    class="block w-full mt-1"
                    autofocus
                />
                <InputError
                    :message="form.errors.booking_status"
                    class="mt-2"
                />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="adults_count" value="Adult(s)" />
                <TextInput
                    :disabled="isReadOnly"
                    :class="{ 'bg-gray-100': isReadOnly }"
                    id="adults_count"
                    v-model="form.adults_count"
                    type="text"
                    class="block w-full mt-1"
                    autofocus
                />
                <InputError :message="form.errors.adults_count" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="children_count" value="Children" />
                <TextInput
                    :disabled="isReadOnly"
                    :class="{ 'bg-gray-100': isReadOnly }"
                    id="children_count"
                    v-model="form.children_count"
                    type="text"
                    class="block w-full mt-1"
                    autofocus
                />
                <InputError
                    :message="form.errors.children_count"
                    class="mt-2"
                />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="special_requests" value="Special Requests" />
                <textarea
                    :disabled="isReadOnly"
                    :class="{ 'bg-gray-100': isReadOnly }"
                    id="special_requests"
                    v-model="form.special_requests"
                    type="text"
                    class="block w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    autofocus
                ></textarea>
                <InputError
                    :message="form.errors.special_requests"
                    class="mt-2"
                />
            </div>
        </template>

        <template #actions>
            <SecondaryButton :disabled="true" @click="resetForm">
                {{ isReadOnly ? "Edit" : "Cancel" }}
            </SecondaryButton>
            <PrimaryButton
                v-if="!isReadOnly"
                class="ml-2"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
            >
                Update
            </PrimaryButton>
        </template>
    </FormSection>
</template>
