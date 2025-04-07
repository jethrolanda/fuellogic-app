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

const { state, actions, callbacks } = store("fuellogic-app", {
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
    *submitForm() {
      const context = getContext();
      const formData = new FormData();

      formData.append("action", "save_site_and_order");
      formData.append(
        "data",
        JSON.stringify(Object.fromEntries(context.formData))
      );
      formData.append(
        "images",
        JSON.stringify(context.formData.getAll("images"))
      );
      formData.append(
        "gas_type",
        JSON.stringify(context.formData.getAll("gas_type"))
      );
      formData.append(
        "machines",
        JSON.stringify(context.formData.getAll("machines"))
      );
      formData.append("nonce", state.nonce);

      const data = yield fetch(state.ajaxUrl, {
        method: "POST",
        body: formData
      }).then((response) => response.json());

      if (data.status == "success") {
        // Thank you page redirect
        window.location.href =
          context.thank_you_page + "?order_id=" + data?.order?.order_id;
      }
    },
    submitButton: (e) => {
      e.preventDefault();
      const context = getContext();

      if (context.submitBtnStatus[context.currentStep]) {
        // If last step then submit the form
        if (parseInt(context.currentStep) === 6) {
          // document.getElementById("site-form").submit();
          actions.submitForm();
          return;
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
      const { ref } = getElement();
      const active = document.getElementsByClassName("active");
      const step = ref.dataset.step;

      // Only navigate when the step is done
      if (ref.classList.contains("done") === false) {
        return;
      }

      // Set current step
      context.currentStep = step;

      // Transfer the active tab step
      active[0].classList.remove("active");
      ref.classList.add("active");

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

      callbacks.doneSteps();
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
    },
    toggleSiteContact: () => {
      const { ref } = getElement();
      const context = getContext();
      const fname = document.getElementById("site_contact_first_name");
      const lname = document.getElementById("site_contact_last_name");
      const phone = document.getElementById("site_contact_phone");
      const email = document.getElementById("site_contact_email");
      if (ref.checked) {
        fname.value = context.current_user.first_name;
        fname.setAttribute("readonly", "readonly");
        lname.value = context.current_user.last_name;
        lname.setAttribute("readonly", "readonly");
        phone.value = context.current_user.phone;
        phone.setAttribute("readonly", "readonly");
        email.value = context.current_user.email;
        email.setAttribute("readonly", "readonly");
      } else {
        fname.value = "";
        lname.value = "";
        phone.value = "";
        email.value = "";
        fname.removeAttribute("readonly");
        lname.removeAttribute("readonly");
        phone.removeAttribute("readonly");
        email.removeAttribute("readonly");
      }
      // Trigger form update
      var event = new Event("change");
      document.getElementById("site-form").dispatchEvent(event);
    },
    doneSteps: () => {
      const context = getContext();

      const steps = document
        .getElementById("steps-nav")
        .getElementsByTagName("li");

      for (let step of steps) {
        if (context.submitBtnStatus[step.dataset.step]) {
          step.classList.add("done");
        } else {
          step.classList.remove("done");
        }
      }
    }
  }
});
