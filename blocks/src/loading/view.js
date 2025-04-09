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
    hideLoadingScreen: () => {
      const { ref } = getElement();
      document.body.style.overflow = "hidden";
      setTimeout(function () {
        const loadingScreen = ref.querySelector(".loading-screen");
        if (loadingScreen) {
          loadingScreen.style.display = "none";
        }
        document.body.style.overflow = "auto";
      }, state.attributes.loadingScreenTimeout);
    }
  }
});
