/**
 * WordPress dependencies
 */
import { store, getContext, getElement } from "@wordpress/interactivity";

const { callbacks } = store("fuellogic-app", {
  state: {},
  actions: {
    submitForm: () => {}
  },
  callbacks: {
    init: () => {
      const context = getContext();
      const step = context.currentStep;

      // Content
      const contents = document.getElementsByClassName("step-content");

      for (let content of contents) {
        const contentStep = content.dataset.step;

        if (step == contentStep) {
          content.removeAttribute("hidden");
        } else {
          content.setAttribute("hidden", "true");
        }
      }
    },
    navigate: () => {
      const context = getContext();
      const el = getElement();
      const active = document.getElementsByClassName("active");
      const step = el.ref.dataset.step;

      // Set current step
      context.currentStep = step;

      // Transfer the active tab step
      active[0].classList.remove("active");
      el.ref.classList.add("active");

      callbacks.init();
    },
    onFormUpdate: () => {
      const { ref } = getElement();
      const context = getContext();
      const formData = new FormData(ref);
      // for (const value of formData.entries()) {
      //   console.log(value);
      // }
      console.log(formData.get("one_time_delivery"));
      const otd = formData.get("one_time_delivery");

      // Show wrapper container
      document.getElementsByClassName(
        "delivery-schedule-wrapper"
      )[0].style.display = "block";

      if (otd === "yes") {
        const option2 = document.getElementsByClassName("option2");
        for (let i = 0; i < option2.length; i++) {
          option2[i].style.display = "none";
        }
        const option1 = document.getElementsByClassName("option1");
        for (let i = 0; i < option1.length; i++) {
          option1[i].style.display = "flex";
        }
      } else {
        const option1 = document.getElementsByClassName("option1");
        for (let i = 0; i < option1.length; i++) {
          option1[i].style.display = "hidden";
        }
        const option2 = document.getElementsByClassName("option2");
        for (let i = 0; i < option2.length; i++) {
          option2[i].style.display = "flex";
        }
      }
    }
  }
});
