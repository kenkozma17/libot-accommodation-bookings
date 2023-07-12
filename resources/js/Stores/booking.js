import { defineStore } from 'pinia';
import dayjs from 'dayjs';

export const useBookingStore = defineStore('booking', {
  state: () => ({ 
    dates: {
      checkIn: null,
      checkOut: null,
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
        requests: null,
      }
    },
    room: {
      id: 1,
      name: "Superior Grand Suite",
      description: "Our Essence double room: cosy 30-35m² for feel-good moments. For you and your favourite person.",
      images: [],
      price: 1000,
      currency: "PHP"
    }
   }),
   getters: {
    checkInDate(state) {
      if(state.dates.checkIn) {
        return dayjs(state.dates.checkIn).format('MMMM D, YYYY');
      }
    },
    checkOutDate(state) {
      if(state.dates.checkOut) {
        return dayjs(state.dates.checkOut).format('MMMM D, YYYY');
      }
    },
    stayCount(state) {
      if(state.dates.checkIn && state.dates.checkOut) {
        const checkIn = dayjs(state.dates.checkIn);
        const checkOut = dayjs(state.dates.checkOut);

        return checkOut.diff(checkIn, 'day');
      }

      return 0;
    },
    guestsCount(state) {
      return `${(Number(state.guests.adults) + 
        Number(state.guests.children))} Guests`;
    },
    guestsCountDetailed(state) {
      return `${state.guests.adults} Adult(s), ${state.guests.children} Child(s)`
    }
   },
   actions: {
    setCheckIn(date) {
      this.dates.checkIn = date;
    },
    setCheckOut(date) {
      this.dates.checkOut = date;
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
    }
   },
   persist: true,
})