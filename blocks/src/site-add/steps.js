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
    diesel: formData.get("diesel"),
    gas: formData.get("gas"),
    dyed_diesel: formData.get("dyed_diesel"),
    def: formData.get("def")
  };

  let data = [];
  Object.entries(stepData).forEach(([name, value]) => {
    if (value === "on") {
      document.querySelector(`[name=${name}_qty]`).removeAttribute("disabled");
    } else {
      document
        .querySelector(`[name=${name}_qty]`)
        .setAttribute("disabled", "disabled");
    }

    if (value !== "" && value !== null && formData.get(name + "_qty") > 0) {
      data.push(name);
    }
  });

  return data.length > 0 ? true : false;
};

export const stepThree = (formData) => {
  if (formData instanceof FormData === false) return false;

  const stepData = {
    vehicles: formData.get("vehicles"),
    bulk_tank: formData.get("bulk_tank"),
    construction_equipment: formData.get("construction_equipment"),
    generators: formData.get("generators"),
    reefer: formData.get("reefer"),
    other: formData.get("other")
  };

  let data = [];
  Object.entries(stepData).forEach(([name, value]) => {
    if (value === "on") {
      document.querySelector(`[name=${name}_qty]`).removeAttribute("disabled");
    } else {
      document
        .querySelector(`[name=${name}_qty]`)
        .setAttribute("disabled", "disabled");
    }
    if (value !== "" && value !== null && formData.get(name + "_qty") > 0) {
      data.push(name);
    }
  });

  return data.length > 0 ? true : false;
};

export const stepFour = (formData) => {
  if (formData instanceof FormData === false) return false;

  const otd = formData.get("one_time_delivery");

  let stepData = {};
  if (otd === "no") {
    stepData = {
      one_time_delivery: formData.get("one_time_delivery"),
      day: formData.getAll("day"),
      delivery_date: formData.get("delivery_date"),
      delivery_window: formData.get("delivery_window")
    };
  } else {
    stepData = {
      one_time_delivery: formData.get("one_time_delivery"),
      delivery_date: formData.get("delivery_date"),
      delivery_window: formData.get("delivery_window")
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
    notes: formData.get("notes"),
    images: formData.getAll("images")
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

  const stepData = {
    payment_method: formData.get("payment_method"),
    pre_authorization_email: formData.get("pre_authorization_email")
  };

  let errors = [];
  Object.entries(stepData).forEach(([name, value]) => {
    if (value === "" || value === null || value.length === 0) {
      errors.push(name);
    }
  });

  return errors.length === 0 ? true : false;
};
