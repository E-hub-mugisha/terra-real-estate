<style>
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600;1,400&family=DM+Sans:opsz,wght@9..40,300;400;500&display=swap');

.partners-section {
    background: #F7F5F2;
    padding: 80px 0;
    overflow: hidden;
}

/* ── Header ── */
.partners-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    margin-bottom: 52px;
    flex-wrap: wrap;
    gap: 20px;
}
.partners-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: .7rem;
    font-weight: 500;
    letter-spacing: .14em;
    text-transform: uppercase;
    color: #D05208;
    margin-bottom: 10px;
    font-family: 'DM Sans', sans-serif;
}
.partners-eyebrow::before,
.partners-eyebrow::after {
    content: '';
    width: 20px; height: 1px;
    background: #D05208; opacity: .5;
}
.partners-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(1.6rem, 3vw, 2.4rem);
    font-weight: 500;
    line-height: 1.15;
    letter-spacing: -.02em;
    color: #1A1714;
    margin: 0;
}
.partners-title em {
    font-style: italic;
    color: #D05208;
}
.partners-desc {
    font-size: .85rem;
    color: #6B6560;
    line-height: 1.7;
    max-width: 380px;
    margin-top: 10px;
    font-family: 'DM Sans', sans-serif;
}
.partners-count {
    font-family: 'Cormorant Garamond', serif;
    font-size: 2.2rem;
    font-weight: 600;
    color: #1A1714;
    line-height: 1;
    flex-shrink: 0;
}
.partners-count span {
    display: block;
    font-family: 'DM Sans', sans-serif;
    font-size: .72rem;
    font-weight: 500;
    color: #9E9890;
    text-transform: uppercase;
    letter-spacing: .08em;
    margin-top: 3px;
}

/* ── Grid ── */
.partners-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 12px;
}

/* ── Card ── */
.partner-card {
    background: #FFFFFF;
    border: 1px solid rgba(0,0,0,.08);
    border-radius: 13px;
    padding: 22px 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    aspect-ratio: 3/2;
    transition: border-color .2s ease, box-shadow .2s ease, transform .2s ease;
    overflow: hidden;
}
.partner-card:hover {
    border-color: rgba(200,135,58,.3);
    box-shadow: 0 8px 24px rgba(0,0,0,.08);
    transform: translateY(-3px);
}
.partner-card img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    filter: grayscale(40%);
    opacity: .75;
    transition: filter .2s ease, opacity .2s ease;
}
.partner-card:hover img {
    filter: grayscale(0%);
    opacity: 1;
}

/* ── Divider line ── */
.partners-divider {
    height: 1px;
    background: rgba(0,0,0,.06);
    margin-bottom: 52px;
}

@media (max-width: 640px) {
    .partners-grid { grid-template-columns: repeat(2, 1fr); }
    .partners-header { flex-direction: column; align-items: flex-start; }
}
</style>

<section class="partners-section">
    <div class="container">

        <div class="partners-divider"></div>

        <div class="partners-header">
            <div>
                <div class="partners-eyebrow">Trusted By</div>
                <h2 class="partners-title">Our <span style="color: #D05208;">Partners</span></h2>
                <p class="partners-desc">
                    We collaborate with leading organizations across Rwanda to deliver trusted, innovative real estate solutions.
                </p>
            </div>
            <div class="partners-count">
                {{ $partners->count() }}+
                <span>Trusted Partners</span>
            </div>
        </div>

        <div class="partners-grid">
            @foreach($partners as $partner)
            <div class="partner-card">
                <img src="{{ asset('storage/'.$partner->image) }}"
                     alt="{{ $partner->name }}"
                     title="{{ $partner->name }}"
                     loading="lazy">
            </div>
            @endforeach
        </div>

    </div>
</section>