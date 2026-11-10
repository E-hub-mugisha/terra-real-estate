<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Terra | Your Complete Real Estate Partner in Rwanda</title>
    <meta name="description" content="Discover Terra's complete real estate ecosystem in Rwanda. Find properties, access professional brokerage, manage rentals and explore property services.">
    <meta name="theme-color" content="#0B3B7A">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --orange: #D05208;
            --orange-dark: #AD4307;
            --orange-soft: #FDEEE4;
            --blue: #0B3B7A;
            --navy: #14275E;
            --navy-deep: #0D1A45;
            --ink: #1D2333;
            --muted: #6B7285;
            --paper: #F6F7FA;
            --line: #E6E9F0;
            --radius-lg: 20px;
            --radius-md: 12px;
            --shadow-sm: 0 1px 2px rgba(13, 26, 69, .06), 0 4px 14px rgba(13, 26, 69, .05);
            --shadow-md: 0 10px 30px rgba(13, 26, 69, .12);
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
            scroll-padding-top: 96px;
        }

        body {
            font-family: 'Montserrat', system-ui, sans-serif;
            font-size: 13px;
            line-height: 1.65;
            color: var(--ink);
            background: #fff;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        h1,
        h2,
        h3,
        h4,
        h5 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
            letter-spacing: -.02em;
            color: var(--navy);
        }

        a {
            text-decoration: none;
        }

        :focus-visible {
            outline: 2px solid var(--orange);
            outline-offset: 3px;
            border-radius: 6px;
        }

        .skip-link {
            position: absolute;
            left: 12px;
            top: -60px;
            z-index: 2000;
            background: var(--orange);
            color: #fff;
            padding: 8px 14px;
            border-radius: 8px;
            font-size: 12px;
        }

        .skip-link:focus {
            top: 12px;
            color: #fff;
        }

        /* ---------- Buttons ---------- */
        .btn-terra,
        .btn-light-terra {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            font-weight: 600;
            font-size: 12px;
            padding: 10px 20px;
            border-radius: 999px;
            border: 0;
            transition: background .2s, color .2s, transform .2s, box-shadow .2s;
        }

        .btn-terra {
            background: var(--orange);
            color: #fff;
        }

        .btn-terra:hover {
            background: var(--orange-dark);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(208, 82, 8, .35);
        }

        .btn-light-terra {
            background: #fff;
            color: var(--navy);
        }

        .btn-light-terra:hover {
            background: var(--orange-soft);
            color: var(--orange-dark);
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 10.5px;
            font-weight: 600;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: var(--orange);
            margin-bottom: 12px;
        }

        .eyebrow::before {
            content: "";
            width: 22px;
            height: 2px;
            border-radius: 2px;
            background: var(--orange);
        }

        /* ---------- Navigation (floating glass pill) ---------- */
        .site-nav {
            position: fixed;
            top: 14px;
            left: 0;
            right: 0;
            z-index: 1030;
            padding: 0 14px;
            pointer-events: none;
        }

        .nav-shell {
            pointer-events: auto;
            max-width: 1180px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 8px 8px 8px 20px;
            border-radius: 999px;
            background: rgba(11, 59, 122, .55);
            border: 1px solid rgba(255, 255, 255, .22);
            backdrop-filter: blur(18px) saturate(1.4);
            -webkit-backdrop-filter: blur(18px) saturate(1.4);
            box-shadow: 0 10px 34px rgba(8, 18, 52, .25), inset 0 1px 0 rgba(255, 255, 255, .18);
            transition: background .3s, box-shadow .3s, padding .3s;
        }

        .site-nav.scrolled .nav-shell {
            background: rgba(11, 59, 122, .94);
            padding-top: 6px;
            padding-bottom: 6px;
            box-shadow: 0 14px 40px rgba(8, 18, 52, .35), inset 0 1px 0 rgba(255, 255, 255, .12);
        }

        .brand {
            display: inline-flex;
            align-items: center;
            flex-shrink: 0;
        }

        .brand img {
            height: 30px;
            width: auto;
            display: block;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 2px;
            list-style: none;
            margin: 0;
            padding: 4px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .08);
        }

        .nav-links a {
            position: relative;
            display: inline-flex;
            align-items: center;
            padding: 7px 15px;
            border-radius: 999px;
            color: rgba(255, 255, 255, .88);
            font-weight: 500;
            font-size: 12px;
            transition: background .2s, color .2s;
        }

        .nav-links a:hover,
        .nav-links a:focus-visible {
            background: rgba(255, 255, 255, .16);
            color: #fff;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
        }

        .nav-actions .btn-terra {
            padding: 9px 18px;
            box-shadow: 0 6px 16px rgba(208, 82, 8, .4);
        }

        .nav-toggle {
            display: none;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, .25);
            background: rgba(255, 255, 255, .1);
            color: #fff;
            font-size: 20px;
            align-items: center;
            justify-content: center;
            padding: 0;
        }

        .nav-toggle:focus {
            box-shadow: none;
        }

        .nav-mobile {
            pointer-events: auto;
            max-width: 1180px;
            margin: 8px auto 0;
            border-radius: 22px;
            background: rgba(11, 59, 122, .96);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border: 1px solid rgba(255, 255, 255, .18);
            box-shadow: var(--shadow-md);
            overflow: hidden;
        }

        .nav-mobile ul {
            list-style: none;
            margin: 0;
            padding: 10px;
        }

        .nav-mobile a.m-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 14px;
            border-radius: 12px;
            color: #fff;
            font-weight: 500;
            font-size: 13px;
        }

        .nav-mobile a.m-link:hover {
            background: rgba(255, 255, 255, .1);
        }

        .nav-mobile a.m-link i {
            opacity: .5;
            font-size: 12px;
        }

        .nav-mobile .btn-terra {
            width: calc(100% - 20px);
            margin: 4px 10px 12px;
        }

        @media (max-width: 991px) {

            .nav-links,
            .nav-actions .btn-terra {
                display: none;
            }

            .nav-toggle {
                display: inline-flex;
            }

            .nav-shell {
                padding-left: 16px;
            }
        }

        /* ---------- Hero ---------- */
        .hero {
            position: relative;
            isolation: isolate;
            min-height: clamp(560px, 88vh, 760px);
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 120px 0 64px;
            color: #fff;
            background: var(--navy-deep);
        }

        .hero-bg {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center 60%;
            z-index: -2;
        }

        .hero::after {
            content: "";
            position: absolute;
            inset: 0;
            z-index: -1;
            background:
                radial-gradient(ellipse at 50% 40%, rgba(13, 26, 69, .15), rgba(13, 26, 69, .55) 80%),
                linear-gradient(180deg, rgba(13, 26, 69, .55) 0%, rgba(13, 26, 69, .1) 45%, rgba(13, 26, 69, .6) 100%);
        }

        .hero-tag {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 14px 6px 8px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .14);
            border: 1px solid rgba(255, 255, 255, .3);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            font-size: 11px;
            font-weight: 500;
            margin-bottom: 22px;
        }

        .hero-tag b {
            background: var(--orange);
            border-radius: 999px;
            padding: 2px 9px;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: .06em;
            text-transform: uppercase;
        }

        .hero h1 {
            color: #fff;
            font-weight: 600;
            font-size: clamp(24px, 3.8vw, 42px);
            line-height: 1.18;
            letter-spacing: -.03em;
            /* max-width: 24ch; */
            margin: 0 auto 30px;
            text-wrap: balance;
            text-shadow: 0 2px 20px rgba(0, 0, 0, .35);
        }

        .hero-search {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            max-width: 720px;
            margin: 0 auto;
            padding: 8px 8px 8px 20px;
            border-radius: 999px;
            /* background: rgba(255, 255, 255, .95); */
            background: rgba(255, 255, 255, .14);
            border: 1px solid rgba(255, 255, 255, .32);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, .28);
            transition: box-shadow .2s;
        }

        .hero-search>i {
            font-size: 16px;
            color: var(--orange);
            flex-shrink: 0;
        }

        .hero-search input {
            flex: 1;
            min-width: 0;
            background: transparent;
            border: 0;
            color: var(--ink);
            font-family: 'Montserrat', sans-serif;
            font-weight: 500;
            font-size: 13px;
            padding: 8px 4px;
        }

        .hero-search input::placeholder {
            color: var(--muted);
        }

        .hero-search input:focus {
            outline: none;
        }

        .hero-search:focus-within {
            box-shadow: 0 0 0 3px rgba(208, 82, 8, .5), 0 20px 50px rgba(0, 0, 0, .28);
        }

        .hero-search .btn-terra {
            padding: 12px 28px;
            font-size: 13px;
            flex-shrink: 0;
        }

        .hero-badges {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
            margin: 24px 0 0;
            padding: 0;
            list-style: none;
        }

        .hero-badges li {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 18px 8px 12px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .14);
            border: 1px solid rgba(255, 255, 255, .32);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            font-weight: 500;
            font-size: 12px;
        }

        .hero-badges i {
            font-size: 15px;
            color: #F59A62;
        }

        @media (max-width: 575px) {
            .hero {
                padding: 104px 0 44px;
            }

            .hero-search {
                flex-wrap: wrap;
                border-radius: 22px;
                padding: 12px;
            }

            .hero-search input {
                flex-basis: calc(100% - 34px);
            }

            .hero-search .btn-terra {
                width: 100%;
            }
        }

        /* ---------- Section basics ---------- */
        .section {
            padding: 72px 0;
        }

        .section-title {
            font-size: clamp(20px, 2.4vw, 28px);
            line-height: 1.25;
            margin-bottom: 10px;
        }

        .section-copy {
            color: var(--muted);
            font-size: 13px;
            line-height: 1.75;
            max-width: 500px;
        }

        @media (max-width: 991px) {
            .section {
                padding: 52px 0;
            }
        }

        /* ---------- Services (bento) ---------- */
        .bento {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 14px;
        }

        .tile {
            position: relative;
            isolation: isolate;
            overflow: hidden;
            border-radius: var(--radius-lg);
            padding: 26px;
            min-height: 300px;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            color: #fff;
            box-shadow: var(--shadow-sm);
            transition: transform .3s, box-shadow .3s;
        }

        .tile:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
            color: #fff;
        }

        .tile img.bg {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -2;
            transition: transform .6s;
        }

        .tile::after {
            content: "";
            position: absolute;
            inset: 0;
            z-index: -1;
            background: linear-gradient(180deg, rgba(13, 26, 69, .05) 25%, rgba(13, 26, 69, .92) 100%);
        }

        .tile:hover img.bg {
            transform: scale(1.05);
        }

        .tile-num {
            position: absolute;
            top: 20px;
            left: 24px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .12em;
            padding: 5px 12px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .16);
            border: 1px solid rgba(255, 255, 255, .3);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }

        .tile h3 {
            color: #fff;
            font-size: 18px;
            margin-bottom: 6px;
        }

        .tile p {
            color: rgba(255, 255, 255, .86);
            font-size: 12.5px;
            margin-bottom: 14px;
            max-width: 420px;
        }

        .tile-link {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            align-self: flex-start;
            color: #fff;
            font-weight: 600;
            font-size: 12px;
        }

        .tile-link .arr {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: var(--orange);
            display: grid;
            place-items: center;
            font-size: 12px;
            transition: transform .25s;
        }

        .tile:hover .arr {
            transform: rotate(45deg);
        }

        .tile-a {
            grid-column: span 7;
        }

        .tile-b {
            grid-column: span 5;
            background: linear-gradient(145deg, var(--orange) 0%, #B8440A 100%);
        }

        .tile-b::after {
            display: none;
        }

        .tile-b .arr {
            background: #fff;
            color: var(--orange);
        }

        .tile-b .big-ico {
            position: absolute;
            right: -14px;
            top: -14px;
            font-size: 170px;
            color: rgba(255, 255, 255, .12);
            z-index: -1;
        }

        .perks {
            list-style: none;
            padding: 0;
            margin: 0 0 16px;
        }

        .perks li {
            display: flex;
            gap: 9px;
            align-items: center;
            padding: 4px 0;
            font-weight: 500;
            font-size: 12.5px;
        }

        .tile-c {
            grid-column: span 12;
            min-height: 260px;
        }

        @media (max-width: 991px) {

            .tile-a,
            .tile-b,
            .tile-c {
                grid-column: span 12;
                min-height: 260px;
            }
        }

        /* ---------- Why Terra ---------- */
        .why {
            background: var(--paper);
        }

        .why-img {
            border-radius: var(--radius-lg);
            width: 100%;
            height: 100%;
            min-height: 360px;
            object-fit: cover;
            box-shadow: var(--shadow-md);
        }

        .why-list {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin: 22px 0;
        }

        .why-item {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: var(--radius-md);
            padding: 16px;
            transition: transform .25s, box-shadow .25s, border-color .25s;
        }

        .why-item:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-sm);
            border-color: transparent;
        }

        .why-item .ico {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: var(--orange-soft);
            color: var(--orange);
            display: grid;
            place-items: center;
            font-size: 16px;
        }

        .why-item h5 {
            font-size: 13px;
            margin: 12px 0 4px;
        }

        .why-item p {
            margin: 0;
            font-size: 12px;
            color: var(--muted);
            line-height: 1.6;
        }

        @media (max-width: 575px) {
            .why-list {
                grid-template-columns: 1fr;
            }
        }

        /* ---------- Numbers ---------- */
        .numbers {
            background: linear-gradient(120deg, var(--blue) 0%, var(--navy) 100%);
            color: #fff;
            padding: 46px 0;
        }

        .number {
            position: relative;
        }

        .number h3 {
            color: #fff;
            font-size: clamp(26px, 3.4vw, 34px);
            font-weight: 600;
            margin-bottom: 2px;
        }

        .number h3 small {
            color: #F59A62;
            font-size: .6em;
        }

        .number p {
            margin: 0;
            color: rgba(255, 255, 255, .72);
            font-size: 12px;
        }

        @media (min-width: 992px) {
            .number:not(:last-child)::after {
                content: "";
                position: absolute;
                right: 12px;
                top: 8px;
                bottom: 8px;
                width: 1px;
                background: rgba(255, 255, 255, .16);
            }
        }

        /* ---------- Journey ---------- */
        .journey {
            position: relative;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-top: 40px;
        }

        .journey::before {
            content: "";
            position: absolute;
            left: 6%;
            right: 6%;
            top: 20px;
            height: 2px;
            background: repeating-linear-gradient(90deg, var(--line) 0 8px, transparent 8px 16px);
        }

        .step {
            position: relative;
        }

        .step-dot {
            position: relative;
            z-index: 1;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: #fff;
            border: 2px solid var(--orange);
            color: var(--orange);
            display: grid;
            place-items: center;
            font-weight: 700;
            font-size: 14px;
            margin-bottom: 12px;
        }

        .step:first-child .step-dot {
            background: var(--orange);
            color: #fff;
            box-shadow: 0 0 0 6px var(--orange-soft);
        }

        .step h5 {
            font-size: 14px;
        }

        .step p {
            color: var(--muted);
            font-size: 12px;
            margin: 0;
            max-width: 230px;
        }

        @media (max-width: 991px) {
            .journey {
                grid-template-columns: 1fr;
                gap: 22px;
            }

            .journey::before {
                left: 20px;
                right: auto;
                top: 0;
                bottom: 0;
                width: 2px;
                height: auto;
                background: repeating-linear-gradient(180deg, var(--line) 0 8px, transparent 8px 16px);
            }

            .step {
                padding-left: 60px;
            }

            .step-dot {
                position: absolute;
                left: 0;
                top: 0;
                margin: 0;
            }
        }

        /* ---------- FAQ ---------- */
        .faq .accordion-item {
            border: 1px solid var(--line);
            border-radius: var(--radius-md) !important;
            background: #fff;
            margin-bottom: 10px;
            overflow: hidden;
        }

        .faq .accordion-button {
            background: transparent;
            box-shadow: none;
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
            font-size: 13px;
            color: var(--navy);
            padding: 16px 20px;
        }

        .faq .accordion-button:not(.collapsed) {
            color: var(--orange);
            background: transparent;
        }

        .faq .accordion-body {
            padding: 0 20px 18px;
            color: var(--muted);
            font-size: 12.5px;
            line-height: 1.75;
        }

        /* ---------- CTA ---------- */
        .cta {
            position: relative;
            overflow: hidden;
            background: linear-gradient(120deg, var(--blue) 0%, var(--navy-deep) 100%);
            border-radius: var(--radius-lg);
            padding: 46px;
            color: #fff;
        }

        .cta::before {
            content: "";
            position: absolute;
            right: -80px;
            top: -120px;
            width: 340px;
            height: 340px;
            border-radius: 50%;
            /* background: radial-gradient(circle, rgba(208, 82, 8, .55), transparent 70%); */
        }

        .cta>* {
            position: relative;
        }

        .cta h2 {
            color: #fff;
            font-size: clamp(20px, 2.6vw, 26px);
            margin-bottom: 8px;
        }

        .cta p {
            color: rgba(255, 255, 255, .8);
            font-size: 13px;
            margin: 0;
            max-width: 460px;
        }

        @media (max-width: 767px) {
            .cta {
                padding: 30px 22px;
            }
        }

        /* ---------- Footer ---------- */
        footer {
            background: #0A1138;
            color: #fff;
            padding: 56px 0 20px;
            margin-top: 72px;
        }

        footer h5 {
            color: #fff;
            font-size: 13px;
            margin-bottom: 12px;
        }

        footer p,
        footer a {
            color: #B9C0D6;
            font-size: 12px;
            line-height: 2;
        }

        footer a:hover {
            color: #fff;
        }

        footer .brand img {
            height: 32px;
            width: auto;
        }

        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .social {
            display: flex;
            gap: 8px;
            margin-top: 14px;
        }

        .social a {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, .2);
            display: grid;
            place-items: center;
            transition: .2s;
        }

        .social a:hover {
            background: var(--orange);
            border-color: var(--orange);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, .1);
            margin-top: 36px;
            padding-top: 16px;
        }

        /* ---------- Floating WhatsApp ---------- */
        .wa-float {
            position: fixed;
            right: 18px;
            bottom: 18px;
            z-index: 1040;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #25D366;
            color: #fff;
            padding: 10px 16px;
            border-radius: 999px;
            font-weight: 600;
            font-size: 12px;
            box-shadow: 0 10px 26px rgba(37, 211, 102, .4);
            transition: transform .2s;
        }

        .wa-float:hover {
            color: #fff;
            transform: translateY(-2px);
        }

        .wa-float i {
            font-size: 18px;
        }

        @media (max-width: 575px) {
            .wa-float span {
                display: none;
            }

            .wa-float {
                padding: 13px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            html {
                scroll-behavior: auto;
            }

            *,
            *::before,
            *::after {
                transition-duration: .01ms !important;
            }
        }
    </style>
</head>

<body>

    @php
    /*
    | Terra service destinations
    | Set TERRA_RENTAL_URL in .env once the rental app has its public URL.
    */
    $rentalUrl = env('TERRA_RENTAL_URL', 'http://rent.terra.rw/');
    $brokerageUrl = url('/brokerage-services'); // TODO: add brokerage URL
    $marketplaceUrl = url('/marketplace'); // TODO: add marketplace URL
    $servicesUrl = url('/our-services');
    $aboutUrl = url('/about');
    $whatsappUrl = 'https://wa.me/250796511725';
    $email = 'terraltd.rd@gmail.com';
    @endphp

    <a href="#main" class="skip-link">Skip to content</a>

    <!-- NAVIGATION -->
    <header class="site-nav" id="siteNav">
        <nav class="nav-shell" aria-label="Main navigation">
            <a class="brand" href="{{ url('/') }}" aria-label="Terra home">
                <img src="{{ asset('front/assets/img/logo/logo-wc.png') }}" alt="Terra logo" width="120" height="32">
            </a>

            <ul class="nav-links">
                <li><a href="{{ $rentalUrl }}">Manage Rentals</a></li>
                <li><a href="{{ $marketplaceUrl }}">Prop Marketplace</a></li>
                <li><a href="{{ $brokerageUrl }}">Brokerage</a></li>
                <li><a href="#why-terra">Why Terra</a></li>
                <li><a href="{{ $aboutUrl }}">About us</a></li>
            </ul>

            <div class="nav-actions">
                <a href="{{ $marketplaceUrl }}" class="btn-terra">Browse properties <i class="bi bi-arrow-up-right"></i></a>
                <button class="nav-toggle" type="button" data-bs-toggle="collapse"
                    data-bs-target="#terraNavbar" aria-controls="terraNavbar"
                    aria-expanded="false" aria-label="Toggle menu">
                    <i class="bi bi-list"></i>
                </button>
            </div>
        </nav>

        <div class="collapse" id="terraNavbar">
            <div class="nav-mobile">
                <ul>
                    <li><a class="m-link" href="{{ $rentalUrl }}">Manage Rentals <i class="bi bi-chevron-right"></i></a></li>
                    <li><a class="m-link" href="{{ $marketplaceUrl }}">Prop Marketplace <i class="bi bi-chevron-right"></i></a></li>
                    <li><a class="m-link" href="{{ $brokerageUrl }}">Brokerage <i class="bi bi-chevron-right"></i></a></li>
                    <li><a class="m-link" href="#why-terra">Why Terra <i class="bi bi-chevron-right"></i></a></li>
                    <li><a class="m-link" href="{{ $aboutUrl }}">About us <i class="bi bi-chevron-right"></i></a></li>
                </ul>
                <a href="{{ $marketplaceUrl }}" class="btn-terra">Browse properties <i class="bi bi-arrow-up-right"></i></a>
            </div>
        </div>
    </header>

    <main id="main">

        <!-- HERO -->
        <section class="hero" id="home">
            <!-- Swap for your own sunset-villa photo, e.g. asset('images/hero-villa.jpg') -->
            <img class="hero-bg"
                src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=2000"
                alt="" width="2000" height="1125" fetchpriority="high">

            <div class="container">
                <h1 data-aos="fade-up">Welcome to Terra where real estate meets technology in Rwanda</h1>

                <form class="hero-search" action="{{ $marketplaceUrl }}" method="get" role="search"
                    data-aos="fade-up" data-aos-delay="150">
                    <i class="bi bi-search" aria-hidden="true"></i>
                    <label for="heroSearch" >Search neighborhoods or properties in Rwanda</label>
                    <input id="heroSearch" type="search" name="q" autocomplete="off"
                        >
                    <button type="submit" class="btn-terra">Search</button>
                </form>

                <ul class="hero-badges" data-aos="fade-up" data-aos-delay="300">
                    <li><i class="bi bi-shield-check" aria-hidden="true"></i>Verified Agents</li>
                    <li><i class="bi bi-shield-lock" aria-hidden="true"></i>Secure Transactions</li>
                </ul>
            </div>
        </section>

        <!-- SERVICES -->
        <section class="section" id="services">
            <div class="container">
                <div class="row align-items-end g-3 mb-4">
                    <div class="col-lg-7" data-aos="fade-right">
                        <span class="eyebrow">Our services</span>
                        <h2 class="section-title mb-0">One platform. Every real estate solution.</h2>
                    </div>
                    <div class="col-lg-5" data-aos="fade-left">
                        <p class="section-copy mb-0">
                            Whether you own, invest, buy, sell or rent, pick the service that fits and
                            switch between them anytime.
                        </p>
                    </div>
                </div>

                <div class="bento">

                    <a href="{{ $marketplaceUrl }}" class="tile tile-a" data-aos="zoom-in-up">
                        <img class="bg" loading="lazy" src="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=1200"
                            alt="" width="1200" height="800">
                        <span class="tile-num">01</span>
                        <h3>Property Marketplace</h3>
                        <p>Search houses, apartments, land and architectural designs across Rwanda and contact sellers directly.</p>
                        <span class="tile-link">Browse the marketplace <span class="arr"><i class="bi bi-arrow-up-right"></i></span></span>
                    </a>

                    <a href="{{ $rentalUrl }}" class="tile tile-b" data-aos="zoom-in-up" data-aos-delay="120">
                        <i class="bi bi-key big-ico" aria-hidden="true"></i>
                        <span class="tile-num">02</span>
                        <h3>Smart Rental Management</h3>
                        <ul class="perks">
                            <li><i class="bi bi-check-circle-fill"></i> Buildings, units and tenants</li>
                            <li><i class="bi bi-check-circle-fill"></i> Leases and rent collection</li>
                            <li><i class="bi bi-check-circle-fill"></i> Payments and maintenance</li>
                        </ul>
                        <span class="tile-link">Open rental management <span class="arr"><i class="bi bi-arrow-up-right"></i></span></span>
                    </a>

                    <a href="{{ $brokerageUrl }}" class="tile tile-c" data-aos="zoom-in-up">
                        <img class="bg" loading="lazy" src="https://images.unsplash.com/photo-1560520653-9e0e4c89eb11?w=1600"
                            alt="" width="1600" height="700">
                        <span class="tile-num">03</span>
                        <h3>Terra Brokerage</h3>
                        <p>Work with experienced agents who guide you through buying, selling or renting, from first viewing to signed contract.</p>
                        <span class="tile-link">Meet our agents <span class="arr"><i class="bi bi-arrow-up-right"></i></span></span>
                    </a>

                </div>
            </div>
        </section>

        <!-- WHY TERRA -->
        <section class="section why" id="why-terra">
            <div class="container">
                <div class="row g-5 align-items-stretch">

                    <div class="col-lg-5" data-aos="fade-right">
                        <img class="why-img" loading="lazy"
                            src="https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?w=1100"
                            alt="Modern property architecture" width="1100" height="1300">
                    </div>

                    <div class="col-lg-7 d-flex flex-column justify-content-center">
                        <span class="eyebrow" data-aos="fade-up">Why Terra</span>
                        <h2 class="section-title" data-aos="fade-up">Property decisions are easier when everything is connected.</h2>
                        <p class="section-copy" data-aos="fade-up" data-aos-delay="80">
                            Terra is more than a listing website. We bring discovery, professional advice and
                            day-to-day management into one place.
                        </p>

                        <div class="why-list">
                            <div class="why-item" data-aos="fade-up" data-aos-delay="0">
                                <div class="ico"><i class="bi bi-patch-check"></i></div>
                                <h5>Verified by our team</h5>
                                <p>Listings and professional profiles are reviewed before they go live.</p>
                            </div>
                            <div class="why-item" data-aos="fade-up" data-aos-delay="100">
                                <div class="ico"><i class="bi bi-geo-alt"></i></div>
                                <h5>Nationwide reach</h5>
                                <p>Opportunities across Rwanda's 30 districts.</p>
                            </div>
                            <div class="why-item" data-aos="fade-up" data-aos-delay="200">
                                <div class="ico"><i class="bi bi-laptop"></i></div>
                                <h5>Digital tools</h5>
                                <p>Search, manage rentals and contact professionals from any device.</p>
                            </div>
                            <div class="why-item" data-aos="fade-up" data-aos-delay="300">
                                <div class="ico"><i class="bi bi-people"></i></div>
                                <h5>Real people to help</h5>
                                <p>Agents and consultants ready to advise at every stage.</p>
                            </div>
                        </div>

                        <div data-aos="fade-up"><a href="{{ $aboutUrl }}" class="btn-terra">About Terra <i class="bi bi-arrow-right"></i></a></div>
                    </div>

                </div>
            </div>
        </section>

        <!-- NUMBERS -->
        <section class="numbers" aria-label="Terra in numbers">
            <div class="container">
                <div class="row g-4 text-center text-lg-start">
                    <div class="col-6 col-lg-3 number" data-aos="flip-up" data-aos-delay="0">
                        <h3>500<small>+</small></h3>
                        <p>Properties listed</p>
                    </div>
                    <div class="col-6 col-lg-3 number" data-aos="flip-up" data-aos-delay="100">
                        <h3>120<small>+</small></h3>
                        <p>Verified agents</p>
                    </div>
                    <div class="col-6 col-lg-3 number" data-aos="flip-up" data-aos-delay="200">
                        <h3>30</h3>
                        <p>Districts covered</p>
                    </div>
                    <div class="col-6 col-lg-3 number" data-aos="flip-up" data-aos-delay="300">
                        <h3>98<small>%</small></h3>
                        <p>Client satisfaction</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- JOURNEY -->
        <section class="section" id="journey">
            <div class="container">
                <div class="text-center mx-auto" style="max-width:580px" data-aos="fade-up">
                    <span class="eyebrow">How it works</span>
                    <h2 class="section-title">From first search to managing your investment.</h2>
                    <p class="section-copy mx-auto">Four steps, and Terra supports you through each one.</p>
                </div>

                <div class="journey">
                    <div class="step" data-aos="fade-up" data-aos-delay="0">
                        <div class="step-dot">1</div>
                        <h5>Discover</h5>
                        <p>Explore properties, land, designs and investment opportunities.</p>
                    </div>
                    <div class="step" data-aos="fade-up" data-aos-delay="120">
                        <div class="step-dot">2</div>
                        <h5>Connect</h5>
                        <p>Talk to owners, verified agents and professional consultants.</p>
                    </div>
                    <div class="step" data-aos="fade-up" data-aos-delay="240">
                        <div class="step-dot">3</div>
                        <h5>Transact</h5>
                        <p>Get support while you buy, sell or rent.</p>
                    </div>
                    <div class="step" data-aos="fade-up" data-aos-delay="360">
                        <div class="step-dot">4</div>
                        <h5>Manage</h5>
                        <p>Run your rentals and keep track of your property investments.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ -->
        <section class="section pt-0 faq" id="faq">
            <div class="container">
                <div class="row g-5">
                    <div class="col-lg-4" data-aos="fade-right">
                        <span class="eyebrow">FAQ</span>
                        <h2 class="section-title">Questions we hear often</h2>
                        <p class="section-copy">Can't find your answer? Our team replies on WhatsApp during working hours.</p>
                        <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener" class="btn-terra mt-2">
                            <i class="bi bi-whatsapp"></i> Ask on WhatsApp
                        </a>
                    </div>
                    <div class="col-lg-8" data-aos="fade-left">
                        <div class="accordion" id="faqList">

                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#f1" aria-expanded="true" aria-controls="f1">
                                        How do I list my property on Terra?
                                    </button>
                                </h3>
                                <div id="f1" class="accordion-collapse collapse show" data-bs-parent="#faqList">
                                    <div class="accordion-body">Create an account, add your property details and photos, and our team reviews the listing before it appears on the marketplace.</div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#f2" aria-expanded="false" aria-controls="f2">
                                        Can I manage several buildings and tenants?
                                    </button>
                                </h3>
                                <div id="f2" class="accordion-collapse collapse" data-bs-parent="#faqList">
                                    <div class="accordion-body">Yes. Terra Smart Rental Management handles buildings, units, tenants, leases, rent collection, payments and maintenance in one dashboard.</div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#f3" aria-expanded="false" aria-controls="f3">
                                        Do I need an agent to buy or rent?
                                    </button>
                                </h3>
                                <div id="f3" class="accordion-collapse collapse" data-bs-parent="#faqList">
                                    <div class="accordion-body">No, you can contact sellers directly from the marketplace. If you want guidance, Terra Brokerage connects you with an experienced agent.</div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#f4" aria-expanded="false" aria-controls="f4">
                                        Which areas does Terra cover?
                                    </button>
                                </h3>
                                <div id="f4" class="accordion-collapse collapse" data-bs-parent="#faqList">
                                    <div class="accordion-body">All 30 districts of Rwanda, with the widest selection in Kigali.</div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA -->
        <section aria-label="Get started">
            <div class="container">
                <div class="cta" data-aos="zoom-in">
                    <div class="row align-items-center g-4">
                        <div class="col-lg-7">
                            <h2>Whatever your property needs, start with Terra.</h2>
                            <p>Discover opportunities, make informed decisions and manage your investments with confidence.</p>
                        </div>
                        <div class="col-lg-5 d-flex flex-wrap gap-3 justify-lg-end">
                            <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener" class="btn-terra">
                                <i class="bi bi-whatsapp"></i> Contact our team
                            </a>
                            <a href="{{ $marketplaceUrl }}" class="btn-light-terra">Browse properties</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- FOOTER -->
    <footer>
        <div class="container">
            <div class="row g-5">

                <div class="col-lg-4" data-aos="fade-up">
                    <a class="brand" href="{{ url('/') }}" aria-label="Terra home">
                        <img src="{{ asset('front/assets/img/logo/logo-wc.png') }}" alt="Terra logo" width="120" height="32">
                    </a>
                    <p class="mt-3">
                        Rwanda's real estate ecosystem connecting owners, buyers, sellers, tenants,
                        investors and professionals through trusted services and technology.
                    </p>
                    <div class="social">
                        <a href="https://www.linkedin.com/" target="_blank" rel="noopener" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
                        <a href="https://www.instagram.com/" target="_blank" rel="noopener" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                        <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                    </div>
                </div>

                <div class="col-6 col-lg-2" data-aos="fade-up" data-aos-delay="100">
                    <h5>Services</h5>
                    <ul class="footer-links">
                        <li><a href="{{ $rentalUrl }}">Rental management</a></li>
                        <li><a href="{{ $brokerageUrl }}">Brokerage</a></li>
                        <li><a href="{{ $marketplaceUrl }}">Marketplace</a></li>
                        <li><a href="{{ $servicesUrl }}">Other services</a></li>
                    </ul>
                </div>

                <div class="col-6 col-lg-2" data-aos="fade-up" data-aos-delay="200">
                    <h5>Explore</h5>
                    <ul class="footer-links">
                        <li><a href="{{ $marketplaceUrl }}">Buy property</a></li>
                        <li><a href="{{ $marketplaceUrl }}">Rent property</a></li>
                        <li><a href="{{ $brokerageUrl }}">Find agents</a></li>
                        <li><a href="{{ $servicesUrl }}">Consultancy</a></li>
                    </ul>
                </div>

                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
                    <h5>Get in touch</h5>
                    <p class="mb-1"><i class="bi bi-geo-alt me-2"></i>Kigali, Rwanda</p>
                    <p class="mb-1"><i class="bi bi-telephone me-2"></i><a href="tel:+250796511725">+250 796 511 725</a></p>
                    <p class="mb-1"><i class="bi bi-envelope me-2"></i><a href="mailto:{{ $email }}">{{ $email }}</a></p>
                    <p class="mb-0"><i class="bi bi-clock me-2"></i>Mon – Fri: 9:00 AM – 6:00 PM</p>
                </div>

            </div>

            <div class="footer-bottom">
                <div class="row align-items-center g-2">
                    <div class="col-md-6">
                        <p class="mb-0">© {{ date('Y') }} Terra Real Estate. All rights reserved.</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <a href="{{ url('/legal/privacy-policy') }}">Privacy Policy</a>
                        <span class="mx-2">|</span>
                        <a href="{{ url('/legal/terms-of-service') }}">Terms of Service</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener" class="wa-float" aria-label="Chat with Terra on WhatsApp">
        <i class="bi bi-whatsapp"></i><span>Chat with us</span>
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 700,
            easing: 'ease-out-cubic',
            once: true,
            offset: 60,
            // skip animations for people who prefer reduced motion
            disable: function() {
                return window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            }
        });

        // Solidify the floating nav once the page scrolls
        (function() {
            var nav = document.getElementById('siteNav');
            var onScroll = function() {
                nav.classList.toggle('scrolled', window.scrollY > 24);
            };
            onScroll();
            window.addEventListener('scroll', onScroll, {
                passive: true
            });
        })();
    </script>

</body>

</html>