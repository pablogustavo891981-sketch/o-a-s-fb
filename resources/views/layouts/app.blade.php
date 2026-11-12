<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Início') | Agendamento e Oferta de Serviços — Fundação Bradesco</title>

    <style>
        :root {
            --vermelho: #CC092F;
            --azul: #91CCE7;
            --amarelo: #F5E583;
            --roxo: #5E50A1;
            --rosa: #ED145B;
            --fundo: #F4F4F4;
            --branco: #FFFFFF;
            --texto: #292929;
            --cinza: #777777;
            --borda: #E5E5E5;
            --verde: #176B35;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: linear-gradient(180deg, #f7f6f8 0%, var(--fundo) 100%);
            color: var(--texto);
            min-height: 100vh;
            font-size: 1rem;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            text-rendering: optimizeLegibility;
        }

        ::selection {
            background: rgba(204, 9, 47, .18);
        }

        a {
            text-decoration: none;
            color: inherit;
            transition: color .2s ease, opacity .2s ease;
        }

        a:hover {
            opacity: 0.96;
        }

        button, input, select, textarea {
            font-family: inherit;
        }

        button, a, input, select, textarea {
            -webkit-tap-highlight-color: transparent;
        }

        :focus-visible {
            outline: 3px solid #5E50A1;
            outline-offset: 3px;
            scroll-margin-top: 120px;
        }

        /* CABEÇALHO */

        .topbar {
            position: sticky;
            top: 0;
            z-index: 20;
            background: linear-gradient(110deg, #CC092F 0%, #A80726 100%);
            min-height: 90px;
            padding: 12px 5%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 3px solid #85051E;
            gap: 20px;
            box-shadow: 0 8px 22px rgba(80, 8, 24, .18);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 13px;
            min-width: 0;
        }

        .foundation-logo {
            display: block;
            width: 150px;
            max-height: 58px;
            padding: 5px 8px;
            border-radius: 8px;
            background: #fff;
            object-fit: contain;
            object-position: left center;
        }

        .logo-mark {
            width: 46px;
            height: 46px;
            display: grid;
            place-items: center;
            flex-shrink: 0;
            border-radius: 13px;
            background: rgba(255, 255, 255, .16);
            color: #fff;
            font-size: 13px;
            font-weight: 800;
            letter-spacing: .03em;
            border: 1px solid rgba(255, 255, 255, .35);
        }

        .logo h1 {
            font-size: 19px;
            color: #fff;
            line-height: 1.3;
        }

        .logo p {
            font-size: 12px;
            color: rgba(255, 255, 255, .86);
            margin-top: 5px;
        }

        .top-user {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-name {
            font-size: 14px;
            font-weight: bold;
            color: #fff;
        }

        .user-role {
            font-size: 11px;
            color: rgba(255, 255, 255, .82);
            text-transform: capitalize;
            margin-top: 3px;
        }

        .logout-button {
            border: 1px solid rgba(255, 255, 255, .75);
            background: rgba(255, 255, 255, .12);
            color: #fff;
            padding: 10px 16px;
            border-radius: 9px;
            cursor: pointer;
            font-weight: bold;
            transition: background .2s ease, color .2s ease, transform .2s ease;
        }

        .logout-button:hover {
            transform: translateY(-1px);
            background: #fff;
            color: var(--vermelho);
        }

        /* ESTRUTURA */

        .layout {
            display: flex;
            min-height: calc(100vh - 145px);
        }

        .sidebar {
            position: sticky;
            top: 90px;
            display: flex;
            width: 270px;
            height: calc(100vh - 90px);
            flex: 0 0 270px;
            flex-direction: column;
            gap: 10px;
            overflow-y: auto;
            padding: 20px 14px 16px;
            border-right: 1px solid #EAE6E7;
            background: linear-gradient(180deg, #fff 0%, #FFFCFC 100%);
            box-shadow: 5px 0 22px rgba(34, 20, 25, .035);
            scrollbar-color: #E6BCC5 transparent;
            scrollbar-width: thin;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 11px;
            margin: 0 3px 8px;
            padding: 12px;
            border: 1px solid #F0E7E9;
            border-radius: 14px;
            background: linear-gradient(135deg, #FFF7F8 0%, #fff 100%);
        }

        .sidebar-brand img {
            display: block;
            width: 42px;
            height: 42px;
            flex: 0 0 42px;
            object-fit: contain;
        }

        .sidebar-logo-fallback {
            display: grid;
            width: 42px;
            height: 42px;
            flex: 0 0 42px;
            place-items: center;
            border-radius: 12px;
            background: linear-gradient(140deg, var(--vermelho), #a80726);
            color: #fff;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: .02em;
            box-shadow: 0 6px 13px rgba(204, 9, 47, .16);
        }

        .sidebar-brand-copy { min-width: 0; }
        .sidebar-brand-copy strong {
            display: block;
            color: #292929;
            font-size: 12px;
            line-height: 1.35;
        }
        .sidebar-brand-copy span {
            display: block;
            margin-top: 3px;
            color: #777;
            font-size: 10px;
            letter-spacing: .07em;
            text-transform: uppercase;
        }

        .sidebar-nav {
            display: grid;
            gap: 2px;
        }

        .sidebar-title {
            color: #888;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            margin: 14px 10px 5px;
            letter-spacing: .06em;
        }

        .menu-link {
            position: relative;
            display: flex;
            min-height: 48px;
            align-items: center;
            gap: 11px;
            padding: 9px 11px;
            border-radius: 10px;
            margin: 0;
            font-size: 14px;
            color: #555;
            transition: transform .18s ease, background .18s ease, color .18s ease, box-shadow .18s ease;
            border: 1px solid transparent;
        }

        .menu-icon {
            display: grid;
            width: 28px;
            height: 28px;
            flex: 0 0 28px;
            place-items: center;
            border-radius: 8px;
            background: #F7F5F6;
            color: #6C6470;
            transition: background .18s ease, color .18s ease, transform .18s ease;
        }

        .menu-icon svg {
            width: 16px;
            height: 16px;
            fill: none;
            stroke: currentColor;
            stroke-linecap: round;
            stroke-linejoin: round;
            stroke-width: 1.7;
        }

        .menu-link:hover,
        .menu-link.active,
        .menu-link[aria-current="page"] {
            background: linear-gradient(135deg, #FCE8ED 0%, #FFF5F7 100%);
            color: var(--vermelho);
            font-weight: bold;
            transform: translateX(3px);
            box-shadow: 0 7px 16px rgba(204, 9, 47, 0.07);
            border-color: rgba(204, 9, 47, 0.08);
        }

        .menu-link:hover .menu-icon,
        .menu-link.active .menu-icon,
        .menu-link[aria-current="page"] .menu-icon {
            transform: scale(1.04);
            background: var(--vermelho);
            color: #fff;
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: auto 3px 0;
            padding: 12px;
            border: 1px solid #EEE8EA;
            border-radius: 13px;
            background: #fff;
        }

        .sidebar-user-avatar {
            display: grid;
            width: 36px;
            height: 36px;
            flex: 0 0 36px;
            place-items: center;
            border-radius: 50%;
            background: #FCECEF;
            color: var(--vermelho);
            font-size: 13px;
            font-weight: 800;
        }

        .sidebar-user-copy { min-width: 0; }
        .sidebar-user-copy strong {
            display: block;
            overflow: hidden;
            color: #333;
            font-size: 12px;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .sidebar-user-copy span {
            display: block;
            margin-top: 3px;
            color: #777;
            font-size: 11px;
        }

        .main-content {
            flex: 1;
            padding: 35px;
            min-width: 0;
            width: 100%;
            max-width: 1600px;
            margin: 0 auto;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin-right: auto;
            margin-left: auto;
            padding-right: 16px;
            padding-left: 16px;
        }

        .row {
            display: grid;
            grid-template-columns: repeat(12, minmax(0, 1fr));
            align-items: start;
            gap: 16px;
        }

        .row > * { min-width: 0; grid-column: span 12; }
        .col-md-2, .col-md-3, .col-md-4, .col-md-6, .col-md-8 { grid-column: span 12; }
        .col-sm-6, .col-lg-4 { grid-column: span 12; }

        .d-flex { display: flex !important; }
        .d-inline-flex { display: inline-flex !important; }
        .d-inline-block { display: inline-block !important; }
        .flex-column { flex-direction: column !important; }
        .flex-wrap { flex-wrap: wrap !important; }
        .flex-fill { flex: 1 1 auto !important; }
        .align-items-start { align-items: flex-start !important; }
        .align-items-center { align-items: center !important; }
        .align-items-end { align-items: flex-end !important; }
        .justify-content-between { justify-content: space-between !important; }
        .justify-content-center { justify-content: center !important; }
        .justify-content-end { justify-content: flex-end !important; }
        .text-center { text-align: center !important; }
        .text-end { text-align: right !important; }
        .text-uppercase { text-transform: uppercase !important; }
        .text-muted { color: #777 !important; }
        .fw-bold { font-weight: 700 !important; }
        .fw-semibold { font-weight: 600 !important; }
        .small { font-size: .875rem !important; }
        .w-100 { width: 100% !important; }
        .h-100 { height: 100% !important; }
        .mt-auto { margin-top: auto !important; }
        .mx-auto { margin-right: auto !important; margin-left: auto !important; }
        .mt-3 { margin-top: 1rem !important; }
        .mt-4 { margin-top: 1.5rem !important; }
        .pt-4 { padding-top: 1.5rem !important; }
        .pb-4 { padding-bottom: 1.5rem !important; }
        .mb-0 { margin-bottom: 0 !important; }
        .mb-1 { margin-bottom: .25rem !important; }
        .mb-2 { margin-bottom: .5rem !important; }
        .mb-3 { margin-bottom: 1rem !important; }
        .mb-4 { margin-bottom: 1.5rem !important; }
        .p-3 { padding: 1rem !important; }
        .p-4 { padding: 1.5rem !important; }
        .py-4 { padding-top: 1.5rem !important; padding-bottom: 1.5rem !important; }
        .gap-2 { gap: .5rem !important; }
        .gap-3 { gap: 1rem !important; }
        .rounded { border-radius: 8px !important; }
        .rounded-4 { border-radius: 16px !important; }
        .rounded-pill { border-radius: 999px !important; }
        .border { border: 1px solid var(--borda) !important; }
        .border-bottom { border-bottom: 1px solid var(--borda) !important; }
        .border-0 { border: 0 !important; }
        .overflow-hidden { overflow: hidden !important; }

        .card {
            min-width: 0;
            border: 1px solid var(--borda);
            border-radius: 14px;
            background: white;
        }

        .card-body { padding: 20px; }
        .shadow-sm { box-shadow: 0 8px 22px rgba(34, 20, 25, .05) !important; }
        .table-responsive { width: 100%; overflow-x: auto; }
        .table { width: 100%; margin-bottom: 0; }
        .table th, .table td { vertical-align: middle; }
        .table-hover tbody tr:hover { background: #FFFAFB; }

        .badge {
            display: inline-block;
            padding: .38em .7em;
            border-radius: 6px;
            font-size: .78rem;
            font-weight: 700;
            line-height: 1;
        }

        .bg-success { background: #DFF5E8 !important; color: #176B35 !important; }
        .bg-secondary { background: #ECECEC !important; color: #555 !important; }
        .text-white { color: #fff !important; }

        .btn-sm { padding: 8px 12px; font-size: 12px; }
        .btn-outline-secondary, .btn-outline-danger {
            border: 1px solid #D7D7D7;
            background: #fff;
            color: #555;
            box-shadow: none;
        }
        .btn-outline-secondary:hover { border-color: var(--roxo); background: #F7F5FC; color: var(--roxo); }
        .btn-outline-danger { border-color: #E8B7C1; color: var(--vermelho); }
        .btn-outline-danger:hover { background: #FCECEF; color: var(--vermelho-escuro); }
        .btn-danger { background: var(--vermelho); color: #fff; }
        .btn-secondary { background: var(--roxo); color: #fff; }
        .btn-secondary:hover { background: #483B88; color: #fff; }

        .form-select {
            width: 100%;
            min-height: 44px;
            padding: 10px 36px 10px 12px;
            border: 1px solid var(--borda);
            border-radius: 7px;
            background-color: white;
            color: var(--texto);
            font-size: 14px;
        }

        .form-label { display: inline-block; margin-bottom: 7px; }
        .text-decoration-none { text-decoration: none !important; }
        .invalid-feedback { display: block; margin-top: 5px; font-size: .85rem; }

        .page-heading {
            margin-bottom: 25px;
        }

        .page-heading h2 {
            font-size: 27px;
            margin-bottom: 7px;
            color: var(--texto);
        }

        .page-heading p {
            color: var(--cinza);
            font-size: 14px;
        }

        /* MENSAGENS */

        .alert {
            padding: 14px 18px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-success {
            background: #DFF5E5;
            color: var(--verde);
        }

        .alert-error {
            background: #FCE2E5;
            color: #A80726;
        }

        .alert-warning {
            background: #FFF4D6;
            color: #805A00;
        }

        .alert-info {
            background: #E5F3FA;
            color: #245B78;
        }

        .validation-errors {
            background: #FCE2E5;
            color: #A80726;
            padding: 15px 30px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .validation-errors ul {
            margin-top: 8px;
            padding-left: 20px;
        }

        /* CARTÕES */

        .content-card {
            background: white;
            border: 1px solid rgba(229, 229, 229, .9);
            border-radius: 14px;
            padding: 25px;
            box-shadow: 0 8px 22px rgba(34, 20, 25, .04);
            margin-bottom: 20px;
            transition: box-shadow .2s ease, transform .2s ease;
        }

        .content-card:hover {
            box-shadow: 0 12px 28px rgba(34, 20, 25, .07);
        }

        /* BOTÕES */

        .btn {
            display: inline-block;
            min-height: 46px;
            align-content: center;
            border: none;
            border-radius: 10px;
            padding: 11px 18px;
            background: var(--vermelho);
            color: white;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            transition: transform .2s ease, box-shadow .2s ease, background .2s ease;
            box-shadow: 0 8px 18px rgba(204, 9, 47, 0.12);
        }

        .btn:hover {
            background: #A80726;
            transform: translateY(-1px);
            box-shadow: 0 12px 24px rgba(204, 9, 47, 0.18);
            color: white;
        }

        .btn-secondary {
            background: var(--roxo);
        }

        .btn-secondary:hover {
            background: #483B88;
        }

        /* FORMULÁRIOS */

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 7px;
            font-size: 14px;
            font-weight: bold;
        }

        .form-control {
            width: 100%;
            min-height: 48px;
            padding: 12px;
            border: 1px solid var(--borda);
            border-radius: 7px;
            font-size: 14px;
            outline: none;
            background: white;
            transition: border-color .2s ease, box-shadow .2s ease;
        }

        .form-control:focus {
            border-color: var(--vermelho);
            box-shadow: 0 0 0 .2rem rgba(204, 9, 47, .1);
        }

        .form-select {
            transition: border-color .2s ease, box-shadow .2s ease;
        }

        .form-select:focus {
            border-color: var(--vermelho);
            box-shadow: 0 0 0 .2rem rgba(204, 9, 47, .1);
        }

        .form-label {
            color: var(--texto);
        }

        .invalid-feedback {
            color: #A80726;
        }

        /* TABELAS */

        .table-container {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            text-align: left;
            padding: 14px;
            border-bottom: 1px solid var(--borda);
            font-size: 14px;
        }

        th {
            background: #FBF7F8;
            color: #555;
            white-space: nowrap;
            font-weight: 700;
        }

        tbody tr {
            transition: background .16s ease;
        }

        tbody tr:hover {
            background: #FFFAFB;
        }

        /* ALERTAS E PAGINAÇÃO */

        .alert {
            position: relative;
            padding: 14px 48px 14px 18px;
            border: 1px solid transparent;
            border-radius: 10px;
            margin-bottom: 18px;
            line-height: 1.5;
        }

        .alert-success {
            background: #EAF6ED;
            border-color: #CBE8D1;
            color: #176B35;
        }

        .alert-error, .alert-danger {
            background: #FFF0F2;
            border-color: #F1C7D0;
            color: #A80726;
        }

        .alert-warning {
            background: #FFF8E5;
            border-color: #F2E0A7;
            color: #755600;
        }

        .alert-info {
            background: #EFF7FB;
            border-color: #CDE5F0;
            color: #245B78;
        }

        .alert-dismiss {
            position: absolute;
            top: 50%;
            right: 12px;
            width: 44px;
            height: 44px;
            display: grid;
            place-items: center;
            transform: translateY(-50%);
            border: 0;
            border-radius: 7px;
            background: transparent;
            color: currentColor;
            font-size: 20px;
            cursor: pointer;
            opacity: .7;
        }

        .alert-dismiss:hover {
            background: rgba(0, 0, 0, .06);
            opacity: 1;
        }

        .btn-close {
            width: 44px;
            height: 44px;
            border: 0;
            border-radius: 7px;
            background: transparent;
            color: currentColor;
            font-size: 0;
            cursor: pointer;
            opacity: .7;
        }

        .btn-close::before {
            content: "×";
            font-size: 22px;
            line-height: 1;
        }

        .alert-dismissible {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .pagination {
            gap: 5px;
            flex-wrap: wrap;
        }

        .pagination .page-link {
            border-color: var(--borda);
            border-radius: 8px !important;
            color: var(--vermelho);
        }

        .pagination .page-link:hover {
            background: #FCECEF;
            border-color: #F1C7D0;
            color: #A80726;
        }

        .pagination .active .page-link {
            background: var(--vermelho);
            border-color: var(--vermelho);
            color: white;
        }

        .pagination .disabled .page-link {
            color: #999;
        }

        .validation-errors {
            border: 1px solid #F1C7D0;
            border-left: 4px solid var(--vermelho);
        }

        .validation-errors li + li {
            margin-top: 5px;
        }

        .error-summary {
            padding: 17px 20px;
            border: 1px solid #F1C7D0;
            border-left: 5px solid var(--vermelho);
            border-radius: 12px;
            margin-bottom: 20px;
            background: #FFF4F6;
            color: #861127;
            box-shadow: 0 8px 18px rgba(130, 18, 42, .06);
        }

        .error-summary h2 {
            margin: 0 0 7px;
            color: #861127;
            font-size: 16px;
        }

        .error-summary p {
            margin: 0 0 8px;
            font-size: 14px;
        }

        .error-summary ul {
            display: grid;
            gap: 5px;
            margin: 0;
            padding-left: 20px;
        }

        .error-summary a {
            color: #861127;
            font-size: 14px;
            font-weight: 600;
            text-decoration: underline;
            text-underline-offset: 2px;
        }

        .error-summary a:hover {
            color: var(--vermelho);
        }

        .skip-link {
            position: fixed;
            top: 8px;
            left: 8px;
            z-index: 1000;
            padding: 12px 16px;
            transform: translateY(-150%);
            border-radius: 8px;
            background: #fff;
            color: #861127;
            font-weight: 700;
            box-shadow: 0 4px 16px rgba(0, 0, 0, .2);
        }

        .skip-link:focus {
            transform: translateY(0);
        }

        .mobile-menu-toggle {
            display: none;
        }

        .error-summary-item-unlinked {
            text-decoration: none !important;
        }

        .field-error-message,
        .invalid-feedback {
            display: block;
            margin-top: 6px;
            color: #A80726;
            font-size: 13px;
            line-height: 1.45;
        }

        .has-validation-error,
        .is-invalid {
            border-color: #CC092F !important;
            box-shadow: 0 0 0 3px rgba(204, 9, 47, .11) !important;
        }

        /* RODAPÉ */

        .footer {
            padding: 20px;
            text-align: center;
            color: var(--cinza);
            font-size: 12px;
            background: white;
            border-top: 1px solid var(--borda);
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                scroll-behavior: auto !important;
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: .01ms !important;
            }
        }

        /* RESPONSIVIDADE */

        @media (max-width: 800px) {
            .layout {
                flex-direction: column;
            }

            .sidebar {
                position: relative;
                top: auto;
                display: block;
                width: 100%;
                height: auto;
                flex: 0 0 auto;
                border-right: none;
                border-bottom: 1px solid var(--borda);
                padding: 12px 14px;
                overflow: hidden;
                box-shadow: 0 5px 14px rgba(34, 20, 25, .03);
            }

            .sidebar-brand,
            .sidebar-user {
                display: none;
            }

            .mobile-menu-toggle {
                display: flex;
                width: 100%;
                min-height: 48px;
                align-items: center;
                justify-content: space-between;
                padding: 10px 12px;
                border: 1px solid #EAE6E7;
                border-radius: 10px;
                background: #fff;
                color: #861127;
                font: inherit;
                font-weight: 700;
                cursor: pointer;
            }

            .sidebar-nav {
                display: grid;
                gap: 4px;
                padding: 10px 0 0;
            }

            .has-js .sidebar:not(.is-open) .sidebar-nav {
                display: none;
            }

            .sidebar-title {
                display: none;
            }

            .menu-link {
                width: 100%;
                margin: 0;
                min-height: 48px;
                gap: 7px;
                padding: 9px 11px;
                font-size: 14px;
            }

            .menu-icon {
                width: 25px;
                height: 25px;
                flex-basis: 25px;
            }

            .main-content {
                padding: 20px;
            }

            .topbar {
                flex-wrap: wrap;
                padding: 15px 4%;
            }

            .logo h1 {
                font-size: 16px;
            }

            .foundation-logo {
                width: 125px;
                max-height: 50px;
                padding: 4px 6px;
            }

            .main-content {
                max-width: none;
            }
        }

        @media (min-width: 576px) {
            .col-sm-6 { grid-column: span 6; }
        }

        @media (min-width: 768px) {
            .col-md-2 { grid-column: span 2; }
            .col-md-3 { grid-column: span 3; }
            .col-md-4 { grid-column: span 4; }
            .col-md-6 { grid-column: span 6; }
            .col-md-8 { grid-column: span 8; }
        }

        @media (min-width: 992px) {
            .col-lg-4 { grid-column: span 4; }
        }

        @media (max-width: 480px) {
            .top-user {
                width: 100%;
                justify-content: space-between;
            }

            .logo {
                gap: 10px;
            }

            .foundation-logo {
                width: 110px;
                max-height: 44px;
                padding: 4px 6px;
            }

            .logo h1 {
                font-size: 14px;
            }

            .logo p {
                font-size: 11px;
            }

            .main-content {
                padding: 15px;
            }

            .content-card {
                padding: 18px;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

<a class="skip-link" href="#conteudo-principal">Pular para o conteúdo principal</a>

<header class="topbar">

    <a href="{{ auth()->check() ? route('dashboard') : url('/') }}" class="logo">
        <img
            src="{{ asset('images/logo-fundacao-bradesco.png') }}"
            alt="Fundação Bradesco"
            class="foundation-logo"
            onerror="this.hidden = true; this.nextElementSibling.hidden = false"
        >
        <span class="logo-mark" aria-hidden="true" hidden>FB</span>

        <div>
            <h1>Agendamento e Oferta de Serviços</h1>
            <p>Fundação Bradesco</p>
        </div>

    </a>

    @auth
        <div class="top-user">

            <div>
                <div class="user-name">{{ auth()->user()?->name }}</div>

                <div class="user-role">
                    @switch(auth()->user()?->tipo_usuario)
                        @case('administrador')
                            Administrador
                            @break

                        @case('prestador')
                            Prestador de serviços
                            @break

                        @default
                            Cliente
                    @endswitch
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-button">Sair</button>
            </form>

        </div>
    @endauth

</header>

@include('components.accessibility-controls')

<div class="layout">

    @auth

        <aside class="sidebar">
            <div class="sidebar-brand">
                <img
                    src="{{ asset('images/logo-fundacao-bradesco.png') }}"
                    alt=""
                    onerror="this.hidden = true; this.nextElementSibling.hidden = false"
                >
                <span class="sidebar-logo-fallback" aria-hidden="true" hidden>FB</span>
                <span class="sidebar-brand-copy">
                    <strong>Agendamento e Oferta</strong>
                    <span>Fundação Bradesco</span>
                </span>
            </div>

            <button type="button" class="mobile-menu-toggle" id="mobile-menu-toggle" aria-expanded="false" aria-controls="primary-nav">
                <span>Menu principal</span>
                <span aria-hidden="true">☰</span>
            </button>

            <nav class="sidebar-nav" id="primary-nav" aria-label="Navegação principal">
                <div class="sidebar-title">Principal</div>

                <a href="{{ route('dashboard') }}" @class(['menu-link', 'active' => request()->routeIs('dashboard')]) @if(request()->routeIs('dashboard')) aria-current="page" @endif>
                    <span class="menu-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><rect x="3.5" y="3.5" width="7" height="7" rx="1.5"/><rect x="13.5" y="3.5" width="7" height="7" rx="1.5"/><rect x="3.5" y="13.5" width="7" height="7" rx="1.5"/><rect x="13.5" y="13.5" width="7" height="7" rx="1.5"/></svg></span>
                    Painel inicial
                </a>

                <a href="{{ route('anuncios.index') }}" @class(['menu-link', 'active' => request()->routeIs('anuncios.*')]) @if(request()->routeIs('anuncios.*')) aria-current="page" @endif>
                    <span class="menu-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M7 3.5h7l4 4v13H7a2 2 0 0 1-2-2v-13a2 2 0 0 1 2-2Z"/><path d="M14 3.5v5h5M9 13h6M9 17h6"/></svg></span>
                    Mural de anúncios
                </a>

                <a href="{{ route('categorias.index') }}" @class(['menu-link', 'active' => request()->routeIs('categorias.*')]) @if(request()->routeIs('categorias.*')) aria-current="page" @endif>
                    <span class="menu-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M4 5.5h7v7H4zM14 5.5h6v7h-6zM4 15.5h7v5H4zM14 15.5h6v5h-6z"/></svg></span>
                    Categorias
                </a>

                <div class="sidebar-title">Serviços</div>

                <a href="{{ route('servicos.index') }}" @class(['menu-link', 'active' => request()->routeIs('servicos.index', 'servicos.show')]) @if(request()->routeIs('servicos.index', 'servicos.show')) aria-current="page" @endif>
                    <span class="menu-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><rect x="3.5" y="7" width="17" height="13" rx="2"/><path d="M9 7V5.5A1.5 1.5 0 0 1 10.5 4h3A1.5 1.5 0 0 1 15 5.5V7M3.5 12h17M10 12v2h4v-2"/></svg></span>
                    Serviços disponíveis
                </a>

                @if(in_array(auth()->user()?->tipo_usuario, ['prestador', 'administrador']))

                    <a href="{{ route('servicos.create') }}" @class(['menu-link', 'active' => request()->routeIs('servicos.create', 'servicos.edit')]) @if(request()->routeIs('servicos.create', 'servicos.edit')) aria-current="page" @endif>
                        <span class="menu-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="8.5"/><path d="M12 8v8M8 12h8"/></svg></span>
                        Cadastrar serviço
                    </a>

                    <a href="{{ route('disponibilidades.index') }}" @class(['menu-link', 'active' => request()->routeIs('disponibilidades.*')]) @if(request()->routeIs('disponibilidades.*')) aria-current="page" @endif>
                        <span class="menu-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="8.5"/><path d="M12 7v5l3.5 2"/></svg></span>
                        Minhas disponibilidades
                    </a>

                @endif

                <a href="{{ route('agendamentos.index') }}" @class(['menu-link', 'active' => request()->routeIs('agendamentos.*')]) @if(request()->routeIs('agendamentos.*')) aria-current="page" @endif>
                    <span class="menu-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><rect x="4" y="5.5" width="16" height="15" rx="2"/><path d="M8 3.5v4M16 3.5v4M4 10h16M8 14h3M8 17h6"/></svg></span>
                    Agendamentos
                </a>

                <a href="{{ route('avaliacoes.index') }}" @class(['menu-link', 'active' => request()->routeIs('avaliacoes.*')]) @if(request()->routeIs('avaliacoes.*')) aria-current="page" @endif>
                    <span class="menu-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="m12 3.5 2.6 5.3 5.9.9-4.3 4.2 1 5.9-5.2-2.8-5.2 2.8 1-5.9-4.3-4.2 5.9-.9L12 3.5Z"/></svg></span>
                    Avaliações
                </a>

                @if(auth()->user()?->tipo_usuario === 'administrador')

                    <div class="sidebar-title">Administração</div>

                    <a href="{{ route('admin.index') }}" @class(['menu-link', 'active' => request()->routeIs('admin.index')]) @if(request()->routeIs('admin.index')) aria-current="page" @endif>
                        <span class="menu-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M12 3.5 19 6v5.5c0 4.2-2.8 7.5-7 9-4.2-1.5-7-4.8-7-9V6l7-2.5Z"/><path d="m9 12 2 2 4-4"/></svg></span>
                        Painel administrativo
                    </a>

                    <a href="{{ route('admin.usuarios') }}" @class(['menu-link', 'active' => request()->routeIs('admin.usuarios*')]) @if(request()->routeIs('admin.usuarios*')) aria-current="page" @endif>
                        <span class="menu-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><circle cx="9" cy="8" r="3"/><path d="M3.5 19v-1a5.5 5.5 0 0 1 11 0v1h-11ZM16 5.5a3 3 0 0 1 0 5.8M17 14a5 5 0 0 1 3.5 4.8V19h-3"/></svg></span>
                        Usuários
                    </a>

                    <a href="{{ route('admin.anuncios') }}" @class(['menu-link', 'active' => request()->routeIs('admin.anuncios*')]) @if(request()->routeIs('admin.anuncios*')) aria-current="page" @endif>
                        <span class="menu-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M4 10v4h3l8 4V6l-8 4H4ZM15 9l4-2M15 15l4 2M7 14l1.5 5h3L10 15"/></svg></span>
                        Gerenciar anúncios
                    </a>

                    <a href="{{ route('admin.servicos') }}" @class(['menu-link', 'active' => request()->routeIs('admin.servicos*')]) @if(request()->routeIs('admin.servicos*')) aria-current="page" @endif>
                        <span class="menu-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><rect x="3.5" y="7" width="17" height="13" rx="2"/><path d="M9 7V5.5A1.5 1.5 0 0 1 10.5 4h3A1.5 1.5 0 0 1 15 5.5V7M3.5 12h17"/></svg></span>
                        Gerenciar serviços
                    </a>

                    <a href="{{ route('admin.agendamentos') }}" @class(['menu-link', 'active' => request()->routeIs('admin.agendamentos')]) @if(request()->routeIs('admin.agendamentos')) aria-current="page" @endif>
                        <span class="menu-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><rect x="4" y="5.5" width="16" height="15" rx="2"/><path d="M8 3.5v4M16 3.5v4M4 10h16M8 14h3M8 17h6"/></svg></span>
                        Gerenciar agendamentos
                    </a>

                    <a href="{{ route('admin.avaliacoes') }}" @class(['menu-link', 'active' => request()->routeIs('admin.avaliacoes')]) @if(request()->routeIs('admin.avaliacoes')) aria-current="page" @endif>
                        <span class="menu-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="m12 3.5 2.6 5.3 5.9.9-4.3 4.2 1 5.9-5.2-2.8-5.2 2.8 1-5.9-4.3-4.2 5.9-.9L12 3.5Z"/></svg></span>
                        Gerenciar avaliações
                    </a>

                @endif
            </nav>

            <div class="sidebar-user">
                <span class="sidebar-user-avatar" aria-hidden="true">{{ mb_strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}</span>
                <span class="sidebar-user-copy">
                    <strong>{{ auth()->user()->name }}</strong>
                    <span>Conta {{ auth()->user()->tipo_usuario }}</span>
                </span>
            </div>
        </aside>

    @endauth

    <main class="main-content" id="conteudo-principal" tabindex="-1">

        @if(session('success'))
            <div class="alert alert-success" role="status" aria-live="polite">
                {{ session('success') }}
                <button type="button" class="alert-dismiss" aria-label="Fechar mensagem">&times;</button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error" role="alert">
                {{ session('error') }}
                <button type="button" class="alert-dismiss" aria-label="Fechar mensagem">&times;</button>
            </div>
        @endif

        @if(session('warning'))
            <div class="alert alert-warning" role="status">
                {{ session('warning') }}
                <button type="button" class="alert-dismiss" aria-label="Fechar mensagem">&times;</button>
            </div>
        @endif

        @if(session('info'))
            <div class="alert alert-info" role="status">
                {{ session('info') }}
                <button type="button" class="alert-dismiss" aria-label="Fechar mensagem">&times;</button>
            </div>
        @endif

        @if($errors->any())
            <section class="error-summary" role="alert" aria-live="assertive" aria-labelledby="error-summary-title" tabindex="-1">
                <h2 id="error-summary-title">
                    {{ $errors->count() === 1 ? 'Encontramos 1 erro no formulário' : 'Encontramos '.$errors->count().' erros no formulário' }}
                </h2>
                <p>Clique em uma mensagem para ir diretamente ao campo que precisa de correção.</p>
                <ul>
                    @foreach($errors->getMessages() as $campo => $mensagens)
                        @foreach($mensagens as $mensagem)
                            <li>
                                <a href="#"
                                   data-validation-field="{{ $campo }}"
                                   data-validation-message="{{ $mensagem }}">
                                    {{ $mensagem }}
                                </a>
                            </li>
                        @endforeach
                    @endforeach
                </ul>
            </section>
        @endif

        @yield('content')

    </main>

</div>

<footer class="footer">
    Agendamento e Oferta de Serviços — Fundação Bradesco
</footer>

@stack('scripts')
@include('components.validation-enhancement')
<script>
    document.documentElement.classList.add('has-js');

    const menuToggle = document.getElementById('mobile-menu-toggle');
    const menuPrincipal = document.getElementById('primary-nav');

    if (menuToggle && menuPrincipal) {
        function fecharMenu() {
            menuToggle.setAttribute('aria-expanded', 'false');
            menuToggle.querySelector('span').textContent = 'Menu principal';
            menuToggle.parentElement.classList.remove('is-open');
        }

        menuToggle.addEventListener('click', function () {
            const aberto = menuToggle.getAttribute('aria-expanded') !== 'true';
            menuToggle.setAttribute('aria-expanded', aberto ? 'true' : 'false');
            menuToggle.querySelector('span').textContent = aberto ? 'Fechar menu' : 'Menu principal';
            menuToggle.parentElement.classList.toggle('is-open', aberto);

            if (aberto) {
                menuPrincipal.querySelector('a')?.focus();
            }
        });

        menuPrincipal.addEventListener('click', function (event) {
            if (event.target.closest('a')) {
                fecharMenu();
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && menuToggle.getAttribute('aria-expanded') === 'true') {
                fecharMenu();
                menuToggle.focus();
            }
        });
    }

    document.addEventListener('click', function (event) {
        const closeButton = event.target.closest('.alert-dismiss, .btn-close[data-bs-dismiss="alert"]');

        if (closeButton) {
            closeButton.closest('.alert')?.remove();
        }
    });
</script>

</body>
</html>
