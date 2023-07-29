<script setup>
  import FormSection from '@/Components/FormSection.vue';
  import { computed } from 'vue';
  import { useForm, Link } from '@inertiajs/vue3';
  import PrimaryButton from '@/Components/PrimaryButton.vue';
  import SecondaryButton from '@/Components/SecondaryButton.vue';
  import InputLabel from '@/Components/InputLabel.vue';
  import InputError from '@/Components/InputError.vue';
  import dayjs from 'dayjs';

  const props = defineProps({
    room: Object
  });

  const unavailableDates = computed(() => [
    {
      highlight: 'blue',
      dates: form.new_unavailable_dates,
    },
    ...props.room.unavailable_dates.map((date, index) => ({
      highlight: date.is_range ? 'green' : 'red',
      dot: 'yellow',
      dates: date.is_range ? {start: new Date(date.start_date), end: new Date(date.end_date)} : [new Date(date.start_date)],
      popover: true,
      customData: date,
      hideIndicator: false,
    })),
  ]);


const form = useForm({
  new_unavailable_dates: [],
  notes: ''
});

const form2 = useForm({});

const blockDate = () => {
    form.post(route('rooms.block-date', props.room.id), {
        errorBag: 'blockDate',
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
};

const unblockDate = (unavailabilityId) => {
  form2.post(route('rooms.unblock-date', unavailabilityId), {
    errorBag: 'unblockDate',
    preserveScroll: true,
    onSuccess: () => form.reset(),
  });
};

function select(e) {
  let date = dayjs(e.date).format('YYYY-MM-DD');
  if(e.attributes.length === 0) {
    form.new_unavailable_dates.push(date);
  }
}
</script>
<template>
  <FormSection @submitted="blockDate"> 
    <template #title>
        Room Availability
    </template>

    <template #description>
        Have a quick glimpse of this room's availability and manually remove available dates.
    </template>

    <template #form>
      <div class="col-span-6">
        <VDatePicker
          :disabled="true"
          :is-dark="true"
          :min-date="new Date()"
          expanded
          :columns="1"
          @dayclick="select"
          :attributes="unavailableDates">
            <template #day-popover="{ attributes }">
              <div class="px-2" 
                  v-for="{ key, customData } in attributes"
                  :key="key">
                  <div
                    class="block text-xs text-gray-700 dark:text-gray-300">
                    <div v-if="customData.booking">
                      <Link 
                        :href="route('bookings.show', customData.booking.id)" 
                        class="dark:text-gray-300">
                        <p class="text-center font-semibold" v-if="customData.booking">
                          {{ dayjs(customData.start_date).format('MMMM D, YYYY') }} 
                          - {{ dayjs(customData.end_date).format('MMMM D, YYYY') }}
                        </p>
                        <p class="font-semibold">
                          {{ customData.booking.guest.full_name }} (#{{ customData.booking.booking_confirmation }})
                        </p>
                      </Link>
                    </div>
                    <div v-else>
                      <p class="font-semibold">Blocked Off</p>
                      <p>Notes: {{ customData.notes ? customData.notes : 'N/A' }}</p>
                      <SecondaryButton
                        @click="unblockDate(customData.id)"
                        class="mt-2">
                        Unblock
                      </SecondaryButton>
                    </div>
                  </div>
                <hr class="my-2">
              </div>
            </template>
          </VDatePicker>
      </div>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="notes" value="Notes" />
        <textarea
            id="notes"
            v-model="form.notes"
            type="text"
            class="block w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
            autofocus
        ></textarea>
        <InputError :message="form.errors.notes" class="mt-2" />
      </div>
    </template>

    <template #actions>
        <SecondaryButton 
          v-if="form.new_unavailable_dates.length"
          @click="form.reset()">
          {{ isReadOnly ? 'Edit' : 'Cancel'}}
        </SecondaryButton>
        <PrimaryButton 
          :class="{ 'opacity-25': form.processing }" 
          class="ml-2"
          :disabled="form.processing">
            Update
        </PrimaryButton>
    </template>
  </FormSection>
</template>