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
    }
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
        return state.room.extra_occupant_rate;
    },
    hasAddOns(state) {
        return this.hasExtraGuest;
    },
    subTotal(state) {
      return (Number(state.room.rate) + Number(this.extraOccupantRate)) * this.stayCount;
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
    }
   },
   persist: true,
})
