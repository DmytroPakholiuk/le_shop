// Utilities
import { defineStore } from 'pinia'

export const useAppStore = defineStore('app', {
  state: () => ({
    slideBarVisible: false
  }),
  actions: {
    slideBar() {
      this.slideBarVisible = !this.slideBarVisible
    }
  }
})
