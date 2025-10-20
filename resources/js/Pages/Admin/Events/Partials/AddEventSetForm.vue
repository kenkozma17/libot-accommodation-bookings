<script setup>
import { useForm } from "@inertiajs/vue3";
import FormSection from "@/Components/FormSection.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import TableList from "@/Components/TableList.vue";
import { Link } from "@inertiajs/vue3";
import { computed } from "vue";
import CloseIcon from "@/Components/Icons/CloseIcon.vue";

const props = defineProps({
  event: Object,
  sets: Array,
});

const form = useForm({
  event_id: "",
  set_id: "",
});

const addEventSet = () => {
  form.post(route("events.add-event-set", props.event.id), {
    errorBag: "addEventSet",
    preserveScroll: true,
  });
};

const deleteForm = useForm({
  set_id: ""
});

const removeEventSet = (setId) => {
  if(window.confirm('Are you sure you want to remove this event set?')) {
    deleteForm.set_id = setId;
    deleteForm.delete(route("events.remove-event-set", props.event.id), {
      errorBag: "addEventSet",
      preserveScroll: true,
    });
  }
};

const generatePdf = () => {
  const sets = props.event.sets;
  const services = sets.map(set => {
    return set.services;
  });

  const url = route("event-sets.generate", {
    services: JSON.stringify(services.flat()),
    pax: props.event.pax
  });
  window.open(url, "_blank");
};
</script>
<template>
  <FormSection @submitted="addEventSet">
    <template #title> Attached Event Sets </template>

    <template #description>
      Attach Event Set that will be consumed during the event.
    </template>

    <template #form>
      <div
        class="px-6 py-4 bg-white overflow-hidden shadow-xl sm:rounded-lg col-span-6 border-gray border"
        v-if="props.event.sets.length > 0"
      >
        <p class="font-semibold">Attached Event Sets</p>
        <ul class="mt-2">
          <li v-for="(set, index) in props.event.sets" class="mt-2 flex justify-between">
            <div>
              {{ index + 1 }}.
              <a class="font-semibold" :href="route('event-sets.show', set.id)">{{
                set.name
              }}</a>
              <span> x {{ event.pax }}pax</span>
              <ul class="ml-4" v-if="set.services.length > 0">
                <li v-for="item in set.services">-> {{ item.name }}</li>
              </ul>
            </div>
            <CloseIcon class="cursor-pointer" @click="removeEventSet(set.id)" stroke="#C22706" fill="#C22706" />
          </li>
        </ul>
        <PrimaryButton
          @click="generatePdf"
          v-if="props.event.sets.length > 0"
          class="mt-6"
          type="button"
        >
          Generate P.O.
        </PrimaryButton>
      </div>

      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="set" value="Event Sets" />
        <select
          required
          class="block w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
          v-model="form.set_id"
          name="set"
          id="set"
        >
          <option value="" disabled>Select Event Set</option>
          <option v-for="set in sets" :value="set.id">
            {{ set.name }}
          </option>
        </select>
        <InputError :message="form.errors.set" class="mt-2" />
      </div>
    </template>

    <template #actions>
      <PrimaryButton
        :class="{ 'opacity-25': form.processing }"
        :disabled="form.processing"
      >
        Add
      </PrimaryButton>
    </template>
  </FormSection>
</template>
