/**
 * WordPress dependencies
 */
import { store, getContext, getElement } from "@wordpress/interactivity";

const { state } = store("fuellogic-app", {
  actions: {
    toggle: () => {
      const context = getContext();
      context.isOpen = !context.isOpen;
    }
  },
  callbacks: {
    showHideMenu: () => {
      const { ref } = getElement();
      const context = getContext();
      context.showMenu = !context.showMenu;
    }
  }
});
