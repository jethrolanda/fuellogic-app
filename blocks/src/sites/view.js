/**
 * WordPress dependencies
 */
import { store, getContext, getElement } from "@wordpress/interactivity";

const { state } = store("fuellogic-app", {
  actions: {
    *submitForm(e) {
      e.preventDefault();

      const context = getContext();
      const { ref } = getElement();

      const formData = new FormData(ref);
      formData.append("action", "add_site");
      formData.append("nonce", state.nonce);

      const data = yield fetch(state.ajaxUrl, {
        method: "POST",
        body: formData
      }).then((response) => response.json());

      state.sites = data.data;
    },
    *deleteSite() {
      const context = getContext();
      var result = confirm("Are you sure?");
      if (result) {
        const formData = new FormData();
        formData.append("action", "delete_site");
        formData.append("nonce", state.nonce);
        formData.append("id", context.selectedSite);

        const data = yield fetch(state.ajaxUrl, {
          method: "POST",
          body: formData
        }).then((response) => response.json());

        state.sites = data.data;
      }
    }
  },
  callbacks: {
    openModal: () => {
      var modal = document.getElementById("myModal");
      modal.style.display = "block";
    },
    closeModal: () => {
      var modal = document.getElementById("myModal");
      modal.style.display = "none";
    },
    selectSite: () => {
      const context = getContext();
      const { ref } = getElement();

      let allLis = document.querySelectorAll("ul#sites-list li");
      // Iterate over all <li> elements inside <ul>
      allLis.forEach((li) => {
        li.classList.remove("selected");
      });

      context.selectedSite = ref.id;
      ref.classList.add("selected");
    }
  }
});
