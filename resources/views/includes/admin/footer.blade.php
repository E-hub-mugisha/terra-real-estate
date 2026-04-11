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

    .t-footer-copy a:hover { opacity: 0.75; }

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
        .t-footer-links { display: none; }
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
        <a href="https://homiez.rw" target="_blank" rel="noopener noreferrer">HOMIEZ</a>
    </div>
</footer>