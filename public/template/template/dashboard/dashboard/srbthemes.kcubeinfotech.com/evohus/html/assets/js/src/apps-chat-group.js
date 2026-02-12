import"../../admin.bundle-CEbNEZ37.js";import{S as c}from"../../sweetalert2-CTD24S6B.js";/* empty css                               */import"../../main-O_SKZbQk.js";import"../../_commonjsHelpers-CqkleIqs.js";VirtualSelect.init({ele:"#addMemberSelect",options:[{label:"Auli Ahokas",value:"Auli Ahokas"},{label:"Sirpa Kolkka",value:"Sirpa Kolkka"},{label:"Leena Laine",value:"Leena Laine"},{label:"Risto Saraste",value:"Risto Saraste"},{label:"Mikko Virtanen",value:"Mikko Virtanen"},{label:"Tuula Nieminen",value:"Tuula Nieminen"},{label:"Rosa Lynch",value:"Rosa Lynch"},{label:"Meagan Snow",value:"Meagan Snow"},{label:"Jessica Perry",value:"Jessica Perry"},{label:"Julie Lawson",value:"Julie Lawson"},{label:"Fiona Smith",value:"Fiona Smith"},{label:"Linda Stucky",value:"Linda Stucky"}],search:!0,allowNewOption:!0,showValueAsTags:!0,multiple:!0});const o=[{id:1,name:"Shopify Developers",message:"Hello, How are you?",time:"11:48AM",img:"assets/images/brands/img-08.png",badge:2,active:!0},{id:2,name:"Social Medium Team",message:"Hello, How are you?",time:"08:14AM",img:"assets/images/brands/img-12.png",badge:2,active:!1},{id:3,name:"Deployment Disruptor",message:"Hello, How are you?",time:"04:00PM",img:"assets/images/brands/img-02.png",badge:null,active:!1},{id:4,name:"Full-Stack Crew",message:"Hello, How are you?",time:"05:14PM",img:"assets/images/brands/img-22.png",badge:null,active:!1},{id:5,name:"UX/UI Avengers",message:"Hello, How are you?",time:"11:57AM",img:"assets/images/brands/img-01.png",badge:null,active:!1}],l=document.getElementById("chatList");o.forEach(e=>{const t=e.badge?`<span class="badge bg-danger-subtle text-danger">${e.badge}</span>`:"",a=e.active?"active":"";l.innerHTML+=`
      <li id="chat-${e.id}">
        <a href="#!" class="chat-list-item ${a}">
          <div class="position-relative size-10 bg-light flex-shrink-0 rounded-circle p-2">
            <img src="${e.img}" alt="" class="img-fluid rounded-circle">
          </div>
          <div class="flex-grow-1 overflow-hidden">
            <h6 class="mb-0 text-truncate">${e.name}</h6>
            <p class="fs-12 text-muted text-truncate">${e.message}</p>
          </div>
          <div class="flex-shrink-0 text-end">
            <p class="mb-1 fs-12 text-muted">${e.time}</p>
            ${t}
          </div>
        </a>
      </li>
    `});const m=document.querySelectorAll(".chat-list-item");m.forEach(e=>{e.addEventListener("click",t=>{m.forEach(s=>s.classList.remove("active")),e.classList.add("active");const a=e.closest("li").id.split("-")[1];o.forEach(s=>{s.active=s.id==a})})});const v=document.getElementById("saveGroupBtn"),u=document.getElementById("locationInput");v.addEventListener("click",()=>{const e=u.value.trim();if(e!==""){const t={id:o.length+1,name:e,message:"Group created",time:new Date().toLocaleTimeString([],{hour:"2-digit",minute:"2-digit"}),img:"assets/images/brands/img-27.png",badge:null,active:!1};o.unshift(t);const a=`
        <li id="chat-${t.id}">
          <a href="#!" class="chat-list-item">
            <div class="position-relative size-10 bg-body-secondary flex-shrink-0 rounded-circle p-2">
              <img src="${t.img}" alt="" class="img-fluid rounded-circle">
            </div>
            <div class="flex-grow-1 overflow-hidden">
              <h6 class="mb-0">${t.name}</h6>
              <p class="fs-12 text-muted text-truncate">${t.message}</p>
            </div>
            <div class="flex-shrink-0 text-end">
              <p class="mb-1 fs-12 text-muted">${t.time}</p>
            </div>
          </a>
        </li>
      `;l.insertAdjacentHTML("afterbegin",a),u.value="",window.bootstrap.Modal.getInstance(document.querySelector(".modal"))}else alert("Please enter group name")});const g=document.getElementById("searchChat"),p=document.getElementById("noResult");g.addEventListener("keyup",()=>{const e=g.value.toLowerCase(),t=document.querySelectorAll("#chatList li");let a=!1;t.forEach(s=>{s.querySelector("h6").textContent.toLowerCase().includes(e)?(s.style.display="block",a=!0):s.style.display="none"}),a?p.classList.add("d-none"):p.classList.remove("d-none")});const f=document.querySelector(".avatar img"),y=document.querySelector(".avatar").nextElementSibling.querySelector("a"),b=document.querySelector(".text-center img"),w=document.querySelector(".text-center h6");l.addEventListener("click",e=>{const t=e.target.closest(".chat-list-item");if(!t)return;const a=t.querySelector("img").src,s=t.querySelector("h6").textContent;f.src=a,y.textContent=s,b.src=a,w.textContent=s});const i=[{id:1,name:"User 15",message:"Hey team, I hope everyone is doing well. Let's do a quick standup. What are everyone's updates for today?",time:"Today, 09:59 AM",avatar:"assets/images/avatar/user-15.png",position:"left"},{id:2,name:"You",message:"Morning! I’m working on the new theme design. Almost done with the homepage. I'll move on to the product pages next. Could use some feedback on the hero section if anyone has time.",time:"Today, 10:00 AM",avatar:"assets/images/avatar/user-17.png",position:"right"},{id:3,name:"User 11",message:"Hey all. I’m debugging an issue with the checkout process. There seems to be a problem with the payment gateway integration. I'll keep you posted.",time:"Today, 10:11 AM",avatar:"assets/images/avatar/user-11.png",position:"left"},{id:4,name:"User 19",message:"Hi team! I’m working on integrating the third-party review system. I’ve run into a small issue with the API limits, but I’m handling it. Should have it sorted by the end of the day.",time:"Today, 10:30 AM",avatar:"assets/images/avatar/user-19.png",position:"left"},{id:5,name:"User 4",message:"Hi team. I’m testing the recent updates on the staging server. Found a couple of minor bugs in the user registration flow. Jamie, I’ll share the details with you in a bit.",time:"Today, 10:30 AM",avatar:"assets/images/avatar/user-4.png",position:"left"},{id:6,name:"User 20",message:"Thanks, Sarah. Casey, I’ll ping you when I start on the product pages. Your mockups look great!",time:"Today, 10:30 AM",avatar:"assets/images/avatar/user-20.png",position:"left"},{id:7,name:"User 17",message:"Sure thing, Sarah. I might need a second pair of eyes on the checkout flow once you're done with the gateway integration.",time:"Today, 10:30 AM",avatar:"assets/images/avatar/user-17.png",position:"right"}],n=document.querySelector(".d-flex.flex-column.gap-5");document.querySelector(".form-control");const x=document.querySelector(".btn-active-primary");function r(){n.innerHTML="",i.forEach(e=>{let t=`
      <div class="d-flex align-items-end gap-2 ${e.position==="right"?"ms-auto":""} max-w-xl" data-id="${e.id}">
        ${e.position==="left"?`
          <div class="position-relative size-8 flex-shrink-0 avatar">
            <img src="${e.avatar}" alt="" class="img-fluid rounded-circle">
            <span class="status-indicator bg-success size-2-5"></span>
          </div>`:""}

        <div class="flex-grow-1">

          <div class="d-flex align-items-end gap-2 ${e.position==="right"?"justify-content-end":""}">
            <!-- RIGHT SIDE: Dropdown first -->
            ${e.position==="right"?`
              <div class="dropdown mb-7">
                <button class="btn btn-link text-muted p-0" type="button" aria-label="Dropdown" data-bs-toggle="dropdown" aria-expanded="true">
                  <i class="ri-more-2-fill"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                  <li>
                    <a href="#!" class="dropdown-item">
                      <i class="ri-reply-line me-1"></i>
                      <span>Reply</span>
                    </a>
                  </li>
                  <li class="delete-msg" data-id="${e.id}">
                    <a href="#!" class="dropdown-item">
                      <i class="ri-delete-bin-line me-1"></i>
                      <span>Delete</span>
                    </a>
                  </li>
                </ul>
              </div>`:""}
            <!-- Message bubble -->
            <div class="flex-grow-1">
              <div class="px-4 py-3 bg-light text-body ${e.position==="right"?"rounded-top-4 rounded-start-4":"rounded-top-4 rounded-end-4"}">
                ${e.message}
              </div>
              <p class="text-muted mt-2 fs-12 ${e.position==="right"?"text-end":""}">${e.time}</p>
            </div>

            <!-- LEFT SIDE: Dropdown after message -->
            ${e.position==="left"?`
              <div class="dropdown mb-7">
                <button class="btn btn-link text-muted p-0" type="button" aria-label="Dropdown" data-bs-toggle="dropdown" aria-expanded="true">
                  <i class="ri-more-2-fill"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                  <li>
                    <a href="#!" class="dropdown-item">
                      <i class="ri-reply-line me-1"></i>
                      <span>Reply</span>
                    </a>
                  </li>
                  <li class="delete-msg" data-id="${e.id}">
                    <a href="#!" class="dropdown-item">
                      <i class="ri-delete-bin-line me-1"></i>
                      <span>Delete</span>
                    </a>
                  </li>
                </ul>
              </div>`:""}
          </div>
        </div>

        ${e.position==="right"?`
          <div class="position-relative size-8 flex-shrink-0 avatar">
            <img src="${e.avatar}" alt="" class="img-fluid rounded-circle">
            <span class="status-indicator bg-success size-2-5"></span>
          </div>`:""}
      </div>
    `;n.innerHTML+=t}),document.querySelectorAll(".delete-msg").forEach(e=>{e.addEventListener("click",function(){const t=parseInt(this.dataset.id);S(t)})})}function S(e){i.splice(i.findIndex(t=>t.id===e),1),r()}function h(){let e=messageInput.value.trim();if(e!==""){let t={id:i.length+1,sender:"You",avatar:"assets/images/avatar/user-17.png",message:e,time:"Today, "+new Date().toLocaleTimeString([],{hour:"2-digit",minute:"2-digit"}),position:"right"};i.push(t),r(),d(),n.scrollTop=n.scrollHeight,messageInput.value="",messageInput.focus()}}x.onclick=h;let k=document.querySelector(".chat-messages");function d(){setTimeout(()=>{const e=k.lastElementChild;e&&e.scrollIntoView({behavior:"smooth",block:"end"})},200)}messageInput.addEventListener("keydown",function(e){e.key==="Enter"&&!e.shiftKey&&(h(),e.preventDefault())});document.addEventListener("click",function(e){const t=e.target.closest(".dropdown-item");t&&t.innerText.includes("Clear Chat")&&c.fire({title:"Are you sure?",text:"You want to clear all chat messages!",icon:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"Yes, Clear it!"}).then(a=>{a.isConfirmed&&(n.innerHTML="",i.splice(0,i.length),d(),c.fire({title:"Cleared!",text:"All chat messages have been cleared.",icon:"success",timer:1500,showConfirmButton:!1}))})});r();window.onload=function(){d()};
