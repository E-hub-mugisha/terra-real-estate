{{-- Record a sale / rental → creates deal commissions for the listing's agent and partner --}}
<div class="tu-modal" id="dealModal" role="dialog" aria-modal="true" aria-labelledby="dealTitle">
    <div class="tu-modal-box">
        <div class="tu-modal-head">
            <div><h3 id="dealTitle" data-modal-title>Record a deal</h3><p>Marks the listing sold or rented and creates commissions for its agent and partner, waiting for your approval.</p></div>
            <button type="button" class="tu-btn tu-btn-icon tu-btn-ghost tu-btn-sm" data-modal-close aria-label="Close"><x-tu-icon name="x" /></button>
        </div>
        <form method="POST" action="#" class="tu-modal-body tu-stack" style="gap:14px">
            @csrf
            <div class="tp-seg" role="radiogroup" aria-label="Outcome">
                <input type="radio" id="dlSold" name="outcome" value="sold" checked><label for="dlSold">Sold</label>
                <input type="radio" id="dlRented" name="outcome" value="rented"><label for="dlRented">Rented</label>
            </div>
            <div class="tu-field"><label for="dlValue">Deal value (RWF)</label><input id="dlValue" class="tu-input" type="number" name="value" min="1" step="1" required></div>
            <p class="tu-hint" style="margin:0">Rates: agent {{ \App\Support\Settings::number('commission.agent_deal_pct') }}% · partner {{ \App\Support\Settings::number('commission.partner_deal_pct') }}% (change in Settings).</p>
            <button type="submit" class="tu-btn tu-btn-primary tu-btn-block">Record deal</button>
        </form>
    </div>
</div>
