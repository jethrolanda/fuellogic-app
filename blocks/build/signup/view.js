import*as e from"@wordpress/interactivity";var t={d:(e,s)=>{for(var n in s)t.o(s,n)&&!t.o(e,n)&&Object.defineProperty(e,n,{enumerable:!0,get:s[n]})},o:(e,t)=>Object.prototype.hasOwnProperty.call(e,t)};const s=(r={getContext:()=>e.getContext,getElement:()=>e.getElement,store:()=>e.store},o={},t.d(o,r),o),{state:n}=(0,s.store)("fuellogic-app",{state:{get isError(){return"error"===(0,s.getContext)().status},get isSuccess(){return"success"===(0,s.getContext)().status},get hasMessage(){return""!==(0,s.getContext)().signup_msg}},actions:{*submitForm(e){e.preventDefault();const{ref:t}=(0,s.getElement)(),r=(0,s.getContext)(),o=new FormData(t);o.append("action","fla_signup"),o.append("nonce",n.nonce);const a=yield fetch(n.ajaxUrl,{method:"POST",body:o}).then((e=>e.json()));r.signup_msg=a.message,r.status=a.status,"success"==a.status&&(window.location.href=n.signup_redirect)}},callbacks:{renderSignupMsg:()=>{const e=(0,s.getContext)();(0,s.getElement)().ref.innerHTML=e.signup_msg}}});var r,o;