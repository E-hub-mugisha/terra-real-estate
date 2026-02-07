import"../../admin.bundle-CEbNEZ37.js";import"../../main-O_SKZbQk.js";const k=document.querySelectorAll(".chat-list-item");let g=document.querySelector(".chat-messages");const C=c;let l="Dawn Teague";const y=document.querySelector("#messageForm"),p=y.querySelector('input[type="text"]'),M=y.querySelector(".btn-active-primary"),b=y.querySelector(".dropdown-menu"),I=document.getElementById("chatSearch"),q=document.querySelectorAll(".chat-list-item"),d={"Dawn Teague":{avatar:"assets/images/avatar/user-13.png",lastSeen:"2 hr",messages:[{sender:"Dawn Teague",avatar:"assets/images/avatar/user-13.png",time:"Today, 09:59 AM",content:"We need a new website that allows users to create accounts, browse products, and make purchases. Can you provide a rough timeline and cost estimate?",isMe:!1},{sender:"Me",avatar:"assets/images/avatar/user-17.png",time:"Today, 10:00 AM",content:"Sure, we can help with that. To provide an accurate estimate, we'll need more details on the features you want. Let's schedule a call this week to discuss the specifics, such as the types of products, payment methods, and any design preferences.",isMe:!0},{sender:"Me",avatar:"assets/images/avatar/user-17.png",time:"Today, 10:15 AM",content:`Got it. I'll investigate and update you shortly. <a href="#!" class="link-danger">#bug</a>`,isMe:!0},{sender:"Dawn Teague",avatar:"assets/images/avatar/user-13.png",time:"Today, 10:11 AM",content:'Hi <a href="#!" class="link-primary">@Shopia</a>, can you add the new search feature by Friday? Details are in the #features channel. Thanks! <a href="#!" class="link-primary">#task</a>',isMe:!1},{sender:"Me",avatar:"assets/images/avatar/user-17.png",time:"Today, 10:12 AM",content:'Sure, starting on it today. Will update you on the progress.<a href="#!" class="link-primary">#task154</a>',isMe:!0},{sender:"Dawn Teague",avatar:"assets/images/avatar/user-13.png",time:"Today, 02:39 PM",content:`Hi Shopia, there's a problem with the mobile view on the homepage. Images aren't scaling right. Can someone check? <a href="#!" class="link-danger">#bug</a>`,isMe:!1,images:["assets/images/gallery/img-01.jpg","assets/images/gallery/img-05.jpg"]}]},"David Johnson":{avatar:"assets/images/avatar/user-11.png",lastSeen:"1 hr",messages:[{sender:"David Johnson",avatar:"assets/images/avatar/user-11.png",time:"Today, 08:30 AM",content:"Here are some of very cute illustration.",isMe:!1},{sender:"Me",avatar:"assets/images/avatar/user-17.png",time:"Today, 08:45 AM",content:"Thanks for sharing! These look great. Do we have permission to use them in our project?",isMe:!0},{sender:"David Johnson",avatar:"assets/images/avatar/user-11.png",time:"Today, 09:00 AM",content:"Absolutely, feel free to use them. I'll send you the high-res versions soon.",isMe:!1}]},"Andrew Gilbert":{avatar:"assets/images/avatar/user-18.png",lastSeen:"3 hr",messages:[{sender:"Andrew Gilbert",avatar:"assets/images/avatar/user-18.png",time:"Yesterday, 03:15 PM",content:"Use tools like Trello, Asana, or Jira for task management and progress tracking.",isMe:!1},{sender:"Me",avatar:"assets/images/avatar/user-17.png",time:"Yesterday, 03:30 PM",content:"Thanks for the suggestion! I'll look into them.",isMe:!0},{sender:"Andrew Gilbert",avatar:"assets/images/avatar/user-18.png",time:"Yesterday, 04:00 PM",content:"Let me know if you need any help setting them up.",isMe:!1}]},"Tyron Derby":{avatar:"assets/images/avatar/user-20.png",lastSeen:"30 min",messages:[{sender:"Tyron Derby",avatar:"assets/images/avatar/user-20.png",time:"Yesterday, 04:30 PM",content:"Regularly review and improve communication practices based on team feedback and project needs.",isMe:!1},{sender:"Me",avatar:"assets/images/avatar/user-17.png",time:"Yesterday, 04:45 PM",content:"That's a great point. I'll make sure to gather feedback from the team.",isMe:!0},{sender:"Tyron Derby",avatar:"assets/images/avatar/user-20.png",time:"Yesterday, 05:00 PM",content:"Sounds good. Let me know if you need any templates or examples for feedback sessions.",isMe:!1}]},"Susan Liles":{avatar:"",initials:"SL",lastSeen:"45 min",messages:[{sender:"Susan Liles",avatar:"",initials:"SL",time:"Yesterday, 05:15 PM",content:"Schedule regular check-ins to address any roadblocks and keep everyone aligned.",isMe:!1},{sender:"Me",avatar:"assets/images/avatar/user-17.png",time:"Yesterday, 05:30 PM",content:"I'll set that up for next week.",isMe:!0},{sender:"Susan Liles",avatar:"",initials:"SL",time:"Yesterday, 06:00 PM",content:"Great! Let me know if you need any help organizing the meeting.",isMe:!1}]},"Josh Doyle":{avatar:"",initials:"JD",lastSeen:"15 min",messages:[{sender:"Josh Doyle",avatar:"",initials:"JD",time:"Yesterday, 06:00 PM",content:"No further questions.",isMe:!1},{sender:"Me",avatar:"assets/images/avatar/user-17.png",time:"Yesterday, 06:30 PM",content:"Alright, feel free to reach out if you think of anything else.",isMe:!0},{sender:"Josh Doyle",avatar:"",initials:"JD",time:"Yesterday, 07:00 PM",content:"Will do, thanks!",isMe:!1}]},"Nicholas Hope":{avatar:"assets/images/avatar/user-3.png",lastSeen:"1 hr",messages:[{sender:"Nicholas Hope",avatar:"assets/images/avatar/user-3.png",time:"Today, 11:30 AM",content:"Sure, I can help with that. Let's have a quick call after this meeting to debug the issue.",isMe:!1},{sender:"Me",avatar:"assets/images/avatar/user-17.png",time:"Today, 12:00 PM",content:"Thanks, I'll be ready for the call.",isMe:!0},{sender:"Nicholas Hope",avatar:"assets/images/avatar/user-3.png",time:"Today, 12:30 PM",content:"Let's get started then. I'm available now.",isMe:!1}]},"Louise Bryan":{avatar:"",initials:"LB",lastSeen:"2 hr",messages:[{sender:"Louise Bryan",avatar:"",initials:"LB",time:"Today, 12:15 PM",content:"I'll share the meeting minutes and action items shortly.",isMe:!1},{sender:"Me",avatar:"assets/images/avatar/user-17.png",time:"Today, 12:45 PM",content:"Thanks! I'll review them once you share.",isMe:!0},{sender:"Louise Bryan",avatar:"",initials:"LB",time:"Today, 01:00 PM",content:"I've sent them over, let me know if you have any questions.",isMe:!1}]},"Sirkka Hakola":{avatar:"assets/images/avatar/user-6.png",lastSeen:"3 hr",messages:[{sender:"Sirkka Hakola",avatar:"assets/images/avatar/user-6.png",time:"Today, 01:00 PM",content:"Let's reconvene next week for our regular check-in. Have a productive week!",isMe:!1},{sender:"Me",avatar:"assets/images/avatar/user-17.png",time:"Today, 01:30 PM",content:"Thanks, have a great week too!",isMe:!0},{sender:"Sirkka Hakola",avatar:"assets/images/avatar/user-6.png",time:"Today, 02:00 PM",content:"Looking forward to our next meeting. Talk soon!",isMe:!1}]}};function c(e){k.forEach(a=>{a.querySelector("h6").textContent===e?a.classList.add("active"):a.classList.remove("active")});const t=d[e]||d["Dawn Teague"],n=document.querySelector(".chat-toolbar"),s=n.querySelector("img");if(t.avatar){s.src=t.avatar,s.style.display="block";const a=n.querySelector(".initials");a&&(a.style.display="none")}else if(t.initials){s.style.display="none";const a=n.querySelector(".initials");if(a)a.textContent=t.initials,a.style.display="block";else{const u=document.createElement("span");u.className="initials fw-semibold",u.textContent=t.initials,s.parentNode.appendChild(u)}}n.querySelector("h6 a").textContent=e,n.querySelector("p").textContent=`Last seen ${t.lastSeen}`;const i=document.querySelector("#chat-messages");i.innerHTML="",t.messages.forEach((a,u)=>{let h="";const m=`msg-${u}`;if(a.isMe)h=`
                <div  id="${m}" class="d-flex align-items-end gap-2 ms-auto max-w-xl">
                  <div class="flex-grow-1">
                    <div class="d-flex align-items-end gap-2">
                      <div class="dropdown mb-7">
                        <button class="btn btn-link text-muted p-0" type="button" data-bs-toggle="dropdown" aria-expanded="true" title="dropdown-button">
                          <i class="ri-more-2-fill text-muted"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                          <li>
                            <a href="#!" class="dropdown-item">
                              <i class="ri-reply-line me-1"></i>
                              <span>Reply</span>
                            </a>
                          </li>
                          <li>
                            <a href="#!" class="dropdown-item delete-message" data-id="${m}">
                              <i class="ri-delete-bin-line me-1"></i>
                              <span>Delete</span>
                            </a>
                          </li>
                        </ul>
                      </div>
                      <div class="flex-grow-1">
                      <div class="px-4 py-3 bg-light-subtle text-body rounded-top-4 rounded-start-4">${a.content}</div>
                      <p class="text-muted mt-2 fs-12 text-end">${a.time}<i class="ri-check-double-fill text-success fs-17 ms-1"></i></p>
                      </div>
                    </div>
                  </div>
                  <div class="position-relative size-8 flex-shrink-0 d-flex justify-content-center align-items-center">
                    <img src="${a.avatar}" alt="" class="img-fluid rounded-circle">
                    <span class="status-indicator position-absolute bottom-0 end-0 bg-success border border-2 border-light-subtle rounded-circle size-2-5"></span>
                  </div>
                </div>
              `;else{let v="";a.images&&a.images.length>0&&(v=`
                  <div class="row g-2">
                    ${a.images.map((T,w)=>`
                      <div class="col-3">
                        <a href="#!" title="Gallery Image ${w+1}">
                          <img src="${T}" alt="Image ${w+1}" class="img-fluid rounded">
                        </a>
                      </div>
                    `).join("")}
                    ${a.images.length>2?`
                      <div class="col-3">
                        <a href="#!" title="Gallery Image 3" class="p-3 bg-light-subtle d-flex align-items-center justify-content-center link-body-emphasis text-body rounded h-100">
                          <h6 class="mb-0">${a.images.length-2}+</h6>
                        </a>
                      </div>
                    `:""}
                  </div>
                `);let f="";a.avatar?f=`<img src="${a.avatar}" alt="" class="img-fluid rounded-circle">`:a.initials&&(f=`<span class="fw-semibold">${a.initials}</span>`),h=`
                <div  id="${m}"class="d-flex align-items-end gap-2 max-w-xl">
                  <div class="position-relative size-8 flex-shrink-0 bg-light rounded-circle d-flex justify-content-center align-items-center">
                    ${f}
                    <span class="status-indicator position-absolute bottom-0 end-0 bg-success border border-2 border-light-subtle rounded-circle size-2-5"></span>
                  </div>
                  <div class="flex-grow-1">
                    ${v}
                    <div class="d-flex align-items-end gap-2 ${v?"mt-3":""}">
                      <div class="flex-grow-1">
                      <div class="px-4 py-3 bg-light-subtle text-body rounded-top-4 rounded-end-4">
                      ${a.content}
                      </div>
                      <p class="text-muted mt-2 fs-12">${a.time}</p>
                      </div>
                      <div class="dropdown mb-7">
                        <button class="btn btn-link text-muted p-0" type="button" data-bs-toggle="dropdown" aria-expanded="true" title="dropdown-button">
                          <i class="ri-more-2-fill text-muted"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                          <li>
                            <a href="#!" class="dropdown-item">
                              <i class="ri-reply-line me-1"></i>
                              <span>Reply</span>
                            </a>
                          </li>
                          <li>
                            <a href="#!" class="dropdown-item delete-message" data-id="${m}">
                                <i class="ri-delete-bin-line me-1"></i>
                                <span>Delete</span>
                            </a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              `}i.innerHTML+=h});const o=document.querySelector(".chat-height");o.scrollTop=o.scrollHeight;const r=document.querySelector(".chat-list-item.active .badge");r&&(r.style.display="none"),l=e,i.querySelectorAll(".delete-message").forEach(a=>{a.addEventListener("click",function(u){u.preventDefault();const h=this.getAttribute("data-id"),m=parseInt(h.split("-")[1]);d[l]&&d[l].messages&&m>=0&&d[l].messages.splice(m,1),c(l)})})}k.forEach(e=>{e.addEventListener("click",function(t){t.preventDefault();const n=this.querySelector("h6").textContent;c(n)})});c(l);function x(){const e=p.value.trim();if(e){const t={sender:"Me",avatar:"assets/images/avatar/user-17.png",time:E(),content:e,isMe:!0};d[l].messages.push(t),c(l),L(),p.value=""}}function L(){setTimeout(()=>{g&&g.lastElementChild?g.lastElementChild.scrollIntoView({behavior:"smooth",block:"end"}):(g=document.querySelector("#chat-messages"),g&&g.lastElementChild&&g.lastElementChild.scrollIntoView({behavior:"smooth",block:"end"}))},200)}M&&M.addEventListener("click",function(e){e.preventDefault(),x()});p&&p.addEventListener("keypress",function(e){e.key==="Enter"&&(e.preventDefault(),x())});if(b){const e=b.querySelector("a:first-child");e&&e.addEventListener("click",function(t){t.preventDefault(),d[l].messages=[],c(l)})}function E(){const e=new Date,t=e.getHours(),n=e.getMinutes().toString().padStart(2,"0"),s=t>=12?"PM":"AM";return`Today, ${t%12||12}:${n} ${s}`}document.getElementById("callModal").addEventListener("show.bs.modal",function(e){const t=d[l]||d["Dawn Teague"],n=this.querySelector("#callAvatar"),s=n.querySelector("img"),i=this.querySelector(".modal-body h6"),o=n.querySelector(".initials");if(o&&o.remove(),t.avatar&&t.avatar!=="")s.src=t.avatar,s.style.display="block";else{s.style.display="none";const r=document.createElement("span");r.className="initials fw-semibold d-flex justify-content-center align-items-center size-10 rounded-circle bg-light-subtle",r.textContent=t.initials||"",r.style.display="flex",n.appendChild(r)}i.textContent=l});c=function(e){C(e),l=e};function D(e,t){if(d[e]){c(e);const n=document.getElementById("addNewChatModals"),s=window.bootstrap.Modal.getInstance(n);return s&&s.hide(),!0}else{if(d[e]={avatar:t||"",lastSeen:"Now",messages:[]},!t){const r=e.split(" ");let a="";r.length>=2?a=r[0].charAt(0)+r[1].charAt(0):a=r[0].charAt(0),d[e].initials=a}const n=document.querySelector("#chatList");if(!n){console.error("Chat list element not found");return}const s=document.createElement("li");s.id="chat-list-item",t&&(s.innerHTML=`
          <a href="#!" class="chat-list-item">
            <div class="position-relative size-10 bg-light flex-shrink-0 rounded-circle avatar">
              <img src="${t}" alt="" class="img-fluid rounded-circle">
              <span class="status-indicator bg-success rounded-circle size-2-5"></span>
            </div>
            <div class="flex-grow-1 overflow-hidden">
              <h6 class="mb-0 fw-bold">${e}</h6>
              <p class="fs-12 text-muted text-truncate">Start a conversation</p>
            </div>
            <div class="fs-11 text-body-secondary">Now</div>
            <span class="badge bg-danger rounded-circle position-absolute top-0 end-0 d-none">0</span>
          </a>
        `),s.addEventListener("click",function(r){r.preventDefault(),c(e)}),n.appendChild(s);const i=document.getElementById("addNewChatModals"),o=window.bootstrap.Modal.getInstance(i);return o&&o.hide(),c(e),!0}}document.querySelectorAll(".toggle-mic").forEach(e=>{e.addEventListener("click",()=>{const t=e.querySelector(".mic-off-icon"),n=e.querySelector(".mic-on-icon");t.classList.toggle("d-none"),n.classList.toggle("d-none")})});document.addEventListener("DOMContentLoaded",function(){const e=document.getElementById("addNewChatModals");e&&e.querySelectorAll(".btn.btn-xs.btn-light").forEach(s=>{s.addEventListener("click",function(i){i.preventDefault();const o=this.closest("li");if(!o)return;const r=o.querySelector("h6").textContent,a=o.querySelector("img"),u=a?a.getAttribute("src"):"";D(r,u)||console.error("Failed to add new chat user")})});const t=document.querySelector('#addNewChatModals input[type="text"]');t&&t.addEventListener("input",function(){const n=this.value.toLowerCase();document.querySelectorAll("#addNewChatModals li").forEach(i=>{i.querySelector("h6").textContent.toLowerCase().includes(n)?i.style.display="":i.style.display="none"})})});I.addEventListener("input",function(){const e=this.value.toLowerCase(),t=document.getElementById("noResult");let n=!1;q.forEach(s=>{const i=s.querySelector("h6").textContent.toLowerCase(),o=s.querySelector("p").textContent.toLowerCase();i.includes(e)||o.includes(e)?(s.closest("li").style.display="",n=!0):s.closest("li").style.display="none"}),!n&&e!==""?t.classList.remove("d-none"):t.classList.add("d-none")});const S=document.querySelector('#addNewChatModals input[type="text"]');S&&S.addEventListener("input",function(){const e=this.value.toLowerCase(),t=document.querySelectorAll("#addNewChatModals li");let n=!1;t.forEach(i=>{i.querySelector("h6").textContent.toLowerCase().includes(e)?(i.style.display="",n=!0):i.style.display="none"});const s=document.querySelector("#addNewChatModals .no-result");s&&(!n&&e!==""?s.classList.remove("d-none"):s.classList.add("d-none"))});c(l);window.onload=function(){L()};
