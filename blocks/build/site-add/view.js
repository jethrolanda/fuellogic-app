import*as t from"@wordpress/interactivity";var e={d:(t,n)=>{for(var a in n)e.o(n,a)&&!e.o(t,a)&&Object.defineProperty(t,a,{enumerable:!0,get:n[a]})},o:(t,e)=>Object.prototype.hasOwnProperty.call(t,e)};const n=t=>{if(t instanceof FormData==0)return!1;let e={};e="on"==t.get("official_site_contact")?{site_name:t.get("site_name"),site_delivery_address:t.get("site_delivery_address")}:{site_name:t.get("site_name"),site_delivery_address:t.get("site_delivery_address"),site_contact_first_name:t.get("site_contact_first_name"),site_contact_last_name:t.get("site_contact_last_name"),site_contact_phone:t.get("site_contact_phone"),site_contact_email:t.get("site_contact_email")};let n=[];return Object.entries(e).forEach((([t,e])=>{""!==e&&null!==e||n.push(t)})),0===n.length},a=t=>{if(t instanceof FormData==0)return!1;const e={gas_type:t.getAll("gas_type")};["diesel","gas","dyed_diesel","def"].forEach((t=>{document.querySelector(`[name=${t}_qty]`).setAttribute("readonly","readonly")})),console.log(e);let n=[];return Object.entries(e.gas_type).forEach((([,e])=>{e&&document.querySelector(`[name=${e}_qty]`).removeAttribute("readonly"),""!==e&&null!==e&&t.get(e+"_qty")>0&&n.push(e)})),n.length>0},s=t=>{if(t instanceof FormData==0)return!1;const e={machines:t.getAll("machines")};["vehicles","bulk_tank","construction_equipment","generators","reefer","other"].forEach((t=>{document.querySelector(`[name=${t}_qty]`).setAttribute("readonly","readonly")}));let n=[];return Object.entries(e.machines).forEach((([,e])=>{e&&document.querySelector(`[name=${e}_qty]`).removeAttribute("readonly"),""!==e&&null!==e&&t.get(e+"_qty")>0&&n.push(e)})),n.length>0},r=t=>{if(t instanceof FormData==0)return!1;let e={};e="on"===t.get("one_time_delivery")?{delivery_date:t.get("delivery_date")}:{day:t.getAll("day"),delivery_start_date:t.get("delivery_start_date")};let n=[];return Object.entries(e).forEach((([t,e])=>{""!==e&&null!==e&&0!==e.length||n.push(t)})),0===n.length},o=t=>{if(t instanceof FormData==0)return!1;const e={notes:t.get("notes")};let n=[];return Object.entries(e).forEach((([t,e])=>{""!==e&&null!==e&&0!==e.length||n.push(t)})),0===n.length},i=t=>{if(t instanceof FormData==0)return!1;let e={};e="payment_on_file"===t.get("payment_method")?{payment_method:t.get("payment_method"),pre_authorization_email:t.get("pre_authorization_email")}:{payment_method:t.get("payment_method")};let n=[];return Object.entries(e).forEach((([t,e])=>{""!==e&&null!==e&&0!==e.length||n.push(t)})),0===n.length},l=(d={getContext:()=>t.getContext,getElement:()=>t.getElement,store:()=>t.store},g={},e.d(g,d),g),{state:c,actions:u,callbacks:m}=(0,l.store)("fuellogic-app",{state:{get siteName(){const t=(0,l.getContext)();return""==t.formData?"My Site":""!==t.formData.get("site_name")?t.formData.get("site_name"):"My Site"},get next(){const t=(0,l.getContext)();return t.submitBtnStatus[t.currentStep]},get deliveryDate(){const t=(0,l.getContext)().formData.get("delivery_date");return""!==t?t:" "},get isIncomplete(){const t=(0,l.getContext)();return 0===t.submitBtnStatus.length?"block":t.submitBtnStatus[t.currentStep]?"none":"block"},get isNextStep(){const t=(0,l.getContext)();return 0===t.submitBtnStatus.length?"none":t.submitBtnStatus[t.currentStep]&&t.currentStep<6?"block":"none"},get isSubmitOrder(){const t=(0,l.getContext)();return 0===t.submitBtnStatus.length?"none":t.submitBtnStatus[t.currentStep]&&t.currentStep>=6?"block":"none"}},actions:{*submitForm(){const t=(0,l.getContext)(),e=new FormData;e.append("action","save_site_and_order"),e.append("data",JSON.stringify(Object.fromEntries(t.formData))),e.append("images",JSON.stringify(t.formData.getAll("images"))),e.append("gas_type",JSON.stringify(t.formData.getAll("gas_type"))),e.append("machines",JSON.stringify(t.formData.getAll("machines"))),e.append("nonce",c.nonce);const n=yield fetch(c.ajaxUrl,{method:"POST",body:e}).then((t=>t.json()));"success"==n.status&&(window.location.href=t.thank_you_page+"?order_id="+n?.order?.order_id)},submitButton:t=>{t.preventDefault();const e=(0,l.getContext)();if(e.submitBtnStatus[e.currentStep]){if(6===parseInt(e.currentStep))return void u.submitForm();const t=document.getElementsByClassName("active");e.currentStep=parseInt(e.currentStep)+1;const n=document.querySelectorAll(`li[data-step="${e.currentStep}"]`);t[0].classList.remove("active"),n.length>0&&n[0].classList.add("active"),m.init()}}},callbacks:{init:()=>{const t=(0,l.getContext)().currentStep,e=document.getElementsByClassName("step-content");for(let n of e)t==n.dataset.step?n.removeAttribute("hidden"):n.setAttribute("hidden","true")},navigate:()=>{const t=(0,l.getContext)(),{ref:e}=(0,l.getElement)(),n=document.getElementsByClassName("active"),a=e.dataset.step;0==t.site_id&&!1===e.classList.contains("done")||(t.currentStep=a,n[0].classList.remove("active"),e.classList.add("active"),m.init())},onFormUpdate:()=>{const{ref:t}=(0,l.getElement)(),e=(0,l.getContext)(),n=new FormData(t);e.formData=n;const a=n.get("payment_method"),s=document.getElementById("pre_authorization_email");if("payment_on_file"==a?s&&(s.style.display="flex"):s&&(s.style.display="none"),"on"===n.get("one_time_delivery")){const t=document.body.getElementsByClassName("option1");for(let e=0;e<t.length;e++)t[e].style.display="none";const e=document.body.getElementsByClassName("option2");for(let t=0;t<e.length;t++)e[t].style.display="flex"}else{const t=document.body.getElementsByClassName("option2");for(let e=0;e<t.length;e++)t[e].style.display="none";const e=document.body.getElementsByClassName("option1");for(let t=0;t<e.length;t++)e[t].style.display="flex"}m.submitButtonStatus(),m.doneSteps()},onSiteNameChange:()=>{const{ref:t}=(0,l.getElement)();(0,l.getContext)().siteName=t.value},submitButtonStatus:()=>{const t=(0,l.getContext)();switch(parseInt(t.currentStep)){case 1:t.submitBtnStatus={...t.submitBtnStatus,[t.currentStep]:n(t.formData)};break;case 2:t.submitBtnStatus={...t.submitBtnStatus,[t.currentStep]:a(t.formData)};break;case 3:t.submitBtnStatus={...t.submitBtnStatus,[t.currentStep]:s(t.formData)};break;case 4:t.submitBtnStatus={...t.submitBtnStatus,[t.currentStep]:r(t.formData)};break;case 5:t.submitBtnStatus={...t.submitBtnStatus,[t.currentStep]:o(t.formData)};break;case 6:t.submitBtnStatus={...t.submitBtnStatus,[t.currentStep]:i(t.formData)}}},toggleSiteContact:()=>{const{ref:t}=(0,l.getElement)(),e=(0,l.getContext)(),n=document.getElementById("site_contact_first_name"),a=document.getElementById("site_contact_last_name"),s=document.getElementById("site_contact_phone"),r=document.getElementById("site_contact_email");t.checked?(n.value=e.current_user.first_name,n.setAttribute("readonly","readonly"),a.value=e.current_user.last_name,a.setAttribute("readonly","readonly"),s.value=e.current_user.phone,s.setAttribute("readonly","readonly"),r.value=e.current_user.email,r.setAttribute("readonly","readonly")):(n.value="",a.value="",s.value="",r.value="",n.removeAttribute("readonly"),a.removeAttribute("readonly"),s.removeAttribute("readonly"),r.removeAttribute("readonly"));var o=new Event("change");document.getElementById("site-form").dispatchEvent(o)},doneSteps:()=>{const t=(0,l.getContext)(),e=document.getElementById("steps-nav").getElementsByTagName("li");if(0==t.site_id)for(let n of e)t.submitBtnStatus[n.dataset.step]?n.classList.add("done"):n.classList.remove("done")},adjustFormContentHeight:()=>{var t=document.getElementById("steps-container");t.style.height="auto";var e=window.innerHeight-t.offsetTop;t.style.height=e+"px"},setSiteDetails:()=>{const{ref:t}=(0,l.getElement)(),e=(0,l.getContext)();Object.entries(e.site_data).forEach((e=>{if(![":r3:","file"].includes(e[0])&&""!=e[1]){const n=t.querySelectorAll(`input[name="${e[0]}"]`);n.length>0&&(n[0].value=e[1]);const a=t.querySelectorAll(`textarea[name="${e[0]}"]`);a.length>0&&(a[0].value=e[1]);const s=t.querySelectorAll(`input[value="${e[1]}"]`);s.length>0&&s[0].setAttribute("checked","checked")}})),Object.entries(e.gas_type).forEach((e=>{const n=t.querySelectorAll(`input[value="${e[1]}"]`);n.length>0&&n[0].setAttribute("checked","checked")})),Object.entries(e.machines).forEach((e=>{const n=t.querySelectorAll(`input[value="${e[1]}"]`);console.log(n),n.length>0&&n[0].setAttribute("checked","checked")}));var n=new Event("change");document.getElementById("site-form").dispatchEvent(n)}}});var d,g;