import*as e from"@wordpress/interactivity";var t={d:(e,r)=>{for(var o in r)t.o(r,o)&&!t.o(e,o)&&Object.defineProperty(e,o,{enumerable:!0,get:r[o]})},o:(e,t)=>Object.prototype.hasOwnProperty.call(e,t)};const r=(n={getContext:()=>e.getContext,getElement:()=>e.getElement,store:()=>e.store},a={},t.d(a,n),a),{state:o,callbacks:s}=(0,r.store)("fuellogic-app",{state:{get isMsgEmpty(){return 0===(0,r.getContext)().login_msg.length}},actions:{*login(e){e.preventDefault();const t=(0,r.getContext)(),s=new FormData;s.append("action","fla_login"),s.append("_ajax_nonce",o.nonce),s.append("uname",t.uname),s.append("pword",t.pword),s.append("remember",t.remember),t.inWishlist=!0;const n=yield fetch(o.ajaxUrl,{method:"POST",body:s}).then((e=>e.json()));t.login_status=n.status,t.login_msg=n.message,"error"==n.status?("empty_username"===n.code&&document.querySelector('input[name="uname"]').classList.add("error"),"empty_password"===n.code&&document.querySelector('input[name="pword"]').classList.add("error"),document.querySelector(".login-message").classList.add("error")):(document.querySelector('input[name="uname"]').classList.remove("error"),document.querySelector('input[name="pword"]').classList.remove("error"),document.querySelector(".login-message").classList.add("success"))}},callbacks:{setUserName:()=>{const e=(0,r.getContext)(),t=(0,r.getElement)();e.uname=t.ref.value,0===e.uname.length?t.ref.classList.add("error"):t.ref.classList.remove("error")},setPassword:()=>{const e=(0,r.getContext)(),t=(0,r.getElement)();e.pword=t.ref.value,0===e.pword.length?t.ref.classList.add("error"):t.ref.classList.remove("error")},setRemember:()=>{const e=(0,r.getContext)(),t=(0,r.getElement)();e.remember=t.ref.checked},renderLoginMsg:()=>{const e=(0,r.getContext)();(0,r.getElement)().ref.innerHTML=e.login_msg}}});var n,a;