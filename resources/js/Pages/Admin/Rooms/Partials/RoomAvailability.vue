<script setup>
  import FormSection from '@/Components/FormSection.vue';
  import { computed } from 'vue';
  import { useForm, Link } from '@inertiajs/vue3';
  import PrimaryButton from '@/Components/PrimaryButton.vue';
  import InputLabel from '@/Components/InputLabel.vue';
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

const markUnavailable = () => {
    form.post(route('rooms.mark-unavailable', props.room.id), {
        errorBag: 'markUnavailable',
        preserveScroll: true,
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
  <FormSection @submitted="markUnavailable"> 
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
          expanded
          :columns="2"
          @dayclick="select"
          :attributes="unavailableDates">
            <template #day-popover="{ dayTitle, attributes }">
              <div class="px-2" 
                  v-for="{ key, customData } in attributes"
                  :key="key">
                <Link href="#" class="dark:text-gray-300">
                  <div
                    class="block text-xs text-gray-700 dark:text-gray-300">
                    <div v-if="customData.booking">
                      <p class="text-center font-semibold" v-if="customData.booking">
                        {{ dayjs(customData.start_date).format('MMMM D, YYYY') }} 
                        - {{ dayjs(customData.end_date).format('MMMM D, YYYY') }}
                      </p>
                      <p class="font-semibold">
                        {{ customData.booking.guest.full_name }} (#{{ customData.booking.booking_confirmation }})
                      </p>
                    </div>
                    <div v-else>
                      <p class="font-semibold">Blocked Off</p>
                      <p>Notes: {{ customData.notes ? customData.notes : 'N/A' }}</p>
                    </div>
                  </div>
                </Link>
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
          <PrimaryButton 
            :class="{ 'opacity-25': form.processing }" 
            :disabled="form.processing">
              Update
          </PrimaryButton>
      </template>
  </FormSection>
</template>