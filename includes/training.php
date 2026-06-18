<?php
	/**
	 * Website Guide – Admin page under Tools menu
	 * Paste this into your theme's functions.php
	 */
	
	add_action( 'admin_menu', 'svwg_add_admin_page' );
	function svwg_add_admin_page() {
		add_management_page(
			'Website Guide',   // Page <title>
			'Website Guide',   // Menu label
			'manage_options',  // Capability required
			'website-guide',   // URL slug: /wp-admin/tools.php?page=website-guide
			'svwg_render_page' // Callback
		);
	}
	
	function svwg_render_page() {
		?>
		<div class="wrap">
			<div id="svwg-page">
				
				<style>
                    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

                    #svwg-page {
                        --svwg-blue: #3858e9;
                        --svwg-blue-dark: #2145e6;
                        --svwg-blue-light: #eef0fd;
                        --svwg-gray-50: #f9f9f9;
                        --svwg-gray-100: #f0f0f1;
                        --svwg-gray-200: #dcdcde;
                        --svwg-gray-400: #8c8f94;
                        --svwg-gray-700: #3c434a;
                        --svwg-gray-900: #1e1e1e;
                        --svwg-white: #ffffff;
                        --svwg-radius: 8px;
                        --svwg-shadow: 0 1px 3px rgba(0,0,0,0.08), 0 1px 2px rgba(0,0,0,0.06);
                        --svwg-shadow-md: 0 4px 12px rgba(0,0,0,0.1), 0 2px 4px rgba(0,0,0,0.06);
                        --svwg-transition: 220ms ease;
                        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
                        color: var(--svwg-gray-900);
                        line-height: 1.6;
                        max-width: 860px;
                        padding-bottom: 60px;
                    }

                    /* ── Page header ── */
                    #svwg-page .svwg-page-header {
                        background: var(--svwg-white);
                        border: 1px solid var(--svwg-gray-200);
                        border-radius: var(--svwg-radius);
                        padding: 40px 32px 36px;
                        text-align: center;
                        margin-bottom: 28px;
                        box-shadow: var(--svwg-shadow);
                    }
                    #svwg-page .svwg-badge {
                        display: inline-flex;
                        align-items: center;
                        gap: 6px;
                        background: var(--svwg-blue-light);
                        color: var(--svwg-blue);
                        font-size: 12px;
                        font-weight: 600;
                        letter-spacing: 0.04em;
                        text-transform: uppercase;
                        padding: 4px 12px;
                        border-radius: 100px;
                        margin-bottom: 14px;
                    }
                    #svwg-page .svwg-badge svg { width: 13px; height: 13px; fill: var(--svwg-blue); }
                    #svwg-page .svwg-page-header h1 {
                        font-size: clamp(1.6rem, 3vw, 2.2rem);
                        font-weight: 700;
                        letter-spacing: -0.02em;
                        color: var(--svwg-gray-900);
                        line-height: 1.2;
                        margin: 0 0 10px;
                        padding: 0;
                        border: none;
                    }
                    #svwg-page .svwg-page-header p {
                        color: var(--svwg-gray-400);
                        font-size: 15px;
                        margin: 0;
                    }

                    /* ── Toolbar ── */
                    #svwg-page .svwg-toolbar {
                        display: flex;
                        align-items: center;
                        justify-content: space-between;
                        margin-bottom: 16px;
                    }
                    #svwg-page .svwg-count {
                        font-size: 13px;
                        color: var(--svwg-gray-400);
                        font-weight: 500;
                    }
                    #svwg-page .svwg-expand-btn {
                        background: var(--svwg-white);
                        border: 1px solid var(--svwg-gray-200);
                        border-radius: 6px;
                        padding: 5px 14px;
                        font-size: 13px;
                        font-weight: 500;
                        color: var(--svwg-gray-700);
                        cursor: pointer;
                        font-family: inherit;
                        transition: background var(--svwg-transition), border-color var(--svwg-transition);
                    }
                    #svwg-page .svwg-expand-btn:hover {
                        background: var(--svwg-gray-100);
                        border-color: var(--svwg-gray-400);
                    }

                    /* ── Accordion group ── */
                    #svwg-page .svwg-accordion-group { display: flex; flex-direction: column; gap: 8px; }

                    #svwg-page .svwg-card {
                        background: var(--svwg-white);
                        border: 1px solid var(--svwg-gray-200);
                        border-radius: var(--svwg-radius);
                        box-shadow: var(--svwg-shadow);
                        overflow: hidden;
                        transition: box-shadow var(--svwg-transition);
                    }
                    #svwg-page .svwg-card:hover { box-shadow: var(--svwg-shadow-md); }
                    #svwg-page .svwg-card.is-open {
                        border-color: var(--svwg-blue);
                        box-shadow: 0 0 0 1px var(--svwg-blue), var(--svwg-shadow-md);
                    }

                    #svwg-page .svwg-trigger {
                        width: 100%;
                        background: none;
                        border: none;
                        padding: 16px 20px;
                        display: flex;
                        align-items: center;
                        gap: 14px;
                        cursor: pointer;
                        text-align: left;
                        font-family: inherit;
                        transition: background var(--svwg-transition);
                    }
                    #svwg-page .svwg-trigger:hover { background: var(--svwg-gray-50); }
                    #svwg-page .svwg-card.is-open .svwg-trigger { background: var(--svwg-blue-light); }

                    #svwg-page .svwg-icon {
                        flex-shrink: 0;
                        width: 32px; height: 32px;
                        border-radius: 6px;
                        background: var(--svwg-blue-light);
                        display: flex;
                        align-items: center;
                        justify-content: center;
                    }
                    #svwg-page .svwg-card.is-open .svwg-icon { background: var(--svwg-blue); }
                    #svwg-page .svwg-icon svg { width: 16px; height: 16px; fill: var(--svwg-blue); }
                    #svwg-page .svwg-card.is-open .svwg-icon svg { fill: var(--svwg-white); }

                    #svwg-page .svwg-label {
                        flex: 1;
                        font-size: 15px;
                        font-weight: 600;
                        color: var(--svwg-gray-900);
                        letter-spacing: -0.01em;
                    }
                    #svwg-page .svwg-card.is-open .svwg-label { color: var(--svwg-blue-dark); }

                    #svwg-page .svwg-chevron {
                        flex-shrink: 0;
                        width: 18px; height: 18px;
                        fill: var(--svwg-gray-400);
                        transition: transform var(--svwg-transition);
                    }
                    #svwg-page .svwg-card.is-open .svwg-chevron { transform: rotate(180deg); fill: var(--svwg-blue); }

                    #svwg-page .svwg-child-badge {
                        font-size: 11px;
                        font-weight: 600;
                        background: var(--svwg-gray-100);
                        color: var(--svwg-gray-400);
                        padding: 2px 8px;
                        border-radius: 100px;
                        flex-shrink: 0;
                    }
                    #svwg-page .svwg-card.is-open .svwg-child-badge {
                        background: var(--svwg-blue-light);
                        color: var(--svwg-blue);
                    }

                    /* ── Accordion body ── */
                    #svwg-page .svwg-body {
                        display: grid;
                        grid-template-rows: 0fr;
                        transition: grid-template-rows 260ms ease;
                    }
                    #svwg-page .svwg-body-inner { overflow: hidden; }
                    #svwg-page .svwg-card.is-open .svwg-body { grid-template-rows: 1fr; }
                    #svwg-page .svwg-content { padding: 0 20px 20px; }

                    /* ── Sub-accordion ── */
                    #svwg-page .svwg-sub-group { display: flex; flex-direction: column; gap: 6px; margin-top: 16px; }
                    #svwg-page .svwg-sub-label {
                        font-size: 12px;
                        font-weight: 600;
                        text-transform: uppercase;
                        letter-spacing: 0.06em;
                        color: var(--svwg-gray-400);
                        margin-bottom: 4px;
                    }
                    #svwg-page .svwg-sub-card {
                        background: var(--svwg-gray-50);
                        border: 1px solid var(--svwg-gray-200);
                        border-radius: 6px;
                        overflow: hidden;
                        transition: box-shadow var(--svwg-transition);
                    }
                    #svwg-page .svwg-sub-card:hover { box-shadow: var(--svwg-shadow); }
                    #svwg-page .svwg-sub-card.is-open { border-color: var(--svwg-blue); background: #fff; }

                    #svwg-page .svwg-sub-trigger {
                        width: 100%;
                        background: none;
                        border: none;
                        padding: 12px 16px;
                        display: flex;
                        align-items: center;
                        gap: 10px;
                        cursor: pointer;
                        text-align: left;
                        font-family: inherit;
                    }
                    #svwg-page .svwg-sub-dot {
                        flex-shrink: 0;
                        width: 6px; height: 6px;
                        border-radius: 50%;
                        background: var(--svwg-gray-200);
                    }
                    #svwg-page .svwg-sub-card.is-open .svwg-sub-dot { background: var(--svwg-blue); }
                    #svwg-page .svwg-sub-lbl {
                        flex: 1;
                        font-size: 14px;
                        font-weight: 500;
                        color: var(--svwg-gray-700);
                    }
                    #svwg-page .svwg-sub-card.is-open .svwg-sub-lbl { color: var(--svwg-blue-dark); font-weight: 600; }
                    #svwg-page .svwg-sub-chev {
                        flex-shrink: 0;
                        width: 14px; height: 14px;
                        fill: var(--svwg-gray-400);
                        transition: transform var(--svwg-transition);
                    }
                    #svwg-page .svwg-sub-card.is-open .svwg-sub-chev { transform: rotate(180deg); fill: var(--svwg-blue); }

                    #svwg-page .svwg-sub-body {
                        display: grid;
                        grid-template-rows: 0fr;
                        transition: grid-template-rows 240ms ease;
                    }
                    #svwg-page .svwg-sub-body-inner { overflow: hidden; }
                    #svwg-page .svwg-sub-card.is-open .svwg-sub-body { grid-template-rows: 1fr; }
                    #svwg-page .svwg-sub-content { padding: 0 16px 16px; }

                    /* ── Video spinner ── */
                    #svwg-page .svwg-video-wrap {
                        background: #1a1a2e;
                        border-radius: 6px;
                    }
                    #svwg-page .svwg-spinner {
                        position: absolute;
                        inset: 0;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        background: #1a1a2e;
                        border-radius: 6px;
                        pointer-events: none;
                    }
                    #svwg-page .svwg-spinner::after {
                        content: '';
                        width: 38px; height: 38px;
                        border: 3px solid rgba(255,255,255,0.1);
                        border-top-color: var(--svwg-blue);
                        border-radius: 50%;
                        animation: svwg-spin 0.75s linear infinite;
                    }
                    @keyframes svwg-spin { to { transform: rotate(360deg); } }

                    @media (max-width: 600px) {
                        #svwg-page .svwg-trigger { padding: 14px 16px; }
                        #svwg-page .svwg-content { padding: 0 16px 16px; }
                    }
				</style>
				
				<!-- ── Page header ── -->
				<div class="svwg-page-header">
					<div class="svwg-badge">
						<svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/></svg>
						Training Videos
					</div>
					<h1>Spencer Vandam Website Guide</h1>
					<p>Step-by-step video walkthroughs for managing your WordPress website.</p>
				</div>
				
				<!-- ── Toolbar ── -->
				<div class="svwg-toolbar">
					<span class="svwg-count">8 sections &middot; 31 videos</span>
					<button class="svwg-expand-btn" id="svwgExpandBtn">Expand all</button>
				</div>
				
				<!-- ── Accordion list ── -->
				<div class="svwg-accordion-group" id="svwgGroup">
					
					<!-- 1. Theme Settings Overview & Editing Menus -->
					<div class="svwg-card" data-svwg-accordion>
						<button class="svwg-trigger" aria-expanded="false">
							<span class="svwg-icon"><svg viewBox="0 0 24 24"><path d="M19.14 12.94c.04-.3.06-.61.06-.94 0-.32-.02-.64-.07-.94l2.03-1.58a.49.49 0 0 0 .12-.61l-1.92-3.32a.49.49 0 0 0-.59-.22l-2.39.96a7.01 7.01 0 0 0-1.62-.94l-.36-2.54a.484.484 0 0 0-.48-.41h-3.84c-.24 0-.43.17-.47.41l-.36 2.54c-.59.24-1.13.57-1.62.94l-2.39-.96a.47.47 0 0 0-.59.22L2.74 8.87a.47.47 0 0 0 .12.61l2.03 1.58c-.05.3-.07.63-.07.94s.02.64.07.94l-2.03 1.58a.49.49 0 0 0-.12.61l1.92 3.32c.12.22.37.29.59.22l2.39-.96c.5.38 1.03.7 1.62.94l.36 2.54c.05.24.24.41.48.41h3.84c.24 0 .44-.17.47-.41l.36-2.54c.59-.24 1.13-.56 1.62-.94l2.39.96c.22.08.47 0 .59-.22l1.92-3.32a.47.47 0 0 0-.12-.61l-2.01-1.58zM12 15.6c-1.98 0-3.6-1.62-3.6-3.6s1.62-3.6 3.6-3.6 3.6 1.62 3.6 3.6-1.62 3.6-3.6 3.6z"/></svg></span>
							<span class="svwg-label">Theme Settings Overview &amp; Editing Menus</span>
							<svg class="svwg-chevron" viewBox="0 0 24 24"><path d="M7.41 8.59 12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/></svg>
						</button>
						<div class="svwg-body"><div class="svwg-body-inner"><div class="svwg-content">
									<div class="svwg-video-wrap" style="position:relative;padding-bottom:55.27809307604995%;height:0;"><iframe data-src="https://www.loom.com/embed/62ffed32737948e295264f888cca7ab2" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div>
								</div></div></div>
					</div>
					
					<!-- 2. Page Headers & Footer Call to Actions -->
					<div class="svwg-card" data-svwg-accordion>
						<button class="svwg-trigger" aria-expanded="false">
							<span class="svwg-icon"><svg viewBox="0 0 24 24"><path d="M4 6h16v2H4zm0 5h16v2H4zm0 5h16v2H4z"/></svg></span>
							<span class="svwg-label">Page Headers &amp; Footer Call to Actions</span>
							<svg class="svwg-chevron" viewBox="0 0 24 24"><path d="M7.41 8.59 12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/></svg>
						</button>
						<div class="svwg-body"><div class="svwg-body-inner"><div class="svwg-content">
									<div class="svwg-video-wrap" style="position:relative;padding-bottom:55.27809307604995%;height:0;"><iframe data-src="https://www.loom.com/embed/b8f43a082d724f4d9523c867a93bf178" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div>
								</div></div></div>
					</div>
					
					<!-- 3. Using The Flexible Content to Build Pages -->
					<div class="svwg-card" data-svwg-accordion>
						<button class="svwg-trigger" aria-expanded="false">
							<span class="svwg-icon"><svg viewBox="0 0 24 24"><path d="M3 5v14h18V5H3zm2 2h6v4H5V7zm0 6h6v4H5v-4zm14 4h-6v-4h6v4zm0-6h-6V7h6v4z"/></svg></span>
							<span class="svwg-label">Using The Flexible Content to Build Pages</span>
							<span class="svwg-child-badge">19 modules</span>
							<svg class="svwg-chevron" viewBox="0 0 24 24"><path d="M7.41 8.59 12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/></svg>
						</button>
						<div class="svwg-body"><div class="svwg-body-inner"><div class="svwg-content">
									<div class="svwg-video-wrap" style="position:relative;padding-bottom:55.27809307604995%;height:0;"><iframe data-src="https://www.loom.com/embed/03575d7c063b4f8fb2b3bc2752865806" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div>
									<div class="svwg-sub-group">
										<div class="svwg-sub-label">Individual Modules</div>
										
										<div class="svwg-sub-card" data-svwg-sub>
											<button class="svwg-sub-trigger" aria-expanded="false"><span class="svwg-sub-dot"></span><span class="svwg-sub-lbl">Content and Image, 2 Columns</span><svg class="svwg-sub-chev" viewBox="0 0 24 24"><path d="M7.41 8.59 12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/></svg></button>
											<div class="svwg-sub-body"><div class="svwg-sub-body-inner"><div class="svwg-sub-content">
														<div class="svwg-video-wrap" style="position:relative;padding-bottom:55.27809307604995%;height:0;"><iframe data-src="https://www.loom.com/embed/3ff2a3aeac9c4da49fdcaaddd1a5a72c" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div>
													</div></div></div>
										</div>
										
										<div class="svwg-sub-card" data-svwg-sub>
											<button class="svwg-sub-trigger" aria-expanded="false"><span class="svwg-sub-dot"></span><span class="svwg-sub-lbl">FAQs</span><svg class="svwg-sub-chev" viewBox="0 0 24 24"><path d="M7.41 8.59 12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/></svg></button>
											<div class="svwg-sub-body"><div class="svwg-sub-body-inner"><div class="svwg-sub-content">
														<div class="svwg-video-wrap" style="position:relative;padding-bottom:55.27809307604995%;height:0;"><iframe data-src="https://www.loom.com/embed/3037b52304be45009ae773439665b432" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div>
													</div></div></div>
										</div>
										
										<div class="svwg-sub-card" data-svwg-sub>
											<button class="svwg-sub-trigger" aria-expanded="false"><span class="svwg-sub-dot"></span><span class="svwg-sub-lbl">Full Width Content</span><svg class="svwg-sub-chev" viewBox="0 0 24 24"><path d="M7.41 8.59 12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/></svg></button>
											<div class="svwg-sub-body"><div class="svwg-sub-body-inner"><div class="svwg-sub-content">
														<div class="svwg-video-wrap" style="position:relative;padding-bottom:55.27809307604995%;height:0;"><iframe data-src="https://www.loom.com/embed/fa7c22a244794e8c9d7789c546fd43e9" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div>
													</div></div></div>
										</div>
										
										<div class="svwg-sub-card" data-svwg-sub>
											<button class="svwg-sub-trigger" aria-expanded="false"><span class="svwg-sub-dot"></span><span class="svwg-sub-lbl">Full Width Image</span><svg class="svwg-sub-chev" viewBox="0 0 24 24"><path d="M7.41 8.59 12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/></svg></button>
											<div class="svwg-sub-body"><div class="svwg-sub-body-inner"><div class="svwg-sub-content">
														<div class="svwg-video-wrap" style="position:relative;padding-bottom:55.27809307604995%;height:0;"><iframe data-src="https://www.loom.com/embed/a4527ee0e50e44b690460e4fb9af189f" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div>
													</div></div></div>
										</div>
										
										<div class="svwg-sub-card" data-svwg-sub>
											<button class="svwg-sub-trigger" aria-expanded="false"><span class="svwg-sub-dot"></span><span class="svwg-sub-lbl">Full Width Image CTA</span><svg class="svwg-sub-chev" viewBox="0 0 24 24"><path d="M7.41 8.59 12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/></svg></button>
											<div class="svwg-sub-body"><div class="svwg-sub-body-inner"><div class="svwg-sub-content">
														<div class="svwg-video-wrap" style="position:relative;padding-bottom:55.27809307604995%;height:0;"><iframe data-src="https://www.loom.com/embed/b0035377a0b14d1984e2c498d737efc5" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div>
													</div></div></div>
										</div>
										
										<div class="svwg-sub-card" data-svwg-sub>
											<button class="svwg-sub-trigger" aria-expanded="false"><span class="svwg-sub-dot"></span><span class="svwg-sub-lbl">Featured Project</span><svg class="svwg-sub-chev" viewBox="0 0 24 24"><path d="M7.41 8.59 12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/></svg></button>
											<div class="svwg-sub-body"><div class="svwg-sub-body-inner"><div class="svwg-sub-content">
														<div class="svwg-video-wrap" style="position:relative;padding-bottom:55.27809307604995%;height:0;"><iframe data-src="https://www.loom.com/embed/caefb64aa660464786860bb4edcab3c7" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div>
													</div></div></div>
										</div>
										
										<div class="svwg-sub-card" data-svwg-sub>
											<button class="svwg-sub-trigger" aria-expanded="false"><span class="svwg-sub-dot"></span><span class="svwg-sub-lbl">Project Feed</span><svg class="svwg-sub-chev" viewBox="0 0 24 24"><path d="M7.41 8.59 12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/></svg></button>
											<div class="svwg-sub-body"><div class="svwg-sub-body-inner"><div class="svwg-sub-content">
														<div class="svwg-video-wrap" style="position:relative;padding-bottom:55.27809307604995%;height:0;"><iframe data-src="https://www.loom.com/embed/9f5b2c5188f04616956db83a96757c59" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div>
													</div></div></div>
										</div>
										
										<div class="svwg-sub-card" data-svwg-sub>
											<button class="svwg-sub-trigger" aria-expanded="false"><span class="svwg-sub-dot"></span><span class="svwg-sub-lbl">Icon Leaders</span><svg class="svwg-sub-chev" viewBox="0 0 24 24"><path d="M7.41 8.59 12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/></svg></button>
											<div class="svwg-sub-body"><div class="svwg-sub-body-inner"><div class="svwg-sub-content">
														<div class="svwg-video-wrap" style="position:relative;padding-bottom:55.27809307604995%;height:0;"><iframe data-src="https://www.loom.com/embed/760aea1db9464cf4bed48540ca36847a" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div>
													</div></div></div>
										</div>
										
										<div class="svwg-sub-card" data-svwg-sub>
											<button class="svwg-sub-trigger" aria-expanded="false"><span class="svwg-sub-dot"></span><span class="svwg-sub-lbl">Image Cards Simple Grid</span><svg class="svwg-sub-chev" viewBox="0 0 24 24"><path d="M7.41 8.59 12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/></svg></button>
											<div class="svwg-sub-body"><div class="svwg-sub-body-inner"><div class="svwg-sub-content">
														<div class="svwg-video-wrap" style="position:relative;padding-bottom:55.27809307604995%;height:0;"><iframe data-src="https://www.loom.com/embed/3b17f4c8f47647e69b56afe064510de0" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div>
													</div></div></div>
										</div>
										
										<div class="svwg-sub-card" data-svwg-sub>
											<button class="svwg-sub-trigger" aria-expanded="false"><span class="svwg-sub-dot"></span><span class="svwg-sub-lbl">Image Cards with Links</span><svg class="svwg-sub-chev" viewBox="0 0 24 24"><path d="M7.41 8.59 12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/></svg></button>
											<div class="svwg-sub-body"><div class="svwg-sub-body-inner"><div class="svwg-sub-content">
														<div class="svwg-video-wrap" style="position:relative;padding-bottom:55.27809307604995%;height:0;"><iframe data-src="https://www.loom.com/embed/67474b5f5d4c4ccf97b44b2a7670ebde" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div>
													</div></div></div>
										</div>
										
										<div class="svwg-sub-card" data-svwg-sub>
											<button class="svwg-sub-trigger" aria-expanded="false"><span class="svwg-sub-dot"></span><span class="svwg-sub-lbl">Image Cards Multi Grid</span><svg class="svwg-sub-chev" viewBox="0 0 24 24"><path d="M7.41 8.59 12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/></svg></button>
											<div class="svwg-sub-body"><div class="svwg-sub-body-inner"><div class="svwg-sub-content">
														<div class="svwg-video-wrap" style="position:relative;padding-bottom:55.27809307604995%;height:0;"><iframe data-src="https://www.loom.com/embed/7867f3b78f2a46a1aac175c29c0daae6" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div>
													</div></div></div>
										</div>
										
										<div class="svwg-sub-card" data-svwg-sub>
											<button class="svwg-sub-trigger" aria-expanded="false"><span class="svwg-sub-dot"></span><span class="svwg-sub-lbl">Image Gallery</span><svg class="svwg-sub-chev" viewBox="0 0 24 24"><path d="M7.41 8.59 12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/></svg></button>
											<div class="svwg-sub-body"><div class="svwg-sub-body-inner"><div class="svwg-sub-content">
														<div class="svwg-video-wrap" style="position:relative;padding-bottom:55.27809307604995%;height:0;"><iframe data-src="https://www.loom.com/embed/899828bb7c3d4bdbafb6082de8e68e4e" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div>
													</div></div></div>
										</div>
										
										<div class="svwg-sub-card" data-svwg-sub>
											<button class="svwg-sub-trigger" aria-expanded="false"><span class="svwg-sub-dot"></span><span class="svwg-sub-lbl">Logo Gallery</span><svg class="svwg-sub-chev" viewBox="0 0 24 24"><path d="M7.41 8.59 12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/></svg></button>
											<div class="svwg-sub-body"><div class="svwg-sub-body-inner"><div class="svwg-sub-content">
														<div class="svwg-video-wrap" style="position:relative;padding-bottom:55.27809307604995%;height:0;"><iframe data-src="https://www.loom.com/embed/1c06335fe4c1475083431c7b833fa41c" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div>
													</div></div></div>
										</div>
										
										<div class="svwg-sub-card" data-svwg-sub>
											<button class="svwg-sub-trigger" aria-expanded="false"><span class="svwg-sub-dot"></span><span class="svwg-sub-lbl">Product Feed</span><svg class="svwg-sub-chev" viewBox="0 0 24 24"><path d="M7.41 8.59 12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/></svg></button>
											<div class="svwg-sub-body"><div class="svwg-sub-body-inner"><div class="svwg-sub-content">
														<div class="svwg-video-wrap" style="position:relative;padding-bottom:55.27809307604995%;height:0;"><iframe data-src="https://www.loom.com/embed/494ba63451be45519da0e8c343d22d18" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div>
													</div></div></div>
										</div>
										
										<div class="svwg-sub-card" data-svwg-sub>
											<button class="svwg-sub-trigger" aria-expanded="false"><span class="svwg-sub-dot"></span><span class="svwg-sub-lbl">Showroom Feed</span><svg class="svwg-sub-chev" viewBox="0 0 24 24"><path d="M7.41 8.59 12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/></svg></button>
											<div class="svwg-sub-body"><div class="svwg-sub-body-inner"><div class="svwg-sub-content">
														<div class="svwg-video-wrap" style="position:relative;padding-bottom:55.27809307604995%;height:0;"><iframe data-src="https://www.loom.com/embed/04662e1f2099460185afcbce28362dd7" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div>
													</div></div></div>
										</div>
										
										<div class="svwg-sub-card" data-svwg-sub>
											<button class="svwg-sub-trigger" aria-expanded="false"><span class="svwg-sub-dot"></span><span class="svwg-sub-lbl">Team Members</span><svg class="svwg-sub-chev" viewBox="0 0 24 24"><path d="M7.41 8.59 12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/></svg></button>
											<div class="svwg-sub-body"><div class="svwg-sub-body-inner"><div class="svwg-sub-content">
														<div class="svwg-video-wrap" style="position:relative;padding-bottom:55.27809307604995%;height:0;"><iframe data-src="https://www.loom.com/embed/869fe1cb2a9b449d83994aacc9b68bb6" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div>
													</div></div></div>
										</div>
										
										<div class="svwg-sub-card" data-svwg-sub>
											<button class="svwg-sub-trigger" aria-expanded="false"><span class="svwg-sub-dot"></span><span class="svwg-sub-lbl">Testimonial</span><svg class="svwg-sub-chev" viewBox="0 0 24 24"><path d="M7.41 8.59 12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/></svg></button>
											<div class="svwg-sub-body"><div class="svwg-sub-body-inner"><div class="svwg-sub-content">
														<div class="svwg-video-wrap" style="position:relative;padding-bottom:55.27809307604995%;height:0;"><iframe data-src="https://www.loom.com/embed/7a95c7a0a18e4f63944154f924d14a0b" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div>
													</div></div></div>
										</div>
										
										<div class="svwg-sub-card" data-svwg-sub>
											<button class="svwg-sub-trigger" aria-expanded="false"><span class="svwg-sub-dot"></span><span class="svwg-sub-lbl">Timeline</span><svg class="svwg-sub-chev" viewBox="0 0 24 24"><path d="M7.41 8.59 12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/></svg></button>
											<div class="svwg-sub-body"><div class="svwg-sub-body-inner"><div class="svwg-sub-content">
														<div class="svwg-video-wrap" style="position:relative;padding-bottom:55.27809307604995%;height:0;"><iframe data-src="https://www.loom.com/embed/937c13af82054d1ab0ec5fb1d500ae43" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div>
													</div></div></div>
										</div>
									
									</div><!-- /svwg-sub-group -->
								</div></div></div>
					</div>
					
					<!-- 4. Shop Page -->
					<div class="svwg-card" data-svwg-accordion>
						<button class="svwg-trigger" aria-expanded="false">
							<span class="svwg-icon"><svg viewBox="0 0 24 24"><path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96C5 16.1 6.9 18 9 18h12v-2H9.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63H19c.75 0 1.41-.41 1.75-1.03l3.58-6.49A1 1 0 0 0 23.46 5H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/></svg></span>
							<span class="svwg-label">Shop Page</span>
							<span class="svwg-child-badge">4 sections</span>
							<svg class="svwg-chevron" viewBox="0 0 24 24"><path d="M7.41 8.59 12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/></svg>
						</button>
						<div class="svwg-body"><div class="svwg-body-inner"><div class="svwg-content">
									<div class="svwg-video-wrap" style="position:relative;padding-bottom:55.27809307604995%;height:0;"><iframe data-src="https://www.loom.com/embed/bbd91249517a487a899f7f805d9ea590" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div>
									<div class="svwg-sub-group">
										<div class="svwg-sub-label">Sub Sections</div>
										
										<div class="svwg-sub-card" data-svwg-sub>
											<button class="svwg-sub-trigger" aria-expanded="false"><span class="svwg-sub-dot"></span><span class="svwg-sub-lbl">Product Categories</span><svg class="svwg-sub-chev" viewBox="0 0 24 24"><path d="M7.41 8.59 12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/></svg></button>
											<div class="svwg-sub-body"><div class="svwg-sub-body-inner"><div class="svwg-sub-content">
														<div class="svwg-video-wrap" style="position:relative;padding-bottom:55.27809307604995%;height:0;"><iframe data-src="https://www.loom.com/embed/4db455aef4fa4ac59bfb4ecb413f7e44" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div>
													</div></div></div>
										</div>
										
										<div class="svwg-sub-card" data-svwg-sub>
											<button class="svwg-sub-trigger" aria-expanded="false"><span class="svwg-sub-dot"></span><span class="svwg-sub-lbl">Products</span><svg class="svwg-sub-chev" viewBox="0 0 24 24"><path d="M7.41 8.59 12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/></svg></button>
											<div class="svwg-sub-body"><div class="svwg-sub-body-inner"><div class="svwg-sub-content">
														<div class="svwg-video-wrap" style="position:relative;padding-bottom:55.27809307604995%;height:0;"><iframe data-src="https://www.loom.com/embed/f6579f76124f4ecdb069f7be1733f818" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div>
													</div></div></div>
										</div>
										
										<div class="svwg-sub-card" data-svwg-sub>
											<button class="svwg-sub-trigger" aria-expanded="false"><span class="svwg-sub-dot"></span><span class="svwg-sub-lbl">Product Attributes</span><svg class="svwg-sub-chev" viewBox="0 0 24 24"><path d="M7.41 8.59 12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/></svg></button>
											<div class="svwg-sub-body"><div class="svwg-sub-body-inner"><div class="svwg-sub-content">
														<div class="svwg-video-wrap" style="position:relative;padding-bottom:55.27809307604995%;height:0;"><iframe data-src="https://www.loom.com/embed/f039576798a84021b1d63b415b9281b8" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div>
													</div></div></div>
										</div>
										
										<div class="svwg-sub-card" data-svwg-sub>
											<button class="svwg-sub-trigger" aria-expanded="false"><span class="svwg-sub-dot"></span><span class="svwg-sub-lbl">Solution Attributes</span><svg class="svwg-sub-chev" viewBox="0 0 24 24"><path d="M7.41 8.59 12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/></svg></button>
											<div class="svwg-sub-body"><div class="svwg-sub-body-inner"><div class="svwg-sub-content">
														<div class="svwg-video-wrap" style="position:relative;padding-bottom:55.27809307604995%;height:0;"><iframe data-src="https://www.loom.com/embed/051c5a82403a413085526426b275c4a8" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div>
													</div></div></div>
										</div>
									
									</div><!-- /svwg-sub-group -->
								</div></div></div>
					</div>
					
					<!-- 5. Projects -->
					<div class="svwg-card" data-svwg-accordion>
						<button class="svwg-trigger" aria-expanded="false">
							<span class="svwg-icon"><svg viewBox="0 0 24 24"><path d="M10 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2h-8l-2-2z"/></svg></span>
							<span class="svwg-label">Projects</span>
							<svg class="svwg-chevron" viewBox="0 0 24 24"><path d="M7.41 8.59 12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/></svg>
						</button>
						<div class="svwg-body"><div class="svwg-body-inner"><div class="svwg-content">
									<div class="svwg-video-wrap" style="position:relative;padding-bottom:55.27809307604995%;height:0;"><iframe data-src="https://www.loom.com/embed/1fdcf29cebff4eb9b5649c8d849e7250" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div>
								</div></div></div>
					</div>
					
					<!-- 6. Resources -->
					<div class="svwg-card" data-svwg-accordion>
						<button class="svwg-trigger" aria-expanded="false">
							<span class="svwg-icon"><svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg></span>
							<span class="svwg-label">Resources</span>
							<svg class="svwg-chevron" viewBox="0 0 24 24"><path d="M7.41 8.59 12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/></svg>
						</button>
						<div class="svwg-body"><div class="svwg-body-inner"><div class="svwg-content">
									<div class="svwg-video-wrap" style="position:relative;padding-bottom:55.27809307604995%;height:0;"><iframe data-src="https://www.loom.com/embed/c39c67e5e024469b926fe4a043b23a9c" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div>
								</div></div></div>
					</div>
					
					<!-- 7. FAQs -->
					<div class="svwg-card" data-svwg-accordion>
						<button class="svwg-trigger" aria-expanded="false">
							<span class="svwg-icon"><svg viewBox="0 0 24 24"><path d="M11.07 12.85c.77-1.39 2.25-2.21 3.11-3.44.91-1.29.4-3.7-2.18-3.7-1.69 0-2.52 1.28-2.87 2.34L7.1 7.05C7.83 4.99 9.78 3 12.01 3c2.35 0 3.96 1.07 4.78 2.41.7 1.15 1.11 3.3.03 4.9-1.2 1.77-2.35 2.31-2.97 3.45-.25.46-.35.76-.35 2.24h-2.89c-.01-.78-.13-2.05.46-3.15zM14 20c0 1.1-.9 2-2 2s-2-.9-2-2 .9-2 2-2 2 .9 2 2z"/></svg></span>
							<span class="svwg-label">FAQs</span>
							<svg class="svwg-chevron" viewBox="0 0 24 24"><path d="M7.41 8.59 12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/></svg>
						</button>
						<div class="svwg-body"><div class="svwg-body-inner"><div class="svwg-content">
									<div class="svwg-video-wrap" style="position:relative;padding-bottom:55.27809307604995%;height:0;"><iframe data-src="https://www.loom.com/embed/c48d7fb8a45649f88b88b6191b5fbf4f" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div>
								</div></div></div>
					</div>
					
					<!-- 8. Non Flexible Content Pages -->
					<div class="svwg-card" data-svwg-accordion>
						<button class="svwg-trigger" aria-expanded="false">
							<span class="svwg-icon"><svg viewBox="0 0 24 24"><path d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6zm4 18H6V4h7v5h5v11z"/></svg></span>
							<span class="svwg-label">Non Flexible Content Pages</span>
							<svg class="svwg-chevron" viewBox="0 0 24 24"><path d="M7.41 8.59 12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/></svg>
						</button>
						<div class="svwg-body"><div class="svwg-body-inner"><div class="svwg-content">
									<div class="svwg-video-wrap" style="position:relative;padding-bottom:55.27809307604995%;height:0;"><iframe data-src="https://www.loom.com/embed/424e21ccdfcc4904ba38582a36ba7d5f" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div>
								</div></div></div>
					</div>
				
				</div><!-- /svwg-accordion-group -->
			</div><!-- /svwg-page -->
		</div><!-- /wrap -->
		
		<script>
			(function() {
				// Insert a spinner into every video wrapper on page load
				document.querySelectorAll('#svwg-page .svwg-video-wrap').forEach(function(wrap) {
					var spinner = document.createElement('div');
					spinner.className = 'svwg-spinner';
					wrap.insertBefore(spinner, wrap.firstChild);
				});

				// Promote data-src → src; hide spinner once iframe fires load
				function loadIframes(card) {
					card.querySelectorAll('iframe[data-src]').forEach(function(iframe) {
						var spinner = iframe.parentNode.querySelector('.svwg-spinner');
						iframe.src = iframe.getAttribute('data-src');
						iframe.removeAttribute('data-src');
						if (spinner) {
							iframe.addEventListener('load', function() {
								spinner.style.display = 'none';
							}, { once: true });
						}
					});
				}

				function initAccordion(trigger, card) {
					trigger.addEventListener('click', function() {
						var open = card.classList.contains('is-open');
						card.classList.toggle('is-open', !open);
						trigger.setAttribute('aria-expanded', String(!open));
						if (!open) { loadIframes(card); }
					});
				}

				document.querySelectorAll('[data-svwg-accordion]').forEach(function(card) {
					initAccordion(card.querySelector('.svwg-trigger'), card);
				});
				document.querySelectorAll('[data-svwg-sub]').forEach(function(card) {
					initAccordion(card.querySelector('.svwg-sub-trigger'), card);
				});

				var btn = document.getElementById('svwgExpandBtn');
				var expanded = false;
				btn.addEventListener('click', function() {
					expanded = !expanded;
					document.querySelectorAll('[data-svwg-accordion]').forEach(function(card) {
						card.classList.toggle('is-open', expanded);
						card.querySelector('.svwg-trigger').setAttribute('aria-expanded', String(expanded));
						if (expanded) { loadIframes(card); }
					});
					btn.textContent = expanded ? 'Collapse all' : 'Expand all';
				});
			})();
		</script>
		<?php
	}