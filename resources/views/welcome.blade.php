<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="PayMonitor empowers lending cooperatives with modern loan management, real-time payment tracking, and branch-level reporting — all in one secure platform.">
    <title>PayMonitor — Modern Lending Management for Cooperatives</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/paymonitor.css', 'resources/css/paymonitor-landing.css', 'resources/js/paymonitor-landing.js'])
</head>
<body>
    <!-- Animated background -->
    <div class="pm-orbs">
        <div class="pm-orb pm-orb--emerald" style="width:600px;height:600px;top:-10%;left:-5%"></div>
        <div class="pm-orb pm-orb--amber" style="width:500px;height:500px;top:20%;right:-10%;animation-delay:-7s"></div>
        <div class="pm-orb pm-orb--indigo" style="width:400px;height:400px;bottom:10%;left:30%;animation-delay:-14s"></div>
    </div>
    <div class="pm-grid-pattern"></div>

    <!-- Navigation -->
    <div class="pm-nav-wrap">
        <nav class="pm-nav" id="mainNav">
            <a href="{{ route('welcome') }}" class="pm-nav-logo">
                <div class="pm-nav-logo-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                    </svg>
                </div>
                PayMonitor
            </a>
            <div class="pm-nav-links">
                <a href="#features" class="pm-nav-link-text">Features</a>
                <a href="#how-it-works" class="pm-nav-link-text">How It Works</a>
                <a href="#pricing" class="pm-nav-link-text">Pricing</a>
                <a href="{{ route('central.login') }}" class="pm-nav-cta">Sign In</a>
            </div>
        </nav>
    </div>

    <!-- Hero -->
    <section class="pm-hero">
        <div class="pm-container">
            <div class="pm-reveal">
                <div class="pm-hero-badge"><span class="pm-pulse-dot"></span> Trusted by Philippine Cooperatives</div>
            </div>
            <h1 class="pm-reveal pm-reveal-d1">
                Lending made<br><span class="pm-gradient-text">simple & powerful</span>
            </h1>
            <p class="pm-hero-sub pm-reveal pm-reveal-d2">
                The all-in-one platform that helps cooperatives manage loans, track payments, and grow — with isolated data per branch and real-time insights.
            </p>
            <div class="pm-hero-actions pm-reveal pm-reveal-d3">
                <a href="{{ route('central.login') }}" class="pm-btn pm-btn--primary">Start Free Trial</a>
                <a href="#features" class="pm-btn pm-btn--ghost">See Features</a>
            </div>

            <!-- Dashboard mockup -->
            <div class="pm-mockup pm-reveal pm-reveal-d4">
                <div class="pm-mockup-topbar">
                    <div class="pm-mockup-dot pm-mockup-dot--r"></div>
                    <div class="pm-mockup-dot pm-mockup-dot--y"></div>
                    <div class="pm-mockup-dot pm-mockup-dot--g"></div>
                    <span style="margin-left:auto;font-size:12px;color:var(--pm-text-muted)">PayMonitor Dashboard</span>
                </div>
                <div class="pm-mockup-grid">
                    <div class="pm-mockup-stat">
                        <div class="pm-mockup-stat-label">Active Loans</div>
                        <div class="pm-mockup-stat-value">1,247</div>
                        <div class="pm-mockup-stat-change up">↑ 12.5%</div>
                    </div>
                    <div class="pm-mockup-stat">
                        <div class="pm-mockup-stat-label">Collections</div>
                        <div class="pm-mockup-stat-value">₱2.8M</div>
                        <div class="pm-mockup-stat-change up">↑ 8.3%</div>
                    </div>
                    <div class="pm-mockup-stat">
                        <div class="pm-mockup-stat-label">Members</div>
                        <div class="pm-mockup-stat-value">3,842</div>
                        <div class="pm-mockup-stat-change up">↑ 5.1%</div>
                    </div>
                    <div class="pm-mockup-stat">
                        <div class="pm-mockup-stat-label">Overdue</div>
                        <div class="pm-mockup-stat-value">23</div>
                        <div class="pm-mockup-stat-change down">↓ 3.2%</div>
                    </div>
                    <div class="pm-mockup-chart">
                        <div class="pm-mockup-bar" style="height:45%"></div>
                        <div class="pm-mockup-bar" style="height:62%;animation-delay:.1s"></div>
                        <div class="pm-mockup-bar" style="height:38%;animation-delay:.2s"></div>
                        <div class="pm-mockup-bar" style="height:75%;animation-delay:.3s"></div>
                        <div class="pm-mockup-bar" style="height:55%;animation-delay:.4s"></div>
                        <div class="pm-mockup-bar" style="height:88%;animation-delay:.5s"></div>
                        <div class="pm-mockup-bar" style="height:70%;animation-delay:.6s"></div>
                        <div class="pm-mockup-bar" style="height:92%;animation-delay:.7s"></div>
                        <div class="pm-mockup-bar" style="height:65%;animation-delay:.8s"></div>
                        <div class="pm-mockup-bar" style="height:82%;animation-delay:.9s"></div>
                        <div class="pm-mockup-bar" style="height:78%;animation-delay:1s"></div>
                        <div class="pm-mockup-bar" style="height:95%;animation-delay:1.1s"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Social proof stats -->
    <section class="pm-social-proof">
        <div class="pm-social-proof-inner">
            <div class="pm-sp-item pm-reveal">
                <div class="pm-sp-number">500+</div>
                <div class="pm-sp-label">Cooperatives</div>
            </div>
            <div class="pm-sp-item pm-reveal pm-reveal-d1">
                <div class="pm-sp-number">₱2M+</div>
                <div class="pm-sp-label">Loans Managed</div>
            </div>
            <div class="pm-sp-item pm-reveal pm-reveal-d2">
                <div class="pm-sp-number">99.9%</div>
                <div class="pm-sp-label">Uptime</div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="pm-section" id="features">
        <div class="pm-container">
            <div class="pm-section-label pm-reveal">Features</div>
            <h2 class="pm-section-title pm-reveal pm-reveal-d1">Everything your cooperative needs to thrive</h2>
            <p class="pm-section-desc pm-reveal pm-reveal-d2">Purpose-built tools for lending cooperatives — from loan origination to branch-level analytics.</p>

            <div class="pm-features-grid">
                <div class="pm-card pm-reveal">
                    <div class="pm-icon pm-icon--emerald">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                    </div>
                    <h3 style="font-family:var(--pm-font-heading);font-size:18px;font-weight:700;color:#fff;margin-bottom:10px">Loan Management</h3>
                    <p style="font-size:14px;color:var(--pm-text-secondary);line-height:1.7">Create and track loans with automatic computation for flat & diminishing interest, plus full amortization schedules.</p>
                </div>
                <div class="pm-card pm-reveal pm-reveal-d1">
                    <div class="pm-icon pm-icon--amber">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3.75 3.75v16.5h16.5M7.5 15.75l3-3 2.25 2.25 4.5-6"/></svg>
                    </div>
                    <h3 style="font-family:var(--pm-font-heading);font-size:18px;font-weight:700;color:#fff;margin-bottom:10px">Real-Time Collections</h3>
                    <p style="font-size:14px;color:var(--pm-text-secondary);line-height:1.7">Record payments instantly, sync amortization schedules, and monitor outstanding balances with concurrency-safe processing.</p>
                </div>
                <div class="pm-card pm-reveal pm-reveal-d2">
                    <div class="pm-icon pm-icon--indigo">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 19.125a7.5 7.5 0 0 1 15 0"/></svg>
                    </div>
                    <h3 style="font-family:var(--pm-font-heading);font-size:18px;font-weight:700;color:#fff;margin-bottom:10px">Member Profiles</h3>
                    <p style="font-size:14px;color:var(--pm-text-secondary);line-height:1.7">Complete borrower profiles with loan history, outstanding balances, and activity tracking across all branches.</p>
                </div>
                <div class="pm-card pm-reveal">
                    <div class="pm-icon pm-icon--amber">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="7" width="18" height="13" rx="2"/><path d="M3 10h18M7 15h2"/></svg>
                    </div>
                    <h3 style="font-family:var(--pm-font-heading);font-size:18px;font-weight:700;color:#fff;margin-bottom:10px">Multi-Branch Support</h3>
                    <p style="font-size:14px;color:var(--pm-text-secondary);line-height:1.7">Manage unlimited branches under one cooperative — each with its own staff, members, and loan portfolio.</p>
                </div>
                <div class="pm-card pm-reveal pm-reveal-d1">
                    <div class="pm-icon pm-icon--emerald">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0 1 12 2.944a11.955 11.955 0 0 1-8.618 3.04A12.02 12.02 0 0 0 3 12c0 4.418 2.865 8.166 6.839 9.489.403.13.823.199 1.249.249M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                    </div>
                    <h3 style="font-family:var(--pm-font-heading);font-size:18px;font-weight:700;color:#fff;margin-bottom:10px">Role-Based Security</h3>
                    <p style="font-size:14px;color:var(--pm-text-secondary);line-height:1.7">Five granular roles from admin to viewer — each staff member sees only what they need.</p>
                </div>
                <div class="pm-card pm-reveal pm-reveal-d2">
                    <div class="pm-icon pm-icon--indigo">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="M7 16l4-4 3 3 5-7"/></svg>
                    </div>
                    <h3 style="font-family:var(--pm-font-heading);font-size:18px;font-weight:700;color:#fff;margin-bottom:10px">Reports & Analytics</h3>
                    <p style="font-size:14px;color:var(--pm-text-secondary);line-height:1.7">Collections by month, overdue aging, interest income, top borrowers, and loan breakdowns — ready when you need them.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How it works -->
    <section class="pm-section" id="how-it-works" style="padding-top:40px">
        <div class="pm-container">
            <div style="text-align:center">
                <div class="pm-section-label pm-reveal">How It Works</div>
                <h2 class="pm-section-title pm-reveal pm-reveal-d1" style="max-width:100%;text-align:center;margin:0 auto">Up and running in minutes</h2>
            </div>
            <div class="pm-steps-grid">
                <div class="pm-step pm-reveal">
                    <div class="pm-step-number">1</div>
                    <h3>Subscribe</h3>
                    <p>Pick a plan that fits your cooperative's size. Setup takes less than two minutes.</p>
                </div>
                <div class="pm-step pm-reveal pm-reveal-d2">
                    <div class="pm-step-number">2</div>
                    <h3>Configure</h3>
                    <p>Add your branches, loan types, staff accounts, and import your existing members.</p>
                </div>
                <div class="pm-step pm-reveal pm-reveal-d4">
                    <div class="pm-step-number">3</div>
                    <h3>Go Live</h3>
                    <p>Start processing loans, recording payments, and generating reports immediately.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing -->
    <section class="pm-section" id="pricing">
        <div class="pm-container">
            <div style="text-align:center">
                <div class="pm-section-label pm-reveal">Pricing</div>
                <h2 class="pm-section-title pm-reveal pm-reveal-d1" style="max-width:100%;text-align:center;margin:0 auto">Transparent plans, no surprises</h2>
                <p class="pm-section-desc pm-reveal pm-reveal-d2" style="text-align:center;margin:16px auto 0">Every plan includes full loan management. Scale when you're ready.</p>
            </div>

            <div class="pm-pricing-grid">
                <div class="pm-price-card pm-reveal">
                    <div class="pm-price-name">Basic</div>
                    <div class="pm-price-amount">&#8369;499<span>/mo</span></div>
                    <div class="pm-price-desc">For small cooperatives just getting started.</div>
                    <ul class="pm-price-features">
                        <li><span class="pm-price-check">✓</span> Up to 2 branches</li>
                        <li><span class="pm-price-check">✓</span> Up to 10 staff users</li>
                        <li><span class="pm-price-check">✓</span> Full loan management</li>
                        <li><span class="pm-price-check">✓</span> Payment tracking</li>
                        <li><span class="pm-price-check">✓</span> Email support</li>
                    </ul>
                    <a href="{{ route('central.login') }}" class="pm-btn-price pm-btn-price--ghost">Get Started</a>
                </div>

                <div class="pm-price-card featured pm-reveal pm-reveal-d1">
                    <div class="pm-price-badge">Most Popular</div>
                    <div class="pm-price-name">Standard</div>
                    <div class="pm-price-amount">&#8369;999<span>/mo</span></div>
                    <div class="pm-price-desc">For growing cooperatives with multiple branches.</div>
                    <ul class="pm-price-features">
                        <li><span class="pm-price-check">✓</span> Up to 5 branches</li>
                        <li><span class="pm-price-check">✓</span> Up to 30 staff users</li>
                        <li><span class="pm-price-check">✓</span> Everything in Basic</li>
                        <li><span class="pm-price-check">✓</span> Reports & analytics</li>
                        <li><span class="pm-price-check">✓</span> Priority support</li>
                    </ul>
                    <a href="{{ route('central.login') }}" class="pm-btn-price pm-btn-price--primary">Choose Standard</a>
                </div>

                <div class="pm-price-card pm-reveal pm-reveal-d2">
                    <div class="pm-price-name">Premium</div>
                    <div class="pm-price-amount">&#8369;1,999<span>/mo</span></div>
                    <div class="pm-price-desc">For established cooperatives needing full control.</div>
                    <ul class="pm-price-features">
                        <li><span class="pm-price-check">✓</span> Unlimited branches</li>
                        <li><span class="pm-price-check">✓</span> Unlimited staff users</li>
                        <li><span class="pm-price-check">✓</span> Everything in Standard</li>
                        <li><span class="pm-price-check">✓</span> Full audit logging</li>
                        <li><span class="pm-price-check">✓</span> Dedicated support</li>
                    </ul>
                    <a href="{{ route('central.login') }}" class="pm-btn-price pm-btn-price--ghost">Contact Sales</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Final CTA -->
    <section class="pm-cta">
        <div class="pm-cta-box pm-reveal">
            <h2>Ready to modernize your cooperative?</h2>
            <p>Join hundreds of lending cooperatives already using PayMonitor to streamline operations and grow.</p>
            <a href="{{ route('central.login') }}" class="pm-btn pm-btn--primary" style="position:relative">Get Started Today</a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="pm-footer">
        <div class="pm-footer-inner">
            <div class="pm-footer-brand">PayMonitor <span>Built for cooperatives.</span></div>
            <div class="pm-footer-copy">&copy; 2026 PayMonitor. All rights reserved.</div>
        </div>
    </footer>
</body>
</html>
