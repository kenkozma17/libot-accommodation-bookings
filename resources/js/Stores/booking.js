import { defineStore } from 'pinia';
import dayjs from 'dayjs';

export const useBookingStore = defineStore('booking', {
  state: () => ({
    dates: {
      start: null,
      end: null,
    },
    guests: {
      adults: 1,
      children: 0,
      contactDetails: {
        firstName: null,
        lastName: null,
        nationality: null,
        email: null,
        phone: null,
        terms: false,
        requests: null,
      }
    },
    room: {
      id: null,
      name: null,
      description: null,
      images: [],
      rate: null,
      currency: 'PHP',
      max_occupancy: null,
      extra_occupant_rate: null,
    },
    add_ons: [
        {
            id: 1,
            name: 'Airport Pickup - 4 Pax',
            description: 'Convenient pickup service.',
            rate: 500,
        },
        {
            id: 2,
            name: 'Airport Dropoff - 4 Pax',
            description: 'Convenient drop off service.',
            rate: 350,
        },
        {
            id: 3,
            name: 'Extra Breakfast',
            description: 'Enjoy an additional breakfast.',
            rate: 300,
        },
    ],
    selected_add_ons: []
   }),
   getters: {
    checkInDate(state) {
      if(state.dates.start) {
        return dayjs(state.dates.start).format('MMMM D, YYYY');
      }
    },
    checkOutDate(state) {
      if(state.dates.end) {
        return dayjs(state.dates.end).format('MMMM D, YYYY');
      }
    },
    stayCount(state) {
      if(state.dates.start && state.dates.end) {
        const checkIn = dayjs(state.dates.start);
        const checkOut = dayjs(state.dates.end);

        return checkOut.diff(checkIn, 'day');
      }

      return 0;
    },
    guestsCount(state) {
      return `${(Number(state.guests.adults) +
        Number(state.guests.children))} Guests`;
    },
    guestsCountDetailed(state) {
      return `${state.guests.adults} Adult(s), ${state.guests.children} Child(s)`;
    },
    hasExtraGuest(state) {
        return (Number(state.guests.adults) + Number(state.guests.children)) > Number(state.room.max_occupancy);
    },
    extraOccupantRate(state) {
        if(this.hasExtraGuest) {
            return state.room.extra_occupant_rate;
        }
        return 0;
    },
    hasAddOns(state) {
        return this.hasExtraGuest || state.selected_add_ons.length > 0;
    },
    addOns(state) {
        return state.add_ons;
    },
    selectedAddOnsTotal(state) {
        if(state.selected_add_ons.length) {
            return state.selected_add_ons.reduce((total, addOn) => {
                return total + Number(addOn.rate);
            }, 0);
        }
        return 0;
    },
    subTotal(state) {
      return ((Number(state.room.rate) + Number(this.extraOccupantRate))  * this.stayCount) + Number(this.selectedAddOnsTotal);
    }
   },
   actions: {
    setCheckIn(date) {
      this.dates.start = date;
    },
    setCheckOut(date) {
      this.dates.end = date;
    },
    setAdultGuests(adults) {
      this.guests.adults = adults;
    },
    setChildrenGuests(children) {
      this.guests.children = children;
    },
    setRoom(room) {
      this.room = room;
    },
    setContactDetails(contact) {
      this.guests.contactDetails = contact;
    },
    resetBooking() {
      this.dates.start = this.dates.end = null;
      this.room = {
        id: null,
        name: null,
        description: null,
        images: [],
        rate: null,
        currency: 'PHP'
      };
      this.selected_add_ons = [];
    },
    setAddOn(addOn) {
        const index = this.selected_add_ons.findIndex(
            item => item.id === addOn.id
        );

        if (index !== -1) {
            this.selected_add_ons.splice(index, 1);
        } else {
            this.selected_add_ons.push(addOn);
        }
    },
   },
   persist: true,
})
