<style>
    .t-footer {
        /* margin-left: 260px; */
        padding: 14px 28px;
        border-top: 1px solid rgba(25, 38, 93, 0.07);
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        font-family: 'DM Sans', sans-serif;
    }

    .t-footer-links {
        display: flex;
        align-items: center;
        gap: 6px;
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .t-footer-links li a {
        font-size: 12.5px;
        color: rgba(25, 38, 93, 0.45);
        text-decoration: none;
        padding: 4px 8px;
        border-radius: 6px;
        transition: background 0.14s, color 0.14s;
        font-weight: 400;
    }

    .t-footer-links li a:hover {
        background: rgba(25, 38, 93, 0.05);
        color: #19265d;
    }

    .t-footer-copy {
        font-size: 12.5px;
        color: rgba(25, 38, 93, 0.38);
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .t-footer-copy a {
        color: #D05208;
        text-decoration: none;
        font-weight: 500;
        transition: opacity 0.14s;
    }

    .t-footer-copy a:hover {
        opacity: 0.75;
    }

    .t-footer-dot {
        width: 3px;
        height: 3px;
        border-radius: 50%;
        background: rgba(25, 38, 93, 0.2);
        display: inline-block;
    }

    @media (max-width: 991px) {
        .t-footer {
            margin-left: 0;
            flex-direction: column;
            gap: 8px;
            padding: 14px 20px;
            text-align: center;
        }
    }

    @media (max-width: 576px) {
        .t-footer-links {
            display: none;
        }
    }
</style>

<footer class="t-footer">
    <ul class="t-footer-links">
        <li><a href="#!">About</a></li>
        <span class="t-footer-dot"></span>
        <li><a href="#!">Privacy Policy</a></li>
        <span class="t-footer-dot"></span>
        <li><a href="#!">Terms & Conditions</a></li>
    </ul>

    <div class="t-footer-copy">
        &copy; {{ date('Y') }} Crafted by
        <a href="#" onclick="document.getElementById('devModal').style.display='flex'; return false;">HOMIEZ</a>
    </div>


    <!-- Modal Overlay -->
    <div id="devModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
        <div style="background:#fff; border-radius:12px; padding:2rem; width:100%; max-width:420px; margin:1rem; position:relative;">

            <!-- Close button -->
            <button onclick="document.getElementById('devModal').style.display='none'"
                style="position:absolute; top:1rem; right:1rem; background:none; border:none; font-size:20px; cursor:pointer; color:#6b7280;">&#x2715;</button>

            <!-- Header -->
            <div style="display:flex; align-items:center; gap:12px; margin-bottom:1.5rem;">
                <div style="width:48px; height:48px; border-radius:50%; background:#e8f5ed; display:flex; align-items:center; justify-content:center; font-weight:600; font-size:16px; color:#1a6b3a;">ME</div>
                <div>
                    <p style="margin:0; font-weight:600; font-size:16px; color:#111827;">Mugisha Eric</p>
                    <p style="margin:0; font-size:13px; color:#6b7280;">Developer · terra.rw</p>
                </div>
            </div>

            <!-- Contact options -->
            <div style="display:flex; flex-direction:column; gap:10px;">

                <a href="tel:+250782390919"
                    style="display:flex; align-items:center; gap:12px; padding:12px 16px; border-radius:8px; border:1px solid #e5e7eb; text-decoration:none; color:#111827;">
                    <span style="width:36px; height:36px; border-radius:50%; background:#e8f5ed; display:flex; align-items:center; justify-content:center;">
                        <svg width="16" height="16" fill="none" stroke="#1a6b3a" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 11.5 19.79 19.79 0 01.0 2.18 2 2 0 012 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 14.92v2z" />
                        </svg>
                    </span>
                    <div>
                        <p style="margin:0; font-size:13px; color:#6b7280;">Call</p>
                        <p style="margin:0; font-size:14px; font-weight:500;">+250 782 390 919</p>
                    </div>
                </a>

                <a href="sms:+250782390919"
                    style="display:flex; align-items:center; gap:12px; padding:12px 16px; border-radius:8px; border:1px solid #e5e7eb; text-decoration:none; color:#111827;">
                    <span style="width:36px; height:36px; border-radius:50%; background:#dbeafe; display:flex; align-items:center; justify-content:center;">
                        <svg width="16" height="16" fill="none" stroke="#1d4ed8" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" />
                        </svg>
                    </span>
                    <div>
                        <p style="margin:0; font-size:13px; color:#6b7280;">Text / SMS</p>
                        <p style="margin:0; font-size:14px; font-weight:500;">+250 782 390 919</p>
                    </div>
                </a>

                <a href="https://wa.me/250782390919" target="_blank"
                    style="display:flex; align-items:center; gap:12px; padding:12px 16px; border-radius:8px; border:1px solid #e5e7eb; text-decoration:none; color:#111827;">
                    <span style="width:36px; height:36px; border-radius:50%; background:#e8f5ed; display:flex; align-items:center; justify-content:center;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#1a6b3a">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                        </svg>
                    </span>
                    <div>
                        <p style="margin:0; font-size:13px; color:#6b7280;">WhatsApp</p>
                        <p style="margin:0; font-size:14px; font-weight:500;">+250 782 390 919</p>
                    </div>
                </a>

                <a href="mailto:kericmugisha@gmail.com"
                    style="display:flex; align-items:center; gap:12px; padding:12px 16px; border-radius:8px; border:1px solid #e5e7eb; text-decoration:none; color:#111827;">
                    <span style="width:36px; height:36px; border-radius:50%; background:#fef3c7; display:flex; align-items:center; justify-content:center;">
                        <svg width="16" height="16" fill="none" stroke="#b45309" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                            <polyline points="22,6 12,13 2,6" />
                        </svg>
                    </span>
                    <div>
                        <p style="margin:0; font-size:13px; color:#6b7280;">Email</p>
                        <p style="margin:0; font-size:14px; font-weight:500;">kericmugisha@gmail.com</p>
                    </div>
                </a>

                <a href="https://www.linkedin.com/in/mugisha-eric-411547135/" target="_blank"
                    style="display:flex; align-items:center; gap:12px; padding:12px 16px; border-radius:8px; border:1px solid #e5e7eb; text-decoration:none; color:#111827;">
                    <span style="width:36px; height:36px; border-radius:50%; background:#dbeafe; display:flex; align-items:center; justify-content:center;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#1d4ed8">
                            <path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z" />
                            <circle cx="4" cy="4" r="2" />
                        </svg>
                    </span>
                    <div>
                        <p style="margin:0; font-size:13px; color:#6b7280;">LinkedIn</p>
                        <p style="margin:0; font-size:14px; font-weight:500;">Mugisha Eric</p>
                    </div>
                </a>

            </div>
        </div>
    </div>

    <!-- Close modal when clicking the backdrop -->
    <script>
        document.getElementById('devModal').addEventListener('click', function(e) {
            if (e.target === this) this.style.display = 'none';
        });
    </script>

</footer>