@extends('layouts.guest')
@section('title', 'Get In Touch')
@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&family=DM+Sans:opsz,wght@9..40,300;400;500&display=swap');

:root {
    --bg:       #F7F5F2;
    --surface:  #FFFFFF;
    --dark:     #19265d;
    --border:   rgba(0,0,0,.08);
    --border2:  rgba(0,0,0,.14);
    --gold:     #C8873A;
    --gold-lt:  #E5A55E;
    --gold-bg:  rgba(200,135,58,.07);
    --gold-bd:  rgba(200,135,58,.22);
    --text:     #19265d;
    --muted:    #6B6560;
    --dim:      #9E9890;
    --green:    #1E7A5A;
    --r:        12px;
    --t:        .22s cubic-bezier(.4,0,.2,1);
}
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body { background: var(--bg); color: var(--text); font-family: 'DM Sans', sans-serif; }
a { text-decoration: none; color: inherit; }

/* ══════════════════════════
   HERO BANNER
══════════════════════════ */
.ct-hero {
    background: var(--dark);
    position: relative; overflow: hidden;
    padding: 72px 0 64px;
    text-align: center;
}
.ct-hero::before {
    content: '';
    position: absolute; inset: 0;
    background:
        radial-gradient(ellipse 55% 50% at 50% 0%, rgba(200,135,58,.14) 0%, transparent 65%),
        radial-gradient(ellipse 35% 55% at 85% 80%, rgba(200,135,58,.06) 0%, transparent 55%);
    pointer-events: none;
}
.ct-hero::after {
    content: '';
    position: absolute; inset: 0;
    background-image:
        repeating-linear-gradient(0deg, transparent, transparent 39px, rgba(255,255,255,.02) 39px, rgba(255,255,255,.02) 40px),
        repeating-linear-gradient(90deg, transparent, transparent 39px, rgba(255,255,255,.02) 39px, rgba(255,255,255,.02) 40px);
    pointer-events: none;
}
.ct-hero .container { position: relative; z-index: 2; }
.ct-eyebrow {
    display: inline-flex; align-items: center; gap: 8px;
    font-size: .7rem; font-weight: 500; letter-spacing: .14em;
    text-transform: uppercase; color: var(--gold-lt); margin-bottom: 14px;
}
.ct-eyebrow::before, .ct-eyebrow::after { content: ''; width: 20px; height: 1px; background: var(--gold); opacity: .6; }
.ct-hero h1 {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(2rem, 5vw, 3.6rem);
    font-weight: 500; line-height: 1.1;
    letter-spacing: -.02em; color: #F0EDE8; margin-bottom: 14px;
}
.ct-hero h1 em { font-style: italic; color: var(--gold-lt); }
.ct-hero p {
    font-size: .88rem; color: rgba(240,237,232,.45);
    max-width: 480px; margin: 0 auto; line-height: 1.75;
}

/* ══════════════════════════
   MAIN SECTION
══════════════════════════ */
.ct-main { padding: 64px 0 80px; }

.ct-layout {
    display: grid;
    grid-template-columns: 1fr 480px;
    gap: 28px;
    align-items: start;
}
@media (max-width: 960px) { .ct-layout { grid-template-columns: 1fr; } }

/* ══════════════════════════
   LEFT — INFO CARDS
══════════════════════════ */
.ct-info { display: flex; flex-direction: column; gap: 16px; }

/* About text */
.ct-about {
    background: var(--surface); border: 1px solid var(--border);
    border-radius: var(--r); padding: 26px 26px 24px;
}
.ct-about-eyebrow {
    font-size: .68rem; font-weight: 600; letter-spacing: .1em;
    text-transform: uppercase; color: var(--gold); margin-bottom: 10px;
}
.ct-about h2 {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.55rem; font-weight: 500; letter-spacing: -.01em;
    color: var(--text); margin-bottom: 14px;
}
.ct-about h2 em { font-style: italic; color: var(--gold); }
.ct-about p { font-size: .84rem; color: var(--muted); line-height: 1.75; }

/* Contact method cards grid */
.ct-methods {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
}
@media (max-width: 540px) { .ct-methods { grid-template-columns: 1fr; } }

.ct-method {
    background: var(--surface); border: 1px solid var(--border);
    border-radius: var(--r); padding: 18px 18px 16px;
    transition: border-color var(--t), box-shadow var(--t), transform var(--t);
    display: block;
}
.ct-method:hover {
    border-color: var(--gold-bd);
    box-shadow: 0 6px 20px rgba(0,0,0,.07);
    transform: translateY(-2px);
}
.ct-method-icon {
    width: 38px; height: 38px; border-radius: 9px;
    background: var(--gold-bg); border: 1px solid var(--gold-bd);
    display: grid; place-items: center; margin-bottom: 12px;
}
.ct-method-icon svg { width: 17px; height: 17px; color: var(--gold); }
.ct-method-label {
    font-size: .68rem; font-weight: 600; letter-spacing: .08em;
    text-transform: uppercase; color: var(--dim); margin-bottom: 4px;
}
.ct-method-value {
    font-size: .88rem; font-weight: 500; color: var(--text);
    transition: color var(--t);
}
.ct-method:hover .ct-method-value { color: var(--gold); }
.ct-method-sub { font-size: .74rem; color: var(--muted); margin-top: 2px; }

/* Location card */
.ct-location {
    background: var(--surface); border: 1px solid var(--border);
    border-radius: var(--r); overflow: hidden;
}
.ct-location-map {
    width: 100%; height: 220px; display: block;
    border: none; filter: grayscale(20%) contrast(1.05);
    transition: filter var(--t);
}
.ct-location:hover .ct-location-map { filter: grayscale(0%) contrast(1); }
.ct-location-footer {
    padding: 16px 20px;
    display: flex; align-items: center; justify-content: space-between;
    border-top: 1px solid var(--border); flex-wrap: wrap; gap: 10px;
}
.ct-location-addr {
    display: flex; align-items: center; gap: 8px;
    font-size: .83rem; font-weight: 500; color: var(--text);
}
.ct-location-addr svg { width: 14px; height: 14px; color: var(--gold); flex-shrink: 0; }
.ct-map-link {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: .76rem; font-weight: 600; color: var(--gold);
    border-bottom: 1px solid var(--gold-bd);
    transition: gap var(--t), border-color var(--t);
}
.ct-map-link:hover { gap: 9px; border-color: var(--gold); }
.ct-map-link svg { width: 12px; height: 12px; }

/* Social row */
.ct-social {
    background: var(--surface); border: 1px solid var(--border);
    border-radius: var(--r); padding: 18px 20px;
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: 14px;
}
.ct-social-label { font-size: .75rem; font-weight: 600; color: var(--muted); text-transform: uppercase; letter-spacing: .07em; }
.ct-social-icons { display: flex; gap: 8px; }
.ct-soc {
    width: 36px; height: 36px; border-radius: 9px;
    border: 1px solid var(--border); background: var(--bg);
    display: grid; place-items: center;
    font-size: .78rem; color: var(--muted);
    transition: all var(--t);
}
.ct-soc:hover { background: var(--gold); border-color: var(--gold); color: #fff; }

/* Hours */
.ct-hours {
    background: var(--gold-bg); border: 1px solid var(--gold-bd);
    border-radius: var(--r); padding: 16px 20px;
    display: flex; align-items: center; gap: 12px;
}
.ct-hours svg { width: 18px; height: 18px; color: var(--gold); flex-shrink: 0; }
.ct-hours-text strong { font-size: .83rem; color: var(--text); display: block; }
.ct-hours-text span   { font-size: .76rem; color: var(--muted); }

/* ══════════════════════════
   RIGHT — CONTACT FORM
══════════════════════════ */
.ct-form-panel {
    background: var(--surface); border: 1px solid var(--border);
    border-radius: var(--r); overflow: hidden;
    position: sticky; top: 24px;
}
.ct-form-head {
    background: var(--dark); padding: 24px 26px;
    position: relative; overflow: hidden;
}
.ct-form-head::before {
    content: '';
    position: absolute; inset: 0;
    background: radial-gradient(ellipse 70% 80% at 15% 50%, rgba(200,135,58,.16) 0%, transparent 65%);
    pointer-events: none;
}
.ct-form-head-inner { position: relative; z-index: 1; }
.ct-form-head h3 {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.25rem; font-weight: 500; color: #F0EDE8; margin: 0;
}
.ct-form-head p { font-size: .75rem; color: rgba(240,237,232,.4); margin-top: 3px; }

.ct-form-body { padding: 22px 26px 26px; }

.ct-field { display: flex; flex-direction: column; gap: 5px; margin-bottom: 13px; }
.ct-field:last-of-type { margin-bottom: 0; }
.ct-field label {
    font-size: .7rem; font-weight: 600; text-transform: uppercase;
    letter-spacing: .06em; color: var(--muted);
}
.ct-field input,
.ct-field textarea,
.ct-field select {
    padding: 10px 13px;
    background: var(--bg); border: 1.5px solid var(--border);
    border-radius: 9px; font-size: .84rem;
    font-family: 'DM Sans', sans-serif; color: var(--text);
    transition: border-color var(--t), box-shadow var(--t), background var(--t);
    width: 100%;
}
.ct-field input::placeholder,
.ct-field textarea::placeholder { color: var(--dim); }
.ct-field input:focus,
.ct-field textarea:focus,
.ct-field select:focus {
    outline: none; border-color: var(--gold);
    box-shadow: 0 0 0 3px rgba(200,135,58,.1);
    background: var(--surface);
}
.ct-field textarea { resize: vertical; min-height: 110px; }

.ct-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
@media (max-width: 480px) { .ct-row { grid-template-columns: 1fr; } }

/* Submit button */
.ct-submit {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    width: 100%; padding: 13px 20px; margin-top: 16px;
    border-radius: 10px; background: var(--gold); border: none; color: #fff;
    font-size: .88rem; font-weight: 600;
    font-family: 'DM Sans', sans-serif; cursor: pointer;
    transition: background var(--t), transform var(--t);
}
.ct-submit:hover { background: #a06828; transform: translateY(-1px); }
.ct-submit svg { width: 16px; height: 16px; transition: transform var(--t); }
.ct-submit:hover svg { transform: translateX(3px); }

/* Success state */
.ct-success {
    display: none;
    text-align: center; padding: 32px 20px;
}
.ct-success-icon {
    width: 56px; height: 56px; border-radius: 50%;
    background: rgba(30,122,90,.1); border: 1px solid rgba(30,122,90,.2);
    display: grid; place-items: center; margin: 0 auto 14px;
}
.ct-success-icon svg { width: 24px; height: 24px; color: var(--green); }
.ct-success h4 { font-family: 'Cormorant Garamond', serif; font-size: 1.2rem; font-weight: 600; color: var(--text); margin-bottom: 6px; }
.ct-success p  { font-size: .82rem; color: var(--muted); }

/* ── Animations ── */
@keyframes fadeUp { from { opacity:0; transform:translateY(14px); } to { opacity:1; transform:translateY(0); } }
.fu  { animation: fadeUp .4s ease both; }
.fu2 { animation: fadeUp .4s ease .08s both; }
.fu3 { animation: fadeUp .4s ease .16s both; }
</style>

{{-- ── Hero ── --}}
<section class="ct-hero">
    <div class="container">
        <div class="ct-eyebrow">Get In Touch</div>
        <h1>Let's start the<br><em>conversation</em></h1>
        <p>Whether you're buying, selling, renting, or managing a property — our team is ready to help you every step of the way.</p>
    </div>
</section>

{{-- ── Main ── --}}
<section class="ct-main">
    <div class="container">
        <div class="ct-layout">

            {{-- ══ LEFT INFO ══ --}}
            <div class="ct-info fu">

                {{-- About text --}}
                <div class="ct-about">
                    <div class="ct-about-eyebrow">Terra Real Estate</div>
                    <h2>We're here to<br><em>help you</em></h2>
                    <p>{{ config('app.name') }} values communication and is here to assist with all your real estate needs. Our dedicated team provides expert guidance for buyers, sellers, landlords, and investors. Reach out — we'd love to help you reach your property goals.</p>
                </div>

                {{-- Contact methods --}}
                <div class="ct-methods">
                    <a href="tel:+250796511725" class="ct-method">
                        <div class="ct-method-icon">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1-9.4 0-17-7.6-17-17 0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.6.1.3 0 .7-.2 1L6.6 10.8z"/></svg>
                        </div>
                        <div class="ct-method-label">Phone</div>
                        <div class="ct-method-value">+250 796 511 725</div>
                        <div class="ct-method-sub">Mon – Fri, 9am – 6pm</div>
                    </a>

                    <a href="https://wa.me/250796511725" target="_blank" rel="noopener" class="ct-method">
                        <div class="ct-method-icon">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413z"/><path d="M11.999 2C6.477 2 2 6.477 2 12c0 1.89.52 3.659 1.428 5.18L2 22l4.975-1.395C8.43 21.51 10.17 22 11.999 22 17.522 22 22 17.523 22 12S17.522 2 11.999 2z"/></svg>
                        </div>
                        <div class="ct-method-label">WhatsApp</div>
                        <div class="ct-method-value">Chat with us</div>
                        <div class="ct-method-sub">Typically replies in minutes</div>
                    </a>

                    <a href="mailto:terraltd.rd@gmail.com" class="ct-method">
                        <div class="ct-method-icon">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                        </div>
                        <div class="ct-method-label">Email</div>
                        <div class="ct-method-value">terraltd.rd@gmail.com</div>
                        <div class="ct-method-sub">Response within 24 hours</div>
                    </a>

                    <div class="ct-method">
                        <div class="ct-method-icon">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                        </div>
                        <div class="ct-method-label">Office</div>
                        <div class="ct-method-value">Kigali, Rwanda</div>
                        <div class="ct-method-sub">Visit us in person</div>
                    </div>
                </div>

                {{-- Opening hours --}}
                <div class="ct-hours">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2zm.5 5v5.25l4.5 2.67-.75 1.23L11 13V7h1.5z"/></svg>
                    <div class="ct-hours-text">
                        <strong>Monday – Friday: 9:00 AM – 6:00 PM</strong>
                        <span>Saturday: 10:00 AM – 2:00 PM &nbsp;·&nbsp; Sunday: Closed</span>
                    </div>
                </div>

                {{-- Map --}}
                <div class="ct-location fu2">
                    <iframe
                        class="ct-location-map"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d326.36075734823254!2d30.063273152438825!3d-1.9348056650284369!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x19dca700357a3c8d%3A0xf28a78f475fe269e!2sTerra%20measures%20Ltd!5e1!3m2!1sen!2srw!4v1774257840816!5m2!1sen!2srw"
                        loading="lazy"
                        allowfullscreen>
                    </iframe>
                    <div class="ct-location-footer">
                        <div class="ct-location-addr">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg>
                            Kigali, Rwanda
                        </div>
                        <a href="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d326.36075734823254!2d30.063273152438825!3d-1.9348056650284369!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x19dca700357a3c8d%3A0xf28a78f475fe269e!2sTerra%20measures%20Ltd!5e1!3m2!1sen!2srw!4v1774257840816!5m2!1sen!2srw" target="_blank" rel="noopener" class="ct-map-link">
                            Open in Maps
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>

                {{-- Social --}}
                <div class="ct-social">
                    <span class="ct-social-label">Follow Terra</span>
                    <div class="ct-social-icons">
                        <a href="https://x.com/terraltdrd" class="ct-soc" target="_blank">
                        <i class="fa-brands fa-twitter"></i>
                    </a>
                    <a href="https://www.linkedin.com/in/terra-ltd-1842403b7" target="_blank" class="ct-soc">
                        <i class="fa-brands fa-linkedin-in"></i>
                    </a>
                    <a href="https://www.instagram.com/terraltd.rd" target="_blank" class="ct-soc">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a href="https://www.youtube.com/channel/UC79ofkeQwIYyfynBYUr19GA" target="_blank" class="ct-soc">
                        <i class="fa-brands fa-youtube"></i>
                    </a>
                    <a href="https://wa.me/250796511725" target="_blank" class="ct-soc">
                        <i class="fa-brands fa-whatsapp"></i>
                    </a>
                    </div>
                </div>

            </div>

            {{-- ══ RIGHT FORM ══ --}}
            <div class="ct-form-panel fu3">
                <div class="ct-form-head">
                    <div class="ct-form-head-inner">
                        <h3>Send us a message</h3>
                        <p>We'll get back to you within 24 hours</p>
                    </div>
                </div>

                <div class="ct-form-body">
                    @if($errors->any())
    <div style="background:#fee;border:1px solid red;padding:10px;border-radius:8px;margin-bottom:12px;font-size:.82rem;color:red;">
        <ul style="margin:0;padding-left:16px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('error'))
    <div style="background:#fee;border:1px solid red;padding:10px;border-radius:8px;margin-bottom:12px;font-size:.82rem;color:red;">
        {{ session('error') }}
    </div>
@endif
                    <form id="ct-form" action="{{ route('contact.send') }}" method="POST">
                        @csrf

                        <div class="ct-row">
                            <div class="ct-field">
                                <label>First Name</label>
                                <input type="text" name="first_name" placeholder="Amina" required>
                            </div>
                            <div class="ct-field">
                                <label>Last Name</label>
                                <input type="text" name="last_name" placeholder="Uwimana" required>
                            </div>
                        </div>

                        <div class="ct-field">
                            <label>Email Address</label>
                            <input type="email" name="email" placeholder="you@email.com" required>
                        </div>

                        <div class="ct-field">
                            <label>Phone Number</label>
                            <input type="tel" name="phone" placeholder="+250 7XX XXX XXX">
                        </div>

                        <div class="ct-field">
                            <label>Subject</label>
                            <select name="subject">
                                <option value="">Select a subject</option>
                                <option value="buying">Buying a property</option>
                                <option value="selling">Selling a property</option>
                                <option value="renting">Renting a property</option>
                                <option value="valuation">Property valuation</option>
                                <option value="other">Other enquiry</option>
                            </select>
                        </div>

                        <div class="ct-field">
                            <label>Message</label>
                            <textarea name="message" placeholder="Tell us how we can help you…" required></textarea>
                        </div>

                        <button type="submit" class="ct-submit">
                            Send Message
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/></svg>
                        </button>

                    </form>

                    {{-- Success state --}}
                    <div class="ct-success" id="ct-success">
                        <div class="ct-success-icon">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h4>Message sent!</h4>
                        <p>Thank you for reaching out. We'll be in touch within 24 hours.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<script>
    @if(session('success') === 'true')
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('ct-form').style.display    = 'none';
            document.getElementById('ct-success').style.display = 'block';
        });
    @endif

    @if(session('error'))
        document.addEventListener('DOMContentLoaded', function () {
            alert("{{ session('error') }}");
        });
    @endif
</script>

@endsection