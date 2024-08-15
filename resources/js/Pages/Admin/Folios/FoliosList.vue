<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import TableList from "@/Components/TableList.vue";
import PaginationList from "@/Components/PaginationList.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { Link } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
    folios: Object,
    search: String,
});

const s = ref(props.search);
</script>
<template>
    <AppLayout title="Folios Management">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Folios Management
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <TableList>
                        <template #search>
                            <div
                                class="flex md:flex-row flex-col space-y-2 justify-between w-full"
                            >
                                <form action="" class="md:w-96 w-full">
                                    <label for="search" class="sr-only"
                                        >Search</label
                                    >
                                    <input
                                        type="text"
                                        v-model="s"
                                        name="search"
                                        id="search"
                                        class="p-3 pl-10 block w-full border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500"
                                        placeholder="Search by Guest Name, Reg. No., Booking Confirmation..."
                                    />
                                </form>
                                <SecondaryButton class="justify-center">
                                    <Link :href="route('folios.index')">
                                        Clear Search
                                    </Link>
                                </SecondaryButton>
                            </div>
                        </template>
                        <template #header>
                            <tr>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
                                >
                                    Registration Number
                                </th>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
                                >
                                    Guest Name
                                </th>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
                                >
                                    Booking Confirmation
                                </th>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase"
                                >
                                    Action
                                </th>
                            </tr>
                        </template>
                        <template #content>
                            <tr v-for="folio in folios.data">
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium"
                                >
                                    <Link
                                        :href="
                                            route('folios.show', folio.id)
                                        "
                                    >
                                        {{ folio.registration_number }}
                                    </Link>
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium"
                                >
                                    <Link v-if="folio.guest_id"
                                        :href="
                                            route('guests.show', folio.guest_id)
                                        "
                                    >
                                        {{ folio.guest.last_name }}, {{ folio.guest.first_name }}
                                    </Link>
                                    <span v-else>N/A</span>
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium"
                                >
                                    <Link
                                        v-if="folio.booking"
                                        :href="
                                            route('bookings.show', folio.booking.id)
                                        "
                                        >{{folio.booking.booking_confirmation}}</Link
                                    >
                                    <span v-else>N/A</span>
                                </td>
                                <td
                                        class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                                    >
                                    <Link
                                        :href="
                                            route('folios.show', folio.id)
                                        "
                                        >View</Link
                                    >
                                </td>
                            </tr>
                        </template>
                        <template #pagination>
                            <PaginationList :links="folios.links" />
                        </template>
                    </TableList>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
