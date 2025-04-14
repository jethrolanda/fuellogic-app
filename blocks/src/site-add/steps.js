export const stepOne = (formData) => {
  if (formData instanceof FormData === false) return false;

  const site_contact = formData.get("official_site_contact");

  let stepData = {};
  if (site_contact == "on") {
    stepData = {
      site_name: formData.get("site_name"),
      site_delivery_address: formData.get("site_delivery_address")
    };
  } else {
    stepData = {
      site_name: formData.get("site_name"),
      site_delivery_address: formData.get("site_delivery_address"),
      site_contact_first_name: formData.get("site_contact_first_name"),
      site_contact_last_name: formData.get("site_contact_last_name"),
      site_contact_phone: formData.get("site_contact_phone"),
      site_contact_email: formData.get("site_contact_email")
    };
  }

  let errors = [];
  Object.entries(stepData).forEach(([name, value]) => {
    if (value === "" || value === null) {
      errors.push(name);
    }
  });
  return errors.length === 0 ? true : false;
};

export const stepTwo = (formData) => {
  if (formData instanceof FormData === false) return false;

  const stepData = {
    gas_type: formData.getAll("gas_type")
  };

  // Disable qty
  ["diesel", "gas", "dyed_diesel", "def"].forEach((value) => {
    document
      .querySelector(`[name=${value}_qty]`)
      .setAttribute("readonly", "readonly");
  });

  console.log(stepData);
  let data = [];
  Object.entries(stepData.gas_type).forEach(([, value]) => {
    if (value) {
      document.querySelector(`[name=${value}_qty]`).removeAttribute("readonly");
    }

    if (value !== "" && value !== null && formData.get(value + "_qty") > 0) {
      data.push(value);
    }
  });

  return data.length > 0 ? true : false;
};

export const stepThree = (formData) => {
  if (formData instanceof FormData === false) return false;

  const stepData = {
    machines: formData.getAll("machines")
  };

  // Disable qty
  [
    "vehicles",
    "bulk_tank",
    "construction_equipment",
    "generators",
    "reefer",
    "other"
  ].forEach((value) => {
    document
      .querySelector(`[name=${value}_qty]`)
      .setAttribute("readonly", "readonly");
  });

  let data = [];
  Object.entries(stepData.machines).forEach(([, value]) => {
    if (value) {
      document.querySelector(`[name=${value}_qty]`).removeAttribute("readonly");
    }
    if (value !== "" && value !== null && formData.get(value + "_qty") > 0) {
      data.push(value);
    }
  });

  return data.length > 0 ? true : false;
};

export const stepFour = (formData) => {
  if (formData instanceof FormData === false) return false;

  const otd = formData.get("one_time_delivery");

  let stepData = {};

  if (otd === "on") {
    stepData = {
      delivery_date: formData.get("delivery_date")
      // delivery_window: formData.get("delivery_window")
    };
  } else {
    stepData = {
      day: formData.getAll("day"),
      delivery_start_date: formData.get("delivery_start_date")
      // delivery_window: formData.get("delivery_window")
    };
  }

  let errors = [];
  Object.entries(stepData).forEach(([name, value]) => {
    if (value === "" || value === null || value.length === 0) {
      errors.push(name);
    }
  });

  return errors.length === 0 ? true : false;
};

export const stepFive = (formData) => {
  if (formData instanceof FormData === false) return false;

  const stepData = {
    notes: formData.get("notes")
    // images: formData.getAll("images")
  };

  let errors = [];
  Object.entries(stepData).forEach(([name, value]) => {
    if (value === "" || value === null || value.length === 0) {
      errors.push(name);
    }
  });

  return errors.length === 0 ? true : false;
};

export const stepSix = (formData) => {
  if (formData instanceof FormData === false) return false;

  const pm = formData.get("payment_method");

  let stepData = {};
  if (pm === "payment_on_file") {
    stepData = {
      payment_method: formData.get("payment_method"),
      pre_authorization_email: formData.get("pre_authorization_email")
    };
  } else {
    stepData = {
      payment_method: formData.get("payment_method")
    };
  }

  let errors = [];
  Object.entries(stepData).forEach(([name, value]) => {
    if (value === "" || value === null || value.length === 0) {
      errors.push(name);
    }
  });

  return errors.length === 0 ? true : false;
};
