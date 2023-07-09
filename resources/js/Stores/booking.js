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
    },
    roomId: 0
   }),
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
    }
   },
   persist: true,
})