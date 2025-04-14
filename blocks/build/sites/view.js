import*as e from"@wordpress/interactivity";var t={d:(e,s)=>{for(var i in s)t.o(s,i)&&!t.o(e,i)&&Object.defineProperty(e,i,{enumerable:!0,get:s[i]})},o:(e,t)=>Object.prototype.hasOwnProperty.call(e,t)};const s=(d={getContext:()=>e.getContext,getElement:()=>e.getElement,store:()=>e.store,useEffect:()=>e.useEffect},n={},t.d(n,d),n),{state:i}=(0,s.store)("fuellogic-app",{state:{get hideSetupSite(){return i.sites.length>0?"hidden":"block"},get isSitesEmpty(){return i.sites.length<=0},get modalHeading(){switch(i.action){case"add-site":default:return"Add new site";case"edit-site":return"Edit site"}},get siteName(){return"add-site"==i.action?"":i.selectedSite.name},get siteAddress(){return"add-site"==i.action?"":i.selectedSite.address},get siteDeliverySchedule(){return"add-site"==i.action?"":i.selectedSite.delivery_schedule},get siteDeliveryNotes(){return"add-site"==i.action?"":i.selectedSite.delivery_notes}},actions:{*submitForm(e){e.preventDefault();const{ref:t}=(0,s.getElement)(),d=new FormData(t);d.append("action","add-site"==i.action?"add_site":"update_site"),d.append("nonce",i.nonce);const n=yield fetch(i.ajaxUrl,{method:"POST",body:d}).then((e=>e.json()));i.sites=n.data},*deleteSite(){if(confirm("Are you sure?")){const e=new FormData;e.append("action","delete_site"),e.append("nonce",i.nonce),e.append("id",i.selectedSiteId);const t=yield fetch(i.ajaxUrl,{method:"POST",body:e}).then((e=>e.json()));i.sites=t.data}},openSiteDetails:()=>{const e=(0,s.getContext)();console.log(e.site_details+"?site_id="+e.site_id),window.location.href=e.site_details+"?site_id="+e.site_id}},callbacks:{addNewSiteRedirect:()=>{const e=(0,s.getContext)();window.location.href=e.new_site},openModal:()=>{const{ref:e}=(0,s.getElement)();i.action=e.dataset.action,document.getElementById("myModal").style.display="block",console.log(i.selectedSite)},closeModal:()=>{document.getElementById("myModal").style.display="none"},selectSite:()=>{const{ref:e}=(0,s.getElement)();document.querySelectorAll("ul#sites-list li").forEach((e=>{e.classList.remove("selected")})),e.classList.add("selected");const t=i.sites.filter((t=>parseInt(t.id)===parseInt(e.id)));i.selectedSiteId=e.id,i.selectedSite=t.length?t[0]:""},sortSites:()=>{i.sorted?i.sites=i.sites.reverse():(i.sites=i.sites.sort(((e,t)=>e?.name.localeCompare(t?.name))),i.sorted=!0)},hideIfNotEmpty:()=>{(0,s.useEffect)((()=>{const{ref:e}=(0,s.getElement)();i.sites.length>0?e.style.display="none":e.style.display="block"}),[i.sites])},adjustSiteHeight:()=>{var e=document.getElementById("sites-list"),t=window.innerHeight-e.offsetTop;e.style.height=t+"px"}}});var d,n;