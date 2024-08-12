<script setup>
import { computed } from "vue";
import FormSection from "@/Components/FormSection.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";

const props = defineProps({
  folio: Object
});

const guestFullName = computed(() => {
    if(props.folio.guest) {
        return `${props.folio.guest.last_name}, ${props.folio.guest.first_name}`;
    }
});

</script>
<template>
  <FormSection @submitted="createFolio">
    <template #title> Folio Information </template>

    <template #form>
        <div class="col-span-6 sm:col-span-4" v-if="props.folio.guest">
            <InputLabel
                    for="guest_id"
                    value="Guest"
                />
            <TextInput
                :disabled="true"
                :class="{ 'bg-gray-100': true }"
                id="guest_id"
                v-model="guestFullName"
                type="text"
                class="block w-full mt-1"
                autofocus
            />
        </div>
        <div class="col-span-6 sm:col-span-4" v-if="props.folio.booking">
            <InputLabel
                    for="booking_id"
                    value="Booking"
                />
            <TextInput
                :disabled="true"
                :class="{ 'bg-gray-100': true }"
                id="guest_id"
                v-model="props.folio.booking.booking_confirmation"
                type="text"
                class="block w-full mt-1"
                autofocus
            />
        </div>
    </template>
  </FormSection>
</template>
