<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Professional Portal — Terra')</title>

    {{-- Google Fonts: Cormorant Garamond + DM Sans --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="{{ asset('dashboard/assets/css/bootstrap.rtl.css') }}" rel="stylesheet" type="text/css" disabled>
    <style>
        /* ── Reset & Base ──────────────────────────────────────────────── */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --navy: #19265d;
            --navy-dark: #111b47;
            --navy-light: #243278;
            --gold: #D05208;
            --gold-light: #e06820;
            --gold-pale: #fff3ec;
            --white: #ffffff;
            --surface: #f7f8fc;
            --border: #e4e7f0;
            --text: #1e2535;
            --muted: #6b7592;
            --success: #0f7b4c;
            --success-bg: #e6f7ef;
            --warning: #b45309;
            --warning-bg: #fef3c7;
            --info: #1d61b8;
            --info-bg: #dbeafe;
            --danger: #b91c1c;
            --danger-bg: #fee2e2;
            --sidebar-w: 260px;
            --topbar-h: 64px;
            --radius: 10px;
            --shadow-sm: 0 1px 4px rgba(25, 38, 93, .08);
            --shadow: 0 4px 20px rgba(25, 38, 93, .12);
            --font-serif: 'Cormorant Garamond', Georgia, serif;
            --font-sans: 'DM Sans', system-ui, sans-serif;
        }

        html,
        body {
            height: 100%;
            font-family: var(--font-sans);
            color: var(--text);
            background: var(--surface);
        }

        /* ── Sidebar ───────────────────────────────────────────────────── */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-w);
            height: 100vh;
            background: var(--navy);
            display: flex;
            flex-direction: column;
            z-index: 100;
            transition: transform .3s ease;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 22px 24px;
            border-bottom: 1px solid rgba(255, 255, 255, .08);
            text-decoration: none;
        }

        .sidebar-logo-mark {
            width: 36px;
            height: 36px;
            background: var(--gold);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--font-serif);
            font-size: 18px;
            font-weight: 700;
            color: #fff;
        }

        .sidebar-logo-text {
            display: flex;
            flex-direction: column;
        }

        .sidebar-logo-name {
            font-family: var(--font-serif);
            font-size: 20px;
            font-weight: 600;
            color: #fff;
            line-height: 1;
        }

        .sidebar-logo-role {
            font-size: 10px;
            font-weight: 500;
            color: rgba(255, 255, 255, .45);
            letter-spacing: .12em;
            text-transform: uppercase;
            margin-top: 2px;
        }

        .sidebar-nav {
            flex: 1;
            padding: 20px 12px;
            overflow-y: auto;
        }

        .nav-section-label {
            font-size: 9px;
            font-weight: 600;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .3);
            padding: 14px 12px 6px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 14px;
            border-radius: 8px;
            text-decoration: none;
            color: rgba(255, 255, 255, .7);
            font-size: 14px;
            font-weight: 400;
            margin-bottom: 2px;
            transition: all .2s;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, .08);
            color: #fff;
        }

        .nav-link.active {
            background: var(--gold);
            color: #fff;
            font-weight: 500;
        }

        .nav-link svg {
            flex-shrink: 0;
            opacity: .85;
        }

        .nav-link.active svg {
            opacity: 1;
        }

        .nav-badge {
            margin-left: auto;
            background: rgba(255, 255, 255, .15);
            color: #fff;
            font-size: 11px;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 20px;
        }

        .nav-link.active .nav-badge {
            background: rgba(255, 255, 255, .25);
        }

        .sidebar-footer {
            padding: 16px 12px;
            border-top: 1px solid rgba(255, 255, 255, .08);
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            border-radius: 8px;
            background: rgba(255, 255, 255, .06);
        }

        .sidebar-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: var(--gold);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
        }

        .sidebar-user-name {
            font-size: 13px;
            font-weight: 500;
            color: #fff;
            line-height: 1.2;
        }

        .sidebar-user-role {
            font-size: 11px;
            color: rgba(255, 255, 255, .4);
        }

        .sidebar-logout {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 8px;
            padding: 9px 12px;
            border-radius: 8px;
            color: rgba(255, 255, 255, .5);
            font-size: 13px;
            text-decoration: none;
            transition: all .2s;
        }

        .sidebar-logout:hover {
            background: rgba(255, 255, 255, .06);
            color: rgba(255, 255, 255, .8);
        }

        /* ── Main area ─────────────────────────────────────────────────── */
        .main-wrap {
            margin-left: var(--sidebar-w);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* ── Topbar ────────────────────────────────────────────────────── */
        .topbar {
            height: var(--topbar-h);
            background: var(--white);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            padding: 0 28px;
            position: sticky;
            top: 0;
            z-index: 50;
            gap: 16px;
        }

        .topbar-toggle {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            color: var(--navy);
            padding: 4px;
        }

        .topbar-breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--muted);
        }

        .topbar-breadcrumb .current {
            color: var(--navy);
            font-weight: 500;
        }

        .topbar-right {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .topbar-btn {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: var(--surface);
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--muted);
            transition: all .2s;
            position: relative;
        }

        .topbar-btn:hover {
            background: var(--navy);
            color: #fff;
            border-color: var(--navy);
        }

        .notif-dot {
            position: absolute;
            top: 6px;
            right: 6px;
            width: 8px;
            height: 8px;
            background: var(--gold);
            border-radius: 50%;
            border: 2px solid var(--white);
        }

        /* ── Page Content ──────────────────────────────────────────────── */
        .page-content {
            flex: 1;
            padding: 28px 32px;
        }

        /* ── Flash Messages ────────────────────────────────────────────── */
        .flash {
            padding: 13px 18px;
            border-radius: var(--radius);
            margin-bottom: 20px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .flash-success {
            background: var(--success-bg);
            color: var(--success);
            border-left: 3px solid var(--success);
        }

        .flash-error {
            background: var(--danger-bg);
            color: var(--danger);
            border-left: 3px solid var(--danger);
        }

        /* ── Welcome Banner ────────────────────────────────────────────── */
        .welcome-banner {
            background: linear-gradient(135deg, var(--navy) 0%, var(--navy-light) 100%);
            border-radius: 14px;
            padding: 28px 32px;
            margin-bottom: 28px;
            position: relative;
            overflow: hidden;
        }

        .welcome-banner::after {
            content: 'T';
            font-family: var(--font-serif);
            font-size: 200px;
            font-weight: 700;
            color: rgba(255, 255, 255, .04);
            position: absolute;
            right: -20px;
            bottom: -40px;
            line-height: 1;
            pointer-events: none;
        }

        .welcome-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            position: relative;
            z-index: 1;
        }

        .welcome-sub {
            font-size: 13px;
            color: rgba(255, 255, 255, .6);
            margin-bottom: 4px;
        }

        .welcome-name {
            font-family: var(--font-serif);
            font-size: 30px;
            font-weight: 600;
            color: #fff;
            line-height: 1.1;
        }

        .welcome-tagline {
            font-size: 13px;
            color: rgba(255, 255, 255, .55);
            margin-top: 6px;
        }

        /* ── Gold Button ───────────────────────────────────────────────── */
        .btn-gold-lg {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--gold);
            color: #fff;
            padding: 12px 22px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            white-space: nowrap;
            transition: background .2s;
            border: none;
            cursor: pointer;
        }

        .btn-gold-lg:hover {
            background: var(--gold-light);
            color: #fff;
        }

        .btn-navy {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--navy);
            color: #fff;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            transition: background .2s;
            border: none;
            cursor: pointer;
        }

        .btn-navy:hover {
            background: var(--navy-light);
            color: #fff;
        }

        .btn-outline {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: transparent;
            color: var(--navy);
            padding: 9px 18px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            border: 1.5px solid var(--border);
            transition: all .2s;
            cursor: pointer;
        }

        .btn-outline:hover {
            border-color: var(--navy);
            background: var(--navy);
            color: #fff;
        }

        .btn-danger {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--danger-bg);
            color: var(--danger);
            padding: 9px 18px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            border: 1.5px solid transparent;
            transition: all .2s;
            cursor: pointer;
        }

        .btn-danger:hover {
            background: var(--danger);
            color: #fff;
        }

        /* ── Stat Cards ────────────────────────────────────────────────── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: var(--white);
            border-radius: var(--radius);
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .stat-navy .stat-icon {
            background: #eef0f9;
            color: var(--navy);
        }

        .stat-gold .stat-icon {
            background: var(--gold-pale);
            color: var(--gold);
        }

        .stat-amber .stat-icon {
            background: var(--warning-bg);
            color: var(--warning);
        }

        .stat-green .stat-icon {
            background: var(--success-bg);
            color: var(--success);
        }

        .stat-label {
            font-size: 12px;
            color: var(--muted);
            font-weight: 500;
            display: block;
        }

        .stat-value {
            font-size: 28px;
            font-weight: 600;
            color: var(--navy);
            font-family: var(--font-serif);
            line-height: 1.2;
        }

        /* ── Two-col layout ────────────────────────────────────────────── */
        .dash-two-col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        /* ── Panel ─────────────────────────────────────────────────────── */
        .panel {
            background: var(--white);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        .panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 22px;
            border-bottom: 1px solid var(--border);
        }

        .panel-title {
            display: flex;
            align-items: center;
            gap: 9px;
            font-size: 15px;
            font-weight: 600;
            color: var(--navy);
        }

        .panel-link {
            font-size: 13px;
            color: var(--gold);
            text-decoration: none;
            font-weight: 500;
        }

        .panel-link:hover {
            text-decoration: underline;
        }

        .panel-body {
            padding: 20px 22px;
        }

        /* ── Order rows ────────────────────────────────────────────────── */
        .order-row {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 22px;
            border-bottom: 1px solid var(--border);
            transition: background .15s;
        }

        .order-row:last-child {
            border-bottom: none;
        }

        .order-row:hover {
            background: var(--surface);
        }

        .order-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--navy);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .order-info {
            flex: 1;
            min-width: 0;
        }

        .order-user {
            font-size: 14px;
            font-weight: 500;
            color: var(--text);
            line-height: 1.3;
        }

        .order-design {
            font-size: 12px;
            color: var(--muted);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .order-meta {
            text-align: right;
            flex-shrink: 0;
        }

        .order-date {
            font-size: 11px;
            color: var(--muted);
            margin-top: 4px;
            display: block;
        }

        /* ── Status Badges ─────────────────────────────────────────────── */
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: capitalize;
            letter-spacing: .03em;
        }

        .status-pending {
            background: var(--warning-bg);
            color: var(--warning);
        }

        .status-in_progress {
            background: var(--info-bg);
            color: var(--info);
        }

        .status-completed {
            background: var(--success-bg);
            color: var(--success);
        }

        .status-cancelled {
            background: var(--danger-bg);
            color: var(--danger);
        }

        .status-active {
            background: var(--success-bg);
            color: var(--success);
        }

        .status-draft {
            background: #f1f3f8;
            color: var(--muted);
        }

        /* ── Design mini-grid ──────────────────────────────────────────── */
        .design-mini-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
            padding: 16px 22px;
        }

        .design-mini-card {
            text-decoration: none;
            color: inherit;
            display: block;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid var(--border);
            transition: box-shadow .2s, transform .2s;
        }

        .design-mini-card:hover {
            box-shadow: var(--shadow);
            transform: translateY(-2px);
        }

        .design-mini-thumb {
            height: 110px;
            background: var(--surface) center/cover no-repeat;
            position: relative;
        }

        .design-mini-status {
            position: absolute;
            top: 8px;
            left: 8px;
        }

        .design-mini-body {
            padding: 10px 12px;
        }

        .design-mini-title {
            font-size: 13px;
            font-weight: 500;
            color: var(--navy);
            line-height: 1.3;
            margin-bottom: 3px;
        }

        .design-mini-price {
            font-size: 12px;
            color: var(--gold);
            font-weight: 600;
        }

        /* ── Empty state ───────────────────────────────────────────────── */
        .empty-state-sm {
            padding: 28px;
            text-align: center;
            color: var(--muted);
            font-size: 14px;
        }

        .empty-state-sm a {
            color: var(--gold);
        }

        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 60px 20px;
            text-align: center;
        }

        .empty-state-icon {
            width: 64px;
            height: 64px;
            background: var(--surface);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
            color: var(--muted);
        }

        .empty-state h3 {
            font-size: 17px;
            font-weight: 600;
            color: var(--navy);
            margin-bottom: 6px;
        }

        .empty-state p {
            font-size: 14px;
            color: var(--muted);
            max-width: 320px;
            margin-bottom: 20px;
        }

        /* ── Page header (inner pages) ─────────────────────────────────── */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .page-header h1 {
            font-family: var(--font-serif);
            font-size: 26px;
            font-weight: 600;
            color: var(--navy);
        }

        .page-header p {
            font-size: 13px;
            color: var(--muted);
            margin-top: 4px;
        }

        /* ── Design Cards Grid ─────────────────────────────────────────── */
        .design-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .design-card {
            background: var(--white);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            transition: box-shadow .2s, transform .2s;
        }

        .design-card:hover {
            box-shadow: var(--shadow);
            transform: translateY(-3px);
        }

        .design-thumb {
            height: 180px;
            background: var(--surface) center/cover no-repeat;
            position: relative;
        }

        .design-thumb-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(25, 38, 93, .5) 0%, transparent 60%);
        }

        .design-thumb-status {
            position: absolute;
            top: 12px;
            right: 12px;
        }

        .design-thumb-actions {
            position: absolute;
            bottom: 12px;
            right: 12px;
            display: flex;
            gap: 8px;
            opacity: 0;
            transition: opacity .2s;
        }

        .design-card:hover .design-thumb-actions {
            opacity: 1;
        }

        .design-thumb-btn {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            background: rgba(255, 255, 255, .9);
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: var(--navy);
            font-size: 14px;
            border: none;
            cursor: pointer;
            transition: background .2s;
        }

        .design-thumb-btn:hover {
            background: #fff;
        }

        .design-card-body {
            padding: 16px;
        }

        .design-card-category {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 6px;
        }

        .design-card-title {
            font-size: 15px;
            font-weight: 600;
            color: var(--navy);
            margin-bottom: 8px;
            line-height: 1.3;
        }

        .design-card-specs {
            display: flex;
            gap: 12px;
            margin-bottom: 12px;
        }

        .design-spec {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            color: var(--muted);
        }

        .design-card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 12px;
            border-top: 1px solid var(--border);
        }

        .design-price {
            font-size: 16px;
            font-weight: 700;
            color: var(--navy);
            font-family: var(--font-serif);
        }

        .design-orders-count {
            font-size: 12px;
            color: var(--muted);
        }

        /* ── Table ─────────────────────────────────────────────────────── */
        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            padding: 12px 16px;
            text-align: left;
            font-size: 11px;
            font-weight: 600;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .08em;
            border-bottom: 2px solid var(--border);
            background: var(--surface);
        }

        td {
            padding: 14px 16px;
            font-size: 14px;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover td {
            background: var(--surface);
        }

        /* ── Forms ─────────────────────────────────────────────────────── */
        .form-card {
            background: var(--white);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            padding: 28px;
            box-shadow: var(--shadow-sm);
        }

        .form-section-title {
            font-family: var(--font-serif);
            font-size: 18px;
            font-weight: 600;
            color: var(--navy);
            padding-bottom: 12px;
            border-bottom: 1px solid var(--border);
            margin-bottom: 20px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        .form-grid-3 {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 18px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .form-group.full {
            grid-column: 1/-1;
        }

        label {
            font-size: 13px;
            font-weight: 500;
            color: var(--navy);
        }

        label .req {
            color: var(--gold);
        }

        input[type=text],
        input[type=number],
        input[type=email],
        input[type=tel],
        textarea,
        select {
            width: 100%;
            padding: 10px 14px;
            font-family: var(--font-sans);
            font-size: 14px;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            color: var(--text);
            background: var(--white);
            transition: border-color .2s, box-shadow .2s;
            outline: none;
        }

        input:focus,
        textarea:focus,
        select:focus {
            border-color: var(--navy);
            box-shadow: 0 0 0 3px rgba(25, 38, 93, .08);
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-hint {
            font-size: 12px;
            color: var(--muted);
        }

        .form-error {
            font-size: 12px;
            color: var(--danger);
        }

        .file-upload {
            border: 2px dashed var(--border);
            border-radius: 10px;
            padding: 28px 20px;
            text-align: center;
            cursor: pointer;
            transition: border-color .2s, background .2s;
        }

        .file-upload:hover {
            border-color: var(--navy);
            background: #f5f7fd;
        }

        .file-upload p {
            font-size: 14px;
            color: var(--muted);
            margin-top: 8px;
        }

        .file-upload strong {
            color: var(--navy);
        }

        input[type=file] {
            display: none;
        }

        .features-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .feature-row {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .feature-row input {
            flex: 1;
        }

        .btn-remove-feature {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            border: 1.5px solid var(--border);
            background: none;
            cursor: pointer;
            color: var(--danger);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .btn-remove-feature:hover {
            background: var(--danger-bg);
            border-color: var(--danger);
        }

        .btn-add-feature {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: var(--gold);
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
            font-family: var(--font-sans);
            margin-top: 6px;
        }

        .btn-add-feature:hover {
            text-decoration: underline;
        }

        /* ── Filter bar ────────────────────────────────────────────────── */
        .filter-bar {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 14px 18px;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .filter-bar input,
        .filter-bar select {
            max-width: 200px;
            margin: 0;
        }

        /* ── Order detail ──────────────────────────────────────────────── */
        .order-detail-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid var(--border);
            font-size: 14px;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            color: var(--muted);
            font-weight: 500;
        }

        .detail-value {
            color: var(--text);
            font-weight: 500;
            text-align: right;
        }

        /* ── Tabs ──────────────────────────────────────────────────────── */
        .tabs {
            display: flex;
            gap: 4px;
            border-bottom: 2px solid var(--border);
            margin-bottom: 20px;
        }

        .tab {
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 500;
            color: var(--muted);
            text-decoration: none;
            border-bottom: 2px solid transparent;
            margin-bottom: -2px;
            transition: all .2s;
        }

        .tab:hover {
            color: var(--navy);
        }

        .tab.active {
            color: var(--navy);
            border-bottom-color: var(--gold);
        }

        /* ── Pagination ────────────────────────────────────────────────── */
        .pagination-wrap {
            padding: 16px 22px;
            border-top: 1px solid var(--border);
        }

        /* ── Responsive ────────────────────────────────────────────────── */
        @media (max-width: 1100px) {
            .design-grid {
                grid-template-columns: 1fr 1fr;
            }

            .stats-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 900px) {
            .dash-two-col {
                grid-template-columns: 1fr;
            }

            .order-detail-grid {
                grid-template-columns: 1fr;
            }

            .form-grid,
            .form-grid-3 {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-wrap {
                margin-left: 0;
            }

            .topbar-toggle {
                display: flex;
            }

            .design-grid {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: 1fr 1fr;
            }

            .page-content {
                padding: 18px;
            }

            .welcome-inner {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

    {{-- ── Sidebar ─────────────────────────────────────────────────────────── --}}
    <aside class="sidebar" id="sidebar">
        <a href="{{ route('professional.dashboard') }}" class="sidebar-logo">
            <div class="sidebar-logo-mark">T</div>
            <div class="sidebar-logo-text">
                <span class="sidebar-logo-name">Terra</span>
                <span class="sidebar-logo-role">Professional Portal</span>
            </div>
        </a>

        <nav class="sidebar-nav">
            <span class="nav-section-label">Main</span>

            <a href="{{ route('professional.dashboard') }}"
                class="nav-link {{ request()->routeIs('professional.dashboard') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="3" width="7" height="7" />
                    <rect x="14" y="3" width="7" height="7" />
                    <rect x="3" y="14" width="7" height="7" />
                    <rect x="14" y="14" width="7" height="7" />
                </svg>
                Dashboard
            </a>

            <span class="nav-section-label">Designs</span>

            <a href="{{ route('professional.architectural-designs.index') }}"
                class="nav-link {{ request()->routeIs('professional.architectural-designs.*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                    <polyline points="9 22 9 12 15 12 15 22" />
                </svg>
                My Designs
            </a>

            <a href="{{ route('professional.architectural-designs.create') }}"
                class="nav-link {{ request()->routeIs('professional.architectural-designs.create') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <line x1="12" y1="5" x2="12" y2="19" />
                    <line x1="5" y1="12" x2="19" y2="12" />
                </svg>
                Add New Design
            </a>

            <span class="nav-section-label">Orders</span>

            <a href="{{ route('professional.orders.index') }}"
                class="nav-link {{ request()->routeIs('professional.orders.*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M9 11l3 3L22 4" />
                    <path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11" />
                </svg>
                Inquiries & Orders
                @php $pendingCount = \App\Models\DesignOrder::whereHas('design', fn($q) => $q->where('user_id', auth()->id()))->where('payment_status','pending')->count(); @endphp
                @if($pendingCount > 0)
                <span class="nav-badge">{{ $pendingCount }}</span>
                @endif
            </a>

            <span class="nav-section-label">Account</span>

            <a href="{{ route('professional.profile') }}"
                class="nav-link {{ request()->routeIs('professional.profile') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
                    <circle cx="12" cy="7" r="4" />
                </svg>
                Profile
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="sidebar-user">
                <div class="sidebar-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
                <div>
                    <div class="sidebar-user-name">{{ Auth::user()->name }}</div>
                    <div class="sidebar-user-role">Professional</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-logout" style="background:none;border:none;width:100%;text-align:left;font-family:var(--font-sans);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4" />
                        <polyline points="16 17 21 12 16 7" />
                        <line x1="21" y1="12" x2="9" y2="12" />
                    </svg>
                    Sign Out
                </button>
            </form>
        </div>
    </aside>

    {{-- ── Main Wrapper ─────────────────────────────────────────────────────── --}}
    <div class="main-wrap">

        {{-- Topbar --}}
        <header class="topbar">
            <button class="topbar-toggle" onclick="document.getElementById('sidebar').classList.toggle('open')">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <line x1="3" y1="6" x2="21" y2="6" />
                    <line x1="3" y1="12" x2="21" y2="12" />
                    <line x1="3" y1="18" x2="21" y2="18" />
                </svg>
            </button>
            <div class="topbar-breadcrumb">
                <span>Professional</span>
                <span>›</span>
                <span class="current">@yield('page_title', 'Dashboard')</span>
            </div>
            <div class="topbar-right">
                <a href="{{ route('professional.orders.index') }}" class="topbar-btn" title="Orders">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M18 8h1a4 4 0 010 8h-1" />
                        <path d="M2 8h16v9a4 4 0 01-4 4H6a4 4 0 01-4-4V8z" />
                        <line x1="6" y1="1" x2="6" y2="4" />
                        <line x1="10" y1="1" x2="10" y2="4" />
                        <line x1="14" y1="1" x2="14" y2="4" />
                    </svg>
                    @if(isset($pendingCount) && $pendingCount > 0)<span class="notif-dot"></span>@endif
                </a>
                <a href="{{ route('professional.profile') }}" class="topbar-btn" title="Profile">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                </a>
            </div>
        </header>

        {{-- Page Content --}}
        <main class="page-content">
            @if(session('success'))
            <div class="flash flash-success">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="20 6 9 17 4 12" />
                </svg>
                {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="flash flash-error">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" />
                    <line x1="12" y1="8" x2="12" y2="12" />
                    <line x1="12" y1="16" x2="12.01" y2="16" />
                </svg>
                {{ session('error') }}
            </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
        // Close sidebar on outside click (mobile)
        document.addEventListener('click', function(e) {
            const sidebar = document.getElementById('sidebar');
            if (sidebar.classList.contains('open') && !sidebar.contains(e.target) && !e.target.closest('.topbar-toggle')) {
                sidebar.classList.remove('open');
            }
        });
    </script>

    @stack('scripts')
</body>

</html>