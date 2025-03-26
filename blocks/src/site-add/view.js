import {
  stepOne,
  stepTwo,
  stepThree,
  stepFour,
  stepFive,
  stepSix
} from "./steps";
/**
 * WordPress dependencies
 */
import { store, getContext, getElement } from "@wordpress/interactivity";

const { state, callbacks } = store("fuellogic-app", {
  state: {
    get siteName() {
      const context = getContext();

      if (context.formData == "") return "My Site";

      return context.formData.get("site_name") !== ""
        ? context.formData.get("site_name")
        : "My Site";
    },
    get next() {
      const context = getContext();
      return context.submitBtnStatus[context.currentStep];
    },
    get deliveryDate() {
      const context = getContext();
      const delivery_date = context.formData.get("delivery_date");
      return delivery_date !== "" ? delivery_date : " ";
    },
    get isIncomplete() {
      const context = getContext();
      if (context.submitBtnStatus.length === 0) return "block";
      return context.submitBtnStatus[context.currentStep] ? "none" : "block";
    },
    get isNextStep() {
      const context = getContext();
      if (context.submitBtnStatus.length === 0) return "none";
      return context.submitBtnStatus[context.currentStep] &&
        context.currentStep < 6
        ? "block"
        : "none";
    },
    get isSubmitOrder() {
      const context = getContext();
      if (context.submitBtnStatus.length === 0) return "none";
      return context.submitBtnStatus[context.currentStep] &&
        context.currentStep >= 6
        ? "block"
        : "none";
    }
  },
  actions: {
    submitForm: (e) => {
      e.preventDefault();
      alert("submitting");
      const { ref } = getElement();
      const context = getContext();
      const formData = new FormData(ref);

      formData.append("action", "create_site");
      formData.append("nonce", state.nonce);

      const data = fetch(state.ajaxUrl, {
        method: "POST",
        body: formData
      }).then((response) => response.json());

      context.signup_msg = data.message;
      context.status = data.status;
      if (data.status == "success") {
        // Signup redirect
        // window.location.href = state.signup_redirect;
      } else {
      }
    },
    submitButton: (e) => {
      const context = getContext();

      if (context.submitBtnStatus[context.currentStep]) {
        // If last step then submit the form
        if (parseInt(context.currentStep) < 6) {
          // e.preventDefault();
          // document.getElementById("site-form").submit();
          // return;
        }

        const active = document.getElementsByClassName("active");

        // Set current step
        context.currentStep = parseInt(context.currentStep) + 1;
        const nextStep = document.querySelectorAll(
          `li[data-step="${context.currentStep}"]`
        );

        // Transfer the active tab step
        active[0].classList.remove("active");

        if (nextStep.length > 0) nextStep[0].classList.add("active");

        // Show step content
        callbacks.init();
      }
    }
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

      // Show step content
      callbacks.init();
    },
    onFormUpdate: () => {
      const { ref } = getElement();
      const context = getContext();
      const formData = new FormData(ref);
      context.formData = formData;

      const otd = formData.get("one_time_delivery");

      // Show wrapper container
      if (otd !== null) {
        document.getElementsByClassName(
          "delivery-schedule-wrapper"
        )[0].style.display = "block";
      }

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

      callbacks.submitButtonStatus();
    },
    onSiteNameChange: () => {
      const { ref } = getElement();
      const context = getContext();
      context.siteName = ref.value;
    },
    submitButtonStatus: () => {
      // e.preventDefault();
      const context = getContext();
      switch (parseInt(context.currentStep)) {
        case 1:
          context.submitBtnStatus = {
            ...context.submitBtnStatus,
            [context.currentStep]: stepOne(context.formData)
          };

          break;
        case 2:
          context.submitBtnStatus = {
            ...context.submitBtnStatus,
            [context.currentStep]: stepTwo(context.formData)
          };
          break;
        case 3:
          context.submitBtnStatus = {
            ...context.submitBtnStatus,
            [context.currentStep]: stepThree(context.formData)
          };
          break;
        case 4:
          context.submitBtnStatus = {
            ...context.submitBtnStatus,
            [context.currentStep]: stepFour(context.formData)
          };
          break;
        case 5:
          context.submitBtnStatus = {
            ...context.submitBtnStatus,
            [context.currentStep]: stepFive(context.formData)
          };
          break;
        case 6:
          context.submitBtnStatus = {
            ...context.submitBtnStatus,
            [context.currentStep]: stepSix(context.formData)
          };
          break;
        default:
          break;
      }
    }
  }
});
