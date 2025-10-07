<script setup>
import { useForm } from "@inertiajs/vue3";
import FormSection from "@/Components/FormSection.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import TableList from "@/Components/TableList.vue";
import { Link } from "@inertiajs/vue3";
import { computed } from "vue";

const props = defineProps({
  set: Object,
  serviceCategories: Array,
});

const form = useForm({
  service_id: "",
});

const addService = () => {
  form.post(route("event-sets.add-service", props.set.id), {
    errorBag: "addService",
    preserveScroll: true,
  });
};

const deleteForm = useForm({
  service_id: "",
});

const removeService = (serviceId) => {
  if (
    window.confirm("Are you sure you want to remove this service from the event set?")
  ) {
    deleteForm.service_id = serviceId;
    deleteForm.delete(route("event-sets.remove-service", props.set.id), {
      errorBag: "removeService",
      preserveScroll: true,
    });
  }
};

const filteredServices = computed(() => {
  const services = props.set.services;
  return services;
})

const generatePdf = () => {
  const url = route("event-sets.generate", { services: JSON.stringify(filteredServices.value) });
  window.open(url, "_blank");
};

const estCostTotal = computed(() => {
  if(props.set.services) {
    const attachedServices = props.set.services;
    let compiledEstCosts = [];

    if(attachedServices) {
      compiledEstCosts = attachedServices.map(item => {
        return item.est_unit_cost;
      });
    }

    const estCostTotal = compiledEstCosts.reduce((accumulator, currentValue) => accumulator + currentValue, 0);
    return estCostTotal.toLocaleString();
  }

  return 0;
});
</script>
<template>
  <FormSection @submitted="addService">
    <template #title> Services </template>

    <template #description>
      Attach Services that are consumed when this Event Set is used.
    </template>

    <template #form>
      <div
        class="bg-white overflow-hidden shadow-xl sm:rounded-lg col-span-6 border-gray border"
        v-if="props.set?.services.length"
      >
        <p class="px-6 py-4 font-semibold">Attached Services</p>
        <TableList :hasSearch="false">
          <template #header>
            <tr>
              <th
                scope="col"
                class="px-6 py-3 w-[200px] text-left text-xs font-medium text-gray-500 uppercase"
              >
                Action
              </th>
              <th
                scope="col"
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
              >
                Name
              </th>
              <th
                scope="col"
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
              >
                Est. Unit Cost
              </th>
            </tr>
          </template>
          <template #content>
            <tr v-for="service in props.set.services">
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <p
                  @click="removeService(service.id)"
                  class="text-red-600 font-semibold hover:underline cursor-pointer"
                >
                  Remove
                </p>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <Link :href="route('services.show', service.id)">{{ service.name }}</Link>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                P{{ service.est_unit_cost?.toLocaleString() }}
              </td>
            </tr>
            <tr>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-left">
                <PrimaryButton @click="generatePdf" :disabled="!filteredServices.length"> Print </PrimaryButton>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-left">
                <span class="font-bold">Total</span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-left">
                <span class="font-bold">P{{ estCostTotal }}</span>
              </td>
            </tr>
          </template>
        </TableList>
      </div>

      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="services" value="Services" />
        <select
          required
          class="block w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
          v-model="form.service_id"
          name="services"
          id="services"
        >
          <option value="" disabled selected>Select Service</option>
          <template v-for="serviceCategory in props.serviceCategories">
            <option disabled>{{ serviceCategory.name }}</option>
            <option
              class="ml-[1rem]"
              v-if="serviceCategory.services"
              v-for="service in serviceCategory.services"
              :key="service.id"
              :value="service.id"
            >
              &nbsp;&nbsp;{{ service.name }} - {{ service.formatted_price }}
            </option>
          </template>
        </select>
        <InputError :message="form.errors.service_id" class="mt-2" />
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
