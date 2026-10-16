/* Leeroy Systems theme behaviour. No dependencies. */
(function () {
	'use strict';

	var root = document.documentElement;
	root.classList.add('js');
	var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

	/* Sticky header shadow + back-to-top */
	var header = document.querySelector('[data-header]');
	var toTop = document.querySelector('[data-to-top]');
	function onScroll() {
		var y = window.scrollY;
		if (header) header.classList.toggle('is-stuck', y > 60);
		if (toTop) toTop.classList.toggle('is-visible', y > 600);
	}
	window.addEventListener('scroll', onScroll, { passive: true });
	onScroll();
	if (toTop) toTop.addEventListener('click', function () { window.scrollTo({ top: 0, behavior: reduceMotion ? 'auto' : 'smooth' }); });

	/* Mobile menu */
	var toggle = document.querySelector('.nav-toggle');
	var nav = document.querySelector('.nav');
	if (toggle && nav) {
		toggle.addEventListener('click', function () {
			var open = toggle.getAttribute('aria-expanded') !== 'true';
			toggle.setAttribute('aria-expanded', String(open));
			toggle.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
			nav.classList.toggle('is-open', open);
		});
		nav.querySelectorAll('a').forEach(function (a) {
			a.addEventListener('click', function () {
				toggle.setAttribute('aria-expanded', 'false');
				nav.classList.remove('is-open');
			});
		});
		document.querySelectorAll('.sub-toggle').forEach(function (btn) {
			btn.addEventListener('click', function () {
				var open = btn.getAttribute('aria-expanded') !== 'true';
				// Like the original site: only one submenu open at a time.
				document.querySelectorAll('.sub-toggle').forEach(function (other) {
					if (other !== btn) {
						other.setAttribute('aria-expanded', 'false');
						other.nextElementSibling.classList.remove('is-open');
					}
				});
				btn.setAttribute('aria-expanded', String(open));
				btn.nextElementSibling.classList.toggle('is-open', open);
			});
		});
		var closeMenu = function () {
			toggle.setAttribute('aria-expanded', 'false');
			toggle.setAttribute('aria-label', 'Open menu');
			nav.classList.remove('is-open');
		};
		document.addEventListener('click', function (e) {
			if (nav.classList.contains('is-open') && !nav.contains(e.target) && !toggle.contains(e.target)) closeMenu();
		});
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && nav.classList.contains('is-open')) { closeMenu(); toggle.focus(); }
		});
	}

	/* Offices & footprint map: Africa -> regional footprint (on scroll) -> Botswana */
	var zmap = document.querySelector('[data-zoommap]');
	if (zmap) {
		var frame = zmap.querySelector('.zmap__frame');
		var svg = zmap.querySelector('.zmap__svg');
		var panel = zmap.querySelector('.zmap__panel');
		var pins = zmap.querySelectorAll('.zmap__pin');
		var infoPins = zmap.querySelectorAll('[data-office]');
		var cards = zmap.querySelectorAll('[data-card]');
		var items = zmap.querySelectorAll('[data-office-card]');
		var viewBtns = zmap.querySelectorAll('[data-view-btn]');
		var narrow = window.matchMedia('(max-width: 760px)');
		var box = function (attr) { var v = zmap.getAttribute(attr).split(',').map(Number); return { x: v[0], y: v[1], w: v[2], h: v[3] }; };
		var BOXES = { africa: box('data-africa'), region: box('data-region'), bwa: box('data-bwa') };
		var PAD = { africa: 0.08, region: 0.12, bwa: 0.55 };
		var state = 'africa', current = null, anim = null, pinned = null;

		// viewBox that frames a box in the visible part of the map (right of the
		// overlay panel on wide screens), slightly left of centre when zoomed in
		// so popups have room on the right.
		var viewFor = function (name) {
			var b = BOXES[name];
			var pad = narrow.matches && name === 'bwa' ? 0.3 : PAD[name];
			var fw = frame.clientWidth, fh = frame.clientHeight, aspect = fw / fh;
			var overlay = (!narrow.matches && panel) ? (panel.offsetWidth + 40) / fw : 0;
			var bw = b.w * (1 + pad), bh = b.h * (1 + pad);
			var W = Math.max(bw / (1 - overlay), bh * aspect), H = W / aspect;
			var cx = b.x + b.w / 2, cy = b.y + b.h / 2;
			var at = name !== 'africa' && overlay ? 0.32 : 0.5;
			return { x: cx - (overlay + (1 - overlay) * at) * W, y: cy - H / 2, w: W, h: H };
		};
		var apply = function (v) {
			current = v;
			svg.setAttribute('viewBox', [v.x, v.y, v.w, v.h].join(' '));
			svg.style.setProperty('--fs', (13 * v.w / frame.clientWidth) + 'px');
		};
		var placePins = function () {
			if (!current) return;
			pins.forEach(function (p) {
				p.style.left = ((+p.dataset.x - current.x) / current.w * 100) + '%';
				p.style.top = ((+p.dataset.y - current.y) / current.h * 100) + '%';
			});
		};
		var visiblePins = function () {
			return Array.prototype.filter.call(pins, function (p) { return p.dataset.view === state; });
		};

		var placeCard = function (card, pin) {
			if (narrow.matches) { card.style.left = ''; card.style.top = ''; return; }
			var fw = frame.clientWidth, fh = frame.clientHeight;
			var px = pin.offsetLeft, py = pin.offsetTop;
			var cw = card.offsetWidth, ch = card.offsetHeight;
			var minLeft = panel ? panel.offsetLeft + panel.offsetWidth + 16 : 8;
			// Right of every visible pin label, so no pin is covered.
			var labelsRight = 0;
			visiblePins().forEach(function (p) { labelsRight = Math.max(labelsRight, p.offsetLeft - 19 + p.offsetWidth); });
			var left = Math.max(px + 40, labelsRight + 14);
			if (left + cw > fw - 8) left = px - cw - 34;
			if (left < minLeft) left = Math.max(minLeft, Math.min(px + 40, fw - cw - 8));
			card.style.left = left + 'px';
			card.style.top = Math.max(8, Math.min(py - ch / 2, fh - ch - 8)) + 'px';
		};
		var show = function (id) {
			infoPins.forEach(function (p) {
				var on = p.dataset.office === id;
				p.classList.toggle('is-active', on);
				p.setAttribute('aria-expanded', String(on));
			});
			items.forEach(function (i) { i.classList.toggle('is-active', i.dataset.officeCard === id); });
			cards.forEach(function (card) {
				var on = card.dataset.card === id;
				card.hidden = !on;
				if (on) placeCard(card, zmap.querySelector('[data-office="' + id + '"]'));
			});
		};
		var hideAll = function () {
			pinned = null;
			infoPins.forEach(function (p) { p.classList.remove('is-active'); p.setAttribute('aria-expanded', 'false'); });
			items.forEach(function (i) { i.classList.remove('is-active'); });
			cards.forEach(function (card) { card.hidden = true; });
		};
		var setViewClasses = function () {
			zmap.classList.toggle('is-zoomed', state !== 'africa');
			zmap.classList.toggle('is-view-region', state === 'region');
			zmap.classList.toggle('is-view-bwa', state === 'bwa');
			viewBtns.forEach(function (b) { b.setAttribute('aria-pressed', String(b.dataset.viewBtn === state)); });
			pins.forEach(function (p) { p.tabIndex = p.dataset.view === state ? 0 : -1; });
		};
		var ease = function (t) { return t < 0.5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2; };

		// Smooth zoom: width changes geometrically so it feels like a camera move.
		var zoomTo = function (name, done) {
			if (anim) { cancelAnimationFrame(anim); anim = null; }
			var from = current || viewFor(state), to = viewFor(name);
			hideAll();
			state = name;
			zmap.classList.remove('is-view-region', 'is-view-bwa');
			viewBtns.forEach(function (b) { b.setAttribute('aria-pressed', String(b.dataset.viewBtn === name)); });
			var finish = function () {
				zmap.classList.remove('is-zooming');
				apply(to); placePins(); setViewClasses();
				if (done) done();
			};
			if (reduceMotion) { finish(); return; }
			zmap.classList.add('is-zooming');
			var dur = Math.abs(Math.log(to.w / from.w)) > 2 ? 2600 : 1600, t0 = null;
			// Safety net: if animation frames are throttled (background tab,
			// low-power mode) still land on the final view on time.
			var guard = setTimeout(function () { if (anim) { cancelAnimationFrame(anim); anim = null; finish(); } }, dur + 400);
			var fcx = from.x + from.w / 2, fcy = from.y + from.h / 2, tcx = to.x + to.w / 2, tcy = to.y + to.h / 2;
			var step = function (t) {
				if (!t0) t0 = t;
				var k = Math.min((t - t0) / dur, 1), e = ease(k);
				var w = Math.exp(Math.log(from.w) + (Math.log(to.w) - Math.log(from.w)) * e);
				var h = w * (from.h / from.w);
				var cx = fcx + (tcx - fcx) * e, cy = fcy + (tcy - fcy) * e;
				apply({ x: cx - w / 2, y: cy - h / 2, w: w, h: h });
				if (k < 1) { anim = requestAnimationFrame(step); } else { anim = null; clearTimeout(guard); finish(); }
			};
			anim = requestAnimationFrame(step);
		};

		apply(viewFor('africa'));
		setViewClasses();

		var played = false;
		var startZoom = function () {
			if (played) return;
			played = true;
			setTimeout(function () { zoomTo('region'); }, 500);
		};
		if ('IntersectionObserver' in window) {
			var zio = new IntersectionObserver(function (entries) {
				entries.forEach(function (e) { if (e.isIntersecting) { startZoom(); zio.disconnect(); } });
			}, { threshold: 0.55 });
			zio.observe(frame);
		} else {
			startZoom();
		}

		viewBtns.forEach(function (b) {
			b.addEventListener('click', function () {
				played = true;
				if (b.dataset.viewBtn !== state || anim) zoomTo(b.dataset.viewBtn);
			});
		});

		// Open a pin's card, zooming to the view it lives in first if needed.
		var openInfo = function (id, view) {
			pinned = id;
			played = true;
			if (state === view && !anim) { show(id); } else { zoomTo(view, function () { pinned = id; show(id); }); }
		};
		infoPins.forEach(function (pin) {
			pin.addEventListener('mouseenter', function () { if (!narrow.matches && state === pin.dataset.view && !anim) show(pin.dataset.office); });
			pin.addEventListener('focus', function () { if (state === pin.dataset.view && !anim) show(pin.dataset.office); });
			pin.addEventListener('click', function () { openInfo(pin.dataset.office, pin.dataset.view); });
		});
		zmap.querySelectorAll('[data-zoom-to]').forEach(function (b) {
			b.addEventListener('click', function () { played = true; zoomTo(b.dataset.zoomTo, function () { pinned = 'gaborone'; show('gaborone'); }); });
		});
		frame.addEventListener('mouseleave', function () {
			if (narrow.matches || anim) return;
			if (pinned) { show(pinned); } else { hideAll(); }
		});
		items.forEach(function (i) {
			i.addEventListener('mouseenter', function () { if (!narrow.matches && state === i.dataset.view && !anim) show(i.dataset.officeCard); });
			i.addEventListener('mouseleave', function () { if (!narrow.matches && !anim) { if (pinned) { show(pinned); } else { hideAll(); } } });
			i.addEventListener('click', function () { openInfo(i.dataset.officeCard, i.dataset.view); });
		});
		zmap.querySelectorAll('[data-card-close]').forEach(function (b) { b.addEventListener('click', hideAll); });
		document.addEventListener('keydown', function (e) { if (e.key === 'Escape') hideAll(); });

		window.addEventListener('resize', function () {
			if (anim) return;
			apply(viewFor(state)); placePins();
			var open = zmap.querySelector('.zmap__card:not([hidden])');
			if (open) placeCard(open, zmap.querySelector('[data-office="' + open.dataset.card + '"]'));
		});
	}

	/* Hero slider */
	var slider = document.querySelector('[data-slider]');
	if (slider) {
		var slides = slider.querySelectorAll('.hero__slide');
		var dots = slider.querySelectorAll('[data-slide-to]');
		var current = 0;
		var timer;
		var go = function (i) {
			current = (i + slides.length) % slides.length;
			slides.forEach(function (s, n) {
				s.classList.toggle('is-active', n === current);
				if (n === current) { s.removeAttribute('aria-hidden'); } else { s.setAttribute('aria-hidden', 'true'); }
			});
			dots.forEach(function (d, n) { d.classList.toggle('is-active', n === current); });
		};
		var start = function () {
			if (reduceMotion) return;
			clearInterval(timer);
			timer = setInterval(function () { go(current + 1); }, 7000);
		};
		dots.forEach(function (d) { d.addEventListener('click', function () { go(+d.dataset.slideTo); start(); }); });
		slider.querySelector('[data-slide-prev]').addEventListener('click', function () { go(current - 1); start(); });
		slider.querySelector('[data-slide-next]').addEventListener('click', function () { go(current + 1); start(); });
		slider.addEventListener('mouseenter', function () { clearInterval(timer); });
		slider.addEventListener('mouseleave', start);
		start();
	}

	/* Reveal-on-scroll + animated counters */
	var countUp = function (el) {
		var target = +el.dataset.count;
		if (reduceMotion || target < 2) { el.textContent = target.toLocaleString(); return; }
		var t0 = null;
		var step = function (t) {
			if (!t0) t0 = t;
			var p = Math.min((t - t0) / 1800, 1);
			el.textContent = Math.round(target * (1 - Math.pow(1 - p, 3))).toLocaleString();
			if (p < 1) requestAnimationFrame(step);
		};
		requestAnimationFrame(step);
	};
	if ('IntersectionObserver' in window) {
		var io = new IntersectionObserver(function (entries) {
			entries.forEach(function (e) {
				if (!e.isIntersecting) return;
				if (e.target.dataset.count) { countUp(e.target); } else { e.target.classList.add('is-visible'); }
				io.unobserve(e.target);
			});
		}, { threshold: 0.15 });
		document.querySelectorAll('[data-reveal], [data-count]').forEach(function (el) { io.observe(el); });
	} else {
		document.querySelectorAll('[data-reveal]').forEach(function (el) { el.classList.add('is-visible'); });
	}

	/* Contact tabs */
	document.querySelectorAll('[data-tabs]').forEach(function (wrap) {
		var tabs = wrap.querySelectorAll('[role="tab"]');
		tabs.forEach(function (tab, i) {
			tab.addEventListener('click', function () {
				tabs.forEach(function (t) {
					var on = t === tab;
					t.classList.toggle('is-active', on);
					t.setAttribute('aria-selected', String(on));
					document.getElementById(t.getAttribute('aria-controls')).hidden = !on;
				});
			});
			tab.addEventListener('keydown', function (e) {
				var dir = e.key === 'ArrowRight' ? 1 : e.key === 'ArrowLeft' ? -1 : 0;
				if (!dir) return;
				var next = tabs[(i + dir + tabs.length) % tabs.length];
				next.click();
				next.focus();
			});
		});
	});

	/* Community story filter */
	var filter = document.querySelector('[data-filter]');
	if (filter) {
		var groups = document.querySelectorAll('[data-filter-group]');
		filter.querySelectorAll('button').forEach(function (btn) {
			btn.addEventListener('click', function () {
				var v = btn.dataset.filterValue;
				filter.querySelectorAll('button').forEach(function (b) {
					b.classList.toggle('is-active', b === btn);
					b.setAttribute('aria-selected', String(b === btn));
				});
				groups.forEach(function (g) { g.hidden = v !== 'all' && g.dataset.filterGroup !== v; });
			});
		});
	}

	/* WordPress galleries in news posts open in the lightbox */
	document.querySelectorAll('.post__content .gallery').forEach(function (g) {
		g.setAttribute('data-gallery-group', '');
		g.querySelectorAll('a[href]').forEach(function (a) {
			if (/\.(jpe?g|png|webp|gif)(\?|$)/i.test(a.getAttribute('href'))) a.setAttribute('data-lightbox', a.getAttribute('href'));
		});
	});

	/* Lightbox: photo galleries, community stories, YouTube videos */
	var modal = document.querySelector('[data-lightbox-modal]');
	if (modal) {
		var stage = modal.querySelector('[data-lightbox-stage]');
		var caption = modal.querySelector('[data-lightbox-caption]');
		var prev = modal.querySelector('[data-lightbox-prev]');
		var next = modal.querySelector('[data-lightbox-next]');
		var state = { photos: [], titles: null, index: 0, title: '', text: '', opener: null };

		var esc = function (s) { var d = document.createElement('div'); d.textContent = s; return d.innerHTML; };

		var renderPhoto = function () {
			if (state.titles) state.title = state.titles[state.index] || '';
			stage.innerHTML = '<img src="' + state.photos[state.index] + '" alt="' + esc(state.title || 'Photo') + ' (' + (state.index + 1) + ' of ' + state.photos.length + ')">';
			var multi = state.photos.length > 1;
			prev.hidden = next.hidden = !multi;
			caption.innerHTML = (state.title ? '<strong>' + esc(state.title) + '</strong>' : '') +
				(state.text ? esc(state.text) : '') +
				(multi ? '<small>' + (state.index + 1) + ' / ' + state.photos.length + '</small>' : '');
		};

		var open = function (opener) {
			state.opener = opener;
			modal.hidden = false;
			document.body.style.overflow = 'hidden';
			modal.querySelector('[data-lightbox-close]').focus();
		};
		var close = function () {
			modal.hidden = true;
			stage.innerHTML = '';
			document.body.style.overflow = '';
			if (state.opener) state.opener.focus();
		};

		document.querySelectorAll('[data-story]').forEach(function (btn) {
			btn.addEventListener('click', function () {
				var d = JSON.parse(btn.dataset.story);
				state.photos = d.photos; state.titles = null; state.index = 0; state.title = d.title; state.text = d.text;
				renderPhoto(); open(btn);
			});
		});

		document.querySelectorAll('[data-lightbox]').forEach(function (btn) {
			btn.addEventListener('click', function () {
				var group = btn.closest('[data-gallery-group]');
				var items = group ? group.querySelectorAll('[data-lightbox]') : [btn];
				state.photos = Array.prototype.map.call(items, function (i) { return i.dataset.lightbox; });
				state.index = Array.prototype.indexOf.call(items, btn);
				state.titles = Array.prototype.map.call(items, function (i) { return i.dataset.title || ''; });
				state.title = ''; state.text = '';
				renderPhoto(); open(btn);
			});
		});

		document.querySelectorAll('[data-youtube]').forEach(function (btn) {
			btn.addEventListener('click', function () {
				stage.innerHTML = '<iframe src="https://www.youtube-nocookie.com/embed/' + encodeURIComponent(btn.dataset.youtube) + '?autoplay=1&rel=0" title="' + esc(btn.dataset.title) + '" allow="autoplay; encrypted-media; picture-in-picture" allowfullscreen></iframe>';
				prev.hidden = next.hidden = true;
				caption.innerHTML = '<strong>' + esc(btn.dataset.title) + '</strong>';
				open(btn);
			});
		});

		var step = function (d) { state.index = (state.index + d + state.photos.length) % state.photos.length; renderPhoto(); };
		prev.addEventListener('click', function () { step(-1); });
		next.addEventListener('click', function () { step(1); });
		modal.querySelector('[data-lightbox-close]').addEventListener('click', close);
		modal.addEventListener('click', function (e) { if (e.target === modal) close(); });
		document.addEventListener('keydown', function (e) {
			if (modal.hidden) return;
			if (e.key === 'Escape') close();
			if (e.key === 'ArrowLeft' && !prev.hidden) step(-1);
			if (e.key === 'ArrowRight' && !next.hidden) step(1);
		});
	}

	/* CV dropzone */
	document.querySelectorAll('[data-dropzone]').forEach(function (zone) {
		var input = zone.querySelector('input[type="file"]');
		var text = zone.querySelector('.dropzone__text');
		input.addEventListener('change', function () {
			if (input.files.length) {
				zone.classList.add('has-file');
				text.innerHTML = '<strong></strong>';
				text.firstChild.textContent = input.files[0].name;
			}
		});
		['dragenter', 'dragover'].forEach(function (ev) { zone.addEventListener(ev, function () { zone.classList.add('is-over'); }); });
		['dragleave', 'drop'].forEach(function (ev) { zone.addEventListener(ev, function () { zone.classList.remove('is-over'); }); });
	});
})();
