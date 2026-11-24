<footer class="tu-footer">
    <div class="tu-container">
        <div class="tu-footer-grid">
            <div class="tu-footer-brand">
                <img src="{{ asset('front/assets/img/logo/logo-wc.png') }}" alt="{{ config('app.name') }}" style="height:34px">
                <p>Houses, land and architectural designs across Rwanda — listed by verified Terra agents.</p>
                <div class="tu-socials">
                    <a href="https://x.com/terraltdrd" target="_blank" rel="noopener" aria-label="X"><x-tu-icon name="twitter" size="16" /></a>
                    <a href="https://www.linkedin.com/in/terra-ltd-1842403b7" target="_blank" rel="noopener" aria-label="LinkedIn"><x-tu-icon name="linkedin" size="16" /></a>
                    <a href="https://www.instagram.com/terraltd.rd" target="_blank" rel="noopener" aria-label="Instagram"><x-tu-icon name="instagram" size="16" /></a>
                    <a href="https://www.youtube.com/channel/UC79ofkeQwIYyfynBYUr19GA" target="_blank" rel="noopener" aria-label="YouTube"><x-tu-icon name="youtube" size="16" /></a>
                </div>
            </div>

            <div>
                <h4>Marketplace</h4>
                <ul>
                    <li><a href="{{ route('front.buy.homes') }}">Houses for sale</a></li>
                    <li><a href="{{ route('front.buy.lands') }}">Land for sale</a></li>
                    <li><a href="{{ route('front.rent.homes') }}">Houses for rent</a></li>
                    <li><a href="{{ route('front.rent.apartments') }}">Apartments</a></li>
                    <li><a href="{{ route('front.properties.architecture') }}">Architectural designs</a></li>
                </ul>
            </div>

            <div>
                <h4>Agents</h4>
                <ul>
                    <li><a href="{{ route('front.agents') }}">Find an agent</a></li>
                    <li><a href="{{ route('front.agents.register') }}">Become an agent</a></li>
                    <li><a href="{{ route('login') }}">Agent sign in</a></li>
                </ul>
            </div>

            <div>
                <h4>Contact</h4>
                <div class="tu-footer-contact">
                    <a href="https://wa.me/{{ \App\Support\Listing::WHATSAPP }}" target="_blank" rel="noopener"><x-tu-icon name="whatsapp" /> +250 796 511 725</a>
                    <a href="mailto:terraltd.rd@gmail.com"><x-tu-icon name="mail" /> terraltd.rd@gmail.com</a>
                    <a href="https://maps.app.goo.gl/Ro2rLRPTCoy9Uejy9" target="_blank" rel="noopener"><x-tu-icon name="pin" /> Kigali, Rwanda</a>
                    <span><x-tu-icon name="clock" /> Mon – Fri · 9:00 – 18:00</span>
                </div>
            </div>
        </div>

        <div class="tu-footer-bottom">
            <span>&copy; {{ date('Y') }} {{ config('app.name', 'Terra Real Estate') }}. All rights reserved.</span>
            <span>Made in Kigali</span>
        </div>
    </div>
</footer>
