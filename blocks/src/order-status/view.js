/**
 * WordPress dependencies
 */
import { store, getContext, getElement } from "@wordpress/interactivity";

const { state } = store("fuellogic-app", {
  actions: {},
  callbacks: {
    clicked: () => {
      const context = getContext();
      alert(state.selectedSite);
    }
  }
});
