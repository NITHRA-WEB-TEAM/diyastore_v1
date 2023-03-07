import {defineStore} from 'pinia';

export const useTodosStore = defineStore('cart', {
    state: () => ({
        cartCount: 0
    }),

});
