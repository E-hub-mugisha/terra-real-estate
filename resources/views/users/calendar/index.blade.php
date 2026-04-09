@extends('layouts.users')

@section('title', 'Calendar')

@section('content')

{{-- FullCalendar v6 --}}
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

<style>
    /* ── Page Layout ── */
    .cal-page {
        padding: 2rem;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* ── Header ── */
    .cal-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 1.5rem;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .cal-header__title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 2rem;
        font-weight: 600;
        color: #19265d;
        margin: 0;
    }

    .cal-header__sub {
        font-size: .875rem;
        color: #9ca3af;
        margin: .2rem 0 0;
    }

    .cal-header__actions {
        display: flex;
        gap: .75rem;
        align-items: center;
    }

    /* ── Buttons ── */
    .btn {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        font-size: .875rem;
        font-weight: 500;
        padding: .5rem 1.25rem;
        border-radius: 8px;
        cursor: pointer;
        border: none;
        text-decoration: none;
        transition: all .2s;
        white-space: nowrap;
    }

    .btn svg {
        width: 15px;
        height: 15px;
    }

    .btn--primary {
        background: #19265d;
        color: #fff;
    }

    .btn--primary:hover {
        background: #C8873A;
    }

    .btn--outline {
        background: transparent;
        color: #19265d;
        border: 1.5px solid #19265d;
    }

    .btn--outline:hover {
        background: #19265d;
        color: #fff;
    }

    .btn--ghost {
        background: transparent;
        color: #6b7280;
        border: 1px solid #d1d5db;
    }

    .btn--ghost:hover {
        border-color: #9ca3af;
        color: #374151;
    }

    .btn--danger {
        background: #dc2626;
        color: #fff;
    }

    .btn--danger:hover {
        background: #b91c1c;
    }

    /* ── Stats Strip ── */
    .cal-stats {
        display: flex;
        gap: 2rem;
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 1rem 1.5rem;
        margin-bottom: 1rem;
        flex-wrap: wrap;
    }

    .cal-stat {
        display: flex;
        align-items: center;
        gap: .5rem;
    }

    .cal-stat__dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .cal-stat__dot--blue {
        background: #1e40af;
    }

    .cal-stat__dot--amber {
        background: #d97706;
    }

    .cal-stat__dot--gray {
        background: #9ca3af;
    }

    .cal-stat__dot--navy {
        background: #19265d;
    }

    .cal-stat__num {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.25rem;
        font-weight: 700;
        color: #19265d;
    }

    .cal-stat__lbl {
        font-size: .8125rem;
        color: #9ca3af;
    }

    /* ── Legend ── */
    .cal-legend {
        display: flex;
        gap: 1.5rem;
        flex-wrap: wrap;
        margin-bottom: 1.25rem;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: .4rem;
        font-size: .8125rem;
        color: #6b7280;
    }

    .legend-dot {
        width: 12px;
        height: 12px;
        border-radius: 3px;
        flex-shrink: 0;
    }

    /* ── Calendar Wrap ── */
    .cal-wrap {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        padding: 1.5rem;
        overflow: hidden;
    }

    /* ── FullCalendar Overrides (Terra palette) ── */
    :root {
        --fc-border-color: #f3f4f6;
        --fc-daygrid-event-dot-width: 8px;
        --fc-today-bg-color: #fef9f3;
        --fc-page-bg-color: transparent;
        --fc-neutral-bg-color: #f9fafb;
        --fc-list-event-hover-bg-color: #f9fafb;
        --fc-button-bg-color: #19265d;
        --fc-button-border-color: #19265d;
        --fc-button-hover-bg-color: #C8873A;
        --fc-button-hover-border-color: #C8873A;
        --fc-button-active-bg-color: #C8873A;
        --fc-button-active-border-color: #C8873A;
        --fc-event-border-color: transparent;
    }

    .fc .fc-toolbar-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.5rem;
        font-weight: 600;
        color: #19265d;
    }

    .fc .fc-col-header-cell {
        background: #f9fafb;
    }

    .fc .fc-col-header-cell-cushion {
        font-size: .8125rem;
        font-weight: 600;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: .06em;
        padding: .6rem 0;
        text-decoration: none;
    }

    .fc .fc-daygrid-day-number {
        font-size: .875rem;
        color: #374151;
        text-decoration: none;
        padding: .4rem .6rem;
    }

    .fc .fc-daygrid-day.fc-day-today .fc-daygrid-day-number {
        background: #19265d;
        color: #fff;
        border-radius: 50%;
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: .3rem .3rem 0 auto;
        padding: 0;
    }

    .fc-day-blocked {
        background: #f9fafb !important;
    }

    .fc-day-blocked .fc-daygrid-day-number {
        opacity: .45;
    }

    .fc .fc-event {
        border-radius: 6px;
        font-size: .75rem;
        font-weight: 500;
        padding: 2px 5px;
        border: none;
        cursor: pointer;
    }

    .fc .fc-event:hover {
        filter: brightness(.92);
    }

    .fc .fc-button {
        font-size: .8125rem;
        padding: .35rem .85rem;
        border-radius: 7px;
        font-weight: 500;
        transition: all .2s;
    }

    .fc .fc-button:focus {
        box-shadow: 0 0 0 3px rgba(200, 135, 58, .25);
    }

    .fc .fc-more-link {
        font-size: .75rem;
        color: #C8873A;
        font-weight: 600;
    }

    /* ── Booking Popover ── */
    .popover {
        position: absolute;
        z-index: 500;
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 8px 40px rgba(25, 38, 93, .18);
        width: 300px;
        padding: 1.5rem;
        display: none;
    }

    .popover--visible {
        display: block;
        animation: popIn .18s ease;
    }

    @keyframes popIn {
        from {
            opacity: 0;
            transform: translateY(6px) scale(.97);
        }

        to {
            opacity: 1;
            transform: none;
        }
    }

    .popover__close {
        position: absolute;
        top: .875rem;
        right: .875rem;
        background: none;
        border: none;
        cursor: pointer;
        color: #9ca3af;
        padding: .25rem;
        border-radius: 6px;
    }

    .popover__close:hover {
        background: #f3f4f6;
        color: #374151;
    }

    .popover__close svg {
        width: 16px;
        height: 16px;
        display: block;
    }

    .popover__badge {
        display: inline-block;
        padding: .2rem .7rem;
        border-radius: 999px;
        font-size: .7rem;
        font-weight: 700;
        letter-spacing: .05em;
        text-transform: uppercase;
        margin-bottom: .75rem;
    }

    .popover__badge--confirmed {
        background: #dbeafe;
        color: #1e40af;
    }

    .popover__badge--pending {
        background: #fef3c7;
        color: #d97706;
    }

    .popover__badge--rejected {
        background: #fee2e2;
        color: #dc2626;
    }

    .popover__badge--completed {
        background: #d1fae5;
        color: #059669;
    }

    .popover__client {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.2rem;
        font-weight: 600;
        color: #19265d;
        margin: 0 0 .2rem;
    }

    .popover__service {
        font-size: .8125rem;
        color: #9ca3af;
        margin: 0 0 1rem;
    }

    .popover__meta {
        display: flex;
        flex-direction: column;
        gap: .55rem;
    }

    .popover__row {
        display: flex;
        align-items: flex-start;
        gap: .6rem;
        font-size: .8125rem;
        color: #374151;
    }

    .popover__icon {
        width: 18px;
        text-align: center;
        flex-shrink: 0;
        font-style: normal;
    }

    /* ── Modal ── */
    .modal {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 600;
        align-items: center;
        justify-content: center;
    }

    .modal--open {
        display: flex;
    }

    .modal__backdrop {
        position: absolute;
        inset: 0;
        background: rgba(25, 38, 93, .35);
        backdrop-filter: blur(4px);
    }

    .modal__card {
        position: relative;
        background: #fff;
        border-radius: 16px;
        padding: 2rem;
        width: 100%;
        max-width: 420px;
        margin: 1rem;
        box-shadow: 0 20px 60px rgba(25, 38, 93, .2);
        animation: slideUp .2s ease;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: none;
        }
    }

    .modal__title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.375rem;
        font-weight: 600;
        color: #19265d;
        margin: 0 0 .4rem;
    }

    .modal__date {
        font-size: .9375rem;
        font-weight: 500;
        color: #C8873A;
        margin: 0 0 1.25rem;
    }

    .modal__label {
        display: block;
        font-size: .8125rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: .4rem;
    }

    .modal__optional {
        font-weight: 400;
        color: #9ca3af;
    }

    .modal__input {
        width: 100%;
        padding: .6rem .875rem;
        border: 1.5px solid #e5e7eb;
        border-radius: 8px;
        font-size: .875rem;
        outline: none;
        box-sizing: border-box;
        transition: border-color .2s;
        margin-bottom: 1.5rem;
    }

    .modal__input:focus {
        border-color: #C8873A;
    }

    .modal__actions {
        display: flex;
        justify-content: flex-end;
        gap: .75rem;
    }

    /* ── Toast ── */
    .toast {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        background: #19265d;
        color: #fff;
        padding: .7rem 1.25rem;
        border-radius: 10px;
        font-size: .875rem;
        font-weight: 500;
        z-index: 700;
        opacity: 0;
        transform: translateY(10px);
        transition: all .25s;
        box-shadow: 0 4px 20px rgba(25, 38, 93, .25);
    }

    .toast--in {
        opacity: 1;
        transform: none;
    }

    .toast--unblocked {
        background: #059669;
    }

    .toast--error {
        background: #dc2626;
    }

    /* ── Responsive ── */
    @media (max-width: 640px) {
        .cal-page {
            padding: 1rem;
        }

        .cal-stats {
            gap: 1rem;
        }

        .cal-wrap {
            padding: .75rem;
        }

        .fc .fc-toolbar {
            flex-wrap: wrap;
            gap: .5rem;
        }

        .popover {
            width: calc(100vw - 2rem);
            left: 1rem !important;
        }
    }
</style>

<div class="cal-page">

    {{-- ── Header ── --}}
    <div class="cal-header">
        <div class="cal-header__left">
            <h1 class="cal-header__title">Calendar</h1>
            <p class="cal-header__sub">Manage your schedule and block unavailable dates</p>
        </div>
        <div class="cal-header__actions">
            <a href="{{ route('calendar.export') }}" class="btn btn--outline">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                    <polyline points="7 10 12 15 17 10" />
                    <line x1="12" y1="15" x2="12" y2="3" />
                </svg>
                Export iCal
            </a>
        </div>
    </div>

    {{-- ── Stats Strip ── --}}
    <div class="cal-stats">
        <div class="cal-stat">
            <span class="cal-stat__dot cal-stat__dot--blue"></span>
            <span class="cal-stat__num">{{ $confirmedBookings }}</span>
            <span class="cal-stat__lbl">Confirmed</span>
        </div>
        <div class="cal-stat">
            <span class="cal-stat__dot cal-stat__dot--amber"></span>
            <span class="cal-stat__num">{{ $pendingBookings }}</span>
            <span class="cal-stat__lbl">Pending</span>
        </div>
        <div class="cal-stat">
            <span class="cal-stat__dot cal-stat__dot--gray"></span>
            <span class="cal-stat__num" id="js-blocked-count">{{ count($blockedDates) }}</span>
            <span class="cal-stat__lbl">Blocked Days</span>
        </div>
        <div class="cal-stat">
            <span class="cal-stat__dot cal-stat__dot--navy"></span>
            <span class="cal-stat__num">{{ $totalBookings }}</span>
            <span class="cal-stat__lbl">Total Bookings</span>
        </div>
    </div>

    {{-- ── Legend ── --}}
    <div class="cal-legend">
        <span class="legend-item"><span class="legend-dot" style="background:#1e40af"></span>Confirmed</span>
        <span class="legend-item"><span class="legend-dot" style="background:#d97706"></span>Pending</span>
        <span class="legend-item"><span class="legend-dot" style="background:#dc2626"></span>Rejected</span>
        <span class="legend-item"><span class="legend-dot" style="background:#059669"></span>Completed</span>
        <span class="legend-item"><span class="legend-dot" style="background:#d1d5db;border:1px solid #9ca3af"></span>Blocked</span>
    </div>

    {{-- ── Calendar ── --}}
    <div class="cal-wrap">
        <div id="calendar"></div>
    </div>

    {{-- ── Booking Detail Popover ── --}}
    <div id="booking-popover" class="popover" role="dialog" aria-modal="true" aria-label="Booking details">
        <div class="popover__inner">
            <button class="popover__close" id="popover-close" aria-label="Close">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="18" y1="6" x2="6" y2="18" />
                    <line x1="6" y1="6" x2="18" y2="18" />
                </svg>
            </button>
            <div class="popover__badge" id="pop-status-badge"></div>
            <h3 class="popover__client" id="pop-client"></h3>
            <p class="popover__service" id="pop-service"></p>
            <div class="popover__meta">
                <div class="popover__row"><span class="popover__icon">✉</span><span id="pop-email"></span></div>
                <div class="popover__row"><span class="popover__icon">💰</span><span id="pop-fee"></span></div>
                <div class="popover__row"><span class="popover__icon">💳</span><span id="pop-payment"></span></div>
                <div class="popover__row" id="pop-notes-row"><span class="popover__icon">📝</span><span id="pop-notes"></span></div>
            </div>
        </div>
    </div>

    {{-- ── Block Date Modal ── --}}
    <div id="block-modal" class="modal" role="dialog" aria-modal="true" aria-label="Block date">
        <div class="modal__backdrop" id="modal-backdrop"></div>
        <div class="modal__card">
            <h3 class="modal__title" id="modal-title">Mark date as unavailable</h3>
            <p class="modal__date" id="modal-date-display"></p>
            <label class="modal__label" for="modal-reason">Reason <span class="modal__optional">(optional)</span></label>
            <input type="text" id="modal-reason" class="modal__input" placeholder="e.g. Public holiday, personal leave…" maxlength="255">
            <div class="modal__actions">
                <button class="btn btn--ghost" id="modal-cancel">Cancel</button>
                <button class="btn btn--primary" id="modal-confirm">Block this day</button>
            </div>
        </div>
    </div>

    {{-- ── Unblock Toast ── --}}
    <div id="unblock-modal" class="modal" role="dialog" aria-modal="true">
        <div class="modal__backdrop" id="unblock-backdrop"></div>
        <div class="modal__card">
            <h3 class="modal__title">Remove block?</h3>
            <p class="modal__date" id="unblock-date-display"></p>
            <p style="font-size:.875rem;color:#6b7280;margin:0 0 1.5rem;">This will make the date available for bookings again.</p>
            <div class="modal__actions">
                <button class="btn btn--ghost" id="unblock-cancel">Keep Blocked</button>
                <button class="btn btn--danger" id="unblock-confirm">Remove Block</button>
            </div>
        </div>
    </div>

</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {

        // ── Data from server ──────────────────────────────────────────────────────
        const EVENTS = @json($events);
        const BLOCKED_DATES = new Set(@json($blockedDates));
        const TOGGLE_URL = "{{ route('calendar.toggle') }}";
        const CSRF = "{{ csrf_token() }}";

        // ── State ─────────────────────────────────────────────────────────────────
        let pendingDate = null;
        let calendarInst = null;

        // ── Blocked-count badge ───────────────────────────────────────────────────
        const blockedCount = document.getElementById('js-blocked-count');

        function updateBlockedCount(delta) {
            blockedCount.textContent = parseInt(blockedCount.textContent) + delta;
        }

        // ── FullCalendar ──────────────────────────────────────────────────────────
        calendarInst = new FullCalendar.Calendar(document.getElementById('calendar'), {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay',
            },
            buttonText: {
                today: 'Today',
                month: 'Month',
                week: 'Week',
                day: 'Day'
            },
            height: 'auto',
            firstDay: 1, // Monday first
            nowIndicator: true,
            dayMaxEvents: 3,
            events: EVENTS,
            eventTimeFormat: {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            },

            // ── Day click → block / unblock ──────────────────────────────────────
            dateClick(info) {
                const dateStr = info.dateStr; // YYYY-MM-DD
                // Ignore past dates
                if (dateStr < new Date().toISOString().slice(0, 10)) return;

                if (BLOCKED_DATES.has(dateStr)) {
                    showUnblockModal(dateStr);
                } else {
                    showBlockModal(dateStr);
                }
            },

            // ── Event click → booking popover ────────────────────────────────────
            eventClick(info) {
                const props = info.event.extendedProps;
                if (props.type === 'blocked') return; // ignore background events

                const pop = document.getElementById('booking-popover');
                document.getElementById('pop-client').textContent = props.client;
                document.getElementById('pop-service').textContent = props.service;
                document.getElementById('pop-email').textContent = props.email;
                document.getElementById('pop-fee').textContent = props.fee;
                document.getElementById('pop-payment').textContent = props.paymentStatus;

                const notesRow = document.getElementById('pop-notes-row');
                if (props.notes) {
                    document.getElementById('pop-notes').textContent = props.notes;
                    notesRow.style.display = 'flex';
                } else {
                    notesRow.style.display = 'none';
                }

                const badge = document.getElementById('pop-status-badge');
                badge.textContent = props.status;
                badge.className = 'popover__badge popover__badge--' + props.status.toLowerCase();

                // Position near click
                const rect = info.el.getBoundingClientRect();
                const scrollY = window.scrollY;
                pop.style.top = (rect.bottom + scrollY + 8) + 'px';
                pop.style.left = Math.min(rect.left, window.innerWidth - 320) + 'px';
                pop.classList.add('popover--visible');
            },

            // ── Daygrid cell class for blocked dates ──────────────────────────────
            dayCellClassNames(arg) {
                const d = arg.date.toISOString().slice(0, 10);
                return BLOCKED_DATES.has(d) ? ['fc-day-blocked'] : [];
            },
        });

        calendarInst.render();

        // ── Popover close ─────────────────────────────────────────────────────────
        document.getElementById('popover-close').addEventListener('click', closePopover);
        document.addEventListener('click', function(e) {
            const pop = document.getElementById('booking-popover');
            if (!pop.contains(e.target)) closePopover();
        });

        function closePopover() {
            document.getElementById('booking-popover').classList.remove('popover--visible');
        }

        // ── Block modal ───────────────────────────────────────────────────────────
        function showBlockModal(dateStr) {
            pendingDate = dateStr;
            document.getElementById('modal-date-display').textContent = formatDate(dateStr);
            document.getElementById('modal-reason').value = '';
            document.getElementById('modal-confirm').textContent = 'Block this day';
            document.getElementById('block-modal').classList.add('modal--open');
        }

        document.getElementById('modal-cancel').addEventListener('click', () => {
            document.getElementById('block-modal').classList.remove('modal--open');
        });
        document.getElementById('modal-backdrop').addEventListener('click', () => {
            document.getElementById('block-modal').classList.remove('modal--open');
        });
        document.getElementById('modal-confirm').addEventListener('click', async () => {
            const reason = document.getElementById('modal-reason').value;
            document.getElementById('block-modal').classList.remove('modal--open');
            await toggleDate(pendingDate, reason);
        });

        // ── Unblock modal ─────────────────────────────────────────────────────────
        function showUnblockModal(dateStr) {
            pendingDate = dateStr;
            document.getElementById('unblock-date-display').textContent = formatDate(dateStr);
            document.getElementById('unblock-modal').classList.add('modal--open');
        }

        document.getElementById('unblock-cancel').addEventListener('click', () => {
            document.getElementById('unblock-modal').classList.remove('modal--open');
        });
        document.getElementById('unblock-backdrop').addEventListener('click', () => {
            document.getElementById('unblock-modal').classList.remove('modal--open');
        });
        document.getElementById('unblock-confirm').addEventListener('click', async () => {
            document.getElementById('unblock-modal').classList.remove('modal--open');
            await toggleDate(pendingDate, null);
        });

        // ── API: toggle date ──────────────────────────────────────────────────────
        async function toggleDate(dateStr, reason) {
            try {
                const res = await fetch(TOGGLE_URL, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF
                    },
                    body: JSON.stringify({
                        date: dateStr,
                        reason: reason
                    }),
                });
                const data = await res.json();

                if (data.blocked) {
                    BLOCKED_DATES.add(dateStr);
                    updateBlockedCount(1);
                    // Add background event
                    calendarInst.addEvent({
                        id: 'blocked_' + dateStr,
                        start: dateStr,
                        end: nextDay(dateStr),
                        display: 'background',
                        color: '#d1d5db',
                        extendedProps: {
                            type: 'blocked'
                        },
                    });
                } else {
                    BLOCKED_DATES.delete(dateStr);
                    updateBlockedCount(-1);
                    // Remove background event
                    const ev = calendarInst.getEventById('blocked_' + dateStr);
                    if (ev) ev.remove();
                }

                // Re-render to apply day cell class
                calendarInst.render();
                showToast(data.blocked ? '🚫 Date blocked' : '✅ Date unblocked', data.blocked ? 'blocked' : 'unblocked');
            } catch (err) {
                showToast('Something went wrong. Please try again.', 'error');
            }
        }

        // ── Toast ─────────────────────────────────────────────────────────────────
        function showToast(msg, type) {
            const t = document.createElement('div');
            t.className = 'toast toast--' + type;
            t.textContent = msg;
            document.body.appendChild(t);
            requestAnimationFrame(() => t.classList.add('toast--in'));
            setTimeout(() => {
                t.classList.remove('toast--in');
                setTimeout(() => t.remove(), 300);
            }, 2800);
        }

        // ── Helpers ───────────────────────────────────────────────────────────────
        function formatDate(str) {
            return new Date(str + 'T12:00:00').toLocaleDateString('en-GB', {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });
        }

        function nextDay(str) {
            const d = new Date(str + 'T00:00:00');
            d.setDate(d.getDate() + 1);
            return d.toISOString().slice(0, 10);
        }
    });
</script>

@endsection