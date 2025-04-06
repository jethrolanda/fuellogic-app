/**
 * WordPress dependencies
 */
import { store, getContext, getElement } from "@wordpress/interactivity";

const { state } = store("fuellogic-app", {
  actions: {
    showModal: () => {
      const el = document.body.querySelector(
        ".wp-block-fuellogic-app-reorder .modal"
      );
      if (el) el.style.display = "flex";
    },
    closeReorderModal: () => {
      const el = document.body.querySelector(
        ".wp-block-fuellogic-app-reorder .modal"
      );
      if (el) el.style.display = "none";
    },
    selectSite: (e) => {
      const context = getContext();

      const selectedSite = context.sites.find(
        (site) => parseInt(site.id) === parseInt(e.target.value)
      );
      console.log(selectedSite);
      context.siteDetails = selectedSite;
    }
  },
  callbacks: {}
});
