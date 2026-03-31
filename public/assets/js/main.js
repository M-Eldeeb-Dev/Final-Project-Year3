/**
 * main.js — Deepify
 * Handles: product filters, live search, sort, wishlist, qty selector, misc
 */

document.addEventListener('DOMContentLoaded', () => {

  /* ─── Product Filters (category tabs) ──────────────────────── */
  const filterBtns = document.querySelectorAll('[data-filter-cat]');
  const productCards = document.querySelectorAll('[data-product-card]');

  filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      const cat = btn.dataset.filterCat;

      // active style
      filterBtns.forEach(b => {
        b.classList.remove('text-[#00C8FF]', 'border-b', 'border-[#00C8FF]');
        b.classList.add('text-gray-500');
      });
      btn.classList.add('text-[#00C8FF]', 'border-b', 'border-[#00C8FF]');
      btn.classList.remove('text-gray-500');

      // show/hide cards
      let visible = 0;
      productCards.forEach(card => {
        const match = cat === 'all' || card.dataset.category === cat;
        card.style.display = match ? '' : 'none';
        if (match) visible++;
      });

      // update count
      const countEl = document.getElementById('product-count');
      if (countEl) countEl.textContent = visible;
    });
  });

  /* ─── Live Search Filter ─────────────────────────────────────── */
  const searchInput = document.getElementById('product-search');
  if (searchInput) {
    searchInput.addEventListener('input', () => {
      const q = searchInput.value.toLowerCase().trim();
      let visible = 0;
      productCards.forEach(card => {
        const name = (card.dataset.name || '').toLowerCase();
        const cat  = (card.dataset.category || '').toLowerCase();
        const match = name.includes(q) || cat.includes(q);
        card.style.display = match ? '' : 'none';
        if (match) visible++;
      });
      const countEl = document.getElementById('product-count');
      if (countEl) countEl.textContent = visible;
    });
  }

  /* ─── Sort ─────────────────────────────────────────────────── */
  const sortSelect = document.getElementById('sort-select');
  if (sortSelect) {
    sortSelect.addEventListener('change', () => {
      const grid = document.getElementById('products-grid');
      if (!grid) return;
      const cards = [...grid.querySelectorAll('[data-product-card]')];

      cards.sort((a, b) => {
        const priceA = parseFloat(a.dataset.price || 0);
        const priceB = parseFloat(b.dataset.price || 0);
        const dateA  = parseInt(a.dataset.created || 0);
        const dateB  = parseInt(b.dataset.created || 0);
        switch (sortSelect.value) {
          case 'price_asc':  return priceA - priceB;
          case 'price_desc': return priceB - priceA;
          case 'newest':     return dateB - dateA;
          default:           return (parseInt(b.dataset.featured||0)) - (parseInt(a.dataset.featured||0));
        }
      });

      cards.forEach(c => grid.appendChild(c));
    });
  }

  /* ─── Wishlist (localStorage) ───────────────────────────────── */
  function getWishlist() {
    try { return JSON.parse(localStorage.getItem('dp-wishlist') || '[]'); }
    catch { return []; }
  }
  function saveWishlist(list) {
    localStorage.setItem('dp-wishlist', JSON.stringify(list));
  }
  function syncWishlistUI() {
    const list = getWishlist();
    document.querySelectorAll('[data-wishlist-btn]').forEach(btn => {
      const id = btn.dataset.wishlistBtn;
      const icon = btn.querySelector('.material-symbols-outlined');
      btn.classList.toggle('text-red-500', list.includes(id));
      if (icon) icon.style.fontVariationSettings = list.includes(id)
        ? "'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24"
        : "'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 24";
    });
  }

  document.querySelectorAll('[data-wishlist-btn]').forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.preventDefault(); e.stopPropagation();
      const id   = btn.dataset.wishlistBtn;
      let list = getWishlist();
      if (list.includes(id)) {
        list = list.filter(x => x !== id);
        if (typeof showToast === 'function') showToast('Removed from wishlist', 'warning');
      } else {
        list.push(id);
        if (typeof showToast === 'function') showToast('Added to wishlist ♥', 'success');
      }
      saveWishlist(list);
      syncWishlistUI();
    });
  });
  syncWishlistUI();

  /* ─── Product detail: Size selector ────────────────────────── */
  document.querySelectorAll('[data-size-option]').forEach(btn => {
    btn.addEventListener('click', () => {
      const group = btn.dataset.sizeOption;
      document.querySelectorAll(`[data-size-option="${group}"]`).forEach(b => {
        b.classList.remove('bg-[#00C8FF]', 'text-black', 'border-[#00C8FF]');
        b.classList.add('border-current');
      });
      btn.classList.add('bg-[#00C8FF]', 'text-black', 'border-[#00C8FF]');
      // track selection
      const tracker = document.querySelector(`[data-size-selected="${group}"]`);
      if (tracker) tracker.dataset.value = btn.textContent.trim();
    });
  });

  /* ─── Product detail: Qty +/- ───────────────────────────────── */
  document.querySelectorAll('[data-qty-ctrl]').forEach(wrapper => {
    const productId = wrapper.dataset.qtyCtrl;
    const display   = document.getElementById(`qty-${productId}`);
    const max       = parseInt(wrapper.dataset.max || 10);

    wrapper.querySelector('[data-qty-dec]')?.addEventListener('click', () => {
      const v = parseInt(display?.textContent || 1);
      if (display && v > 1) display.textContent = v - 1;
    });
    wrapper.querySelector('[data-qty-inc]')?.addEventListener('click', () => {
      const v = parseInt(display?.textContent || 1);
      if (display && v < max) display.textContent = v + 1;
    });
  });

  /* ─── Image gallery (product detail) ───────────────────────── */
  document.querySelectorAll('[data-thumb]').forEach(thumb => {
    thumb.addEventListener('click', () => {
      const mainImg = document.getElementById('main-product-img');
      if (mainImg) {
        mainImg.src = thumb.dataset.thumb;
        mainImg.classList.add('opacity-0');
        setTimeout(() => mainImg.classList.remove('opacity-0'), 10);
        mainImg.style.transition = 'opacity 0.3s';
      }
    });
  });

  /* ─── Collapsible accordion (product details) ─────────────── */
  document.querySelectorAll('[data-accordion-trigger]').forEach(btn => {
    btn.addEventListener('click', () => {
      const id = btn.dataset.accordionTrigger;
      const panel = document.getElementById(`accordion-${id}`);
      const icon  = btn.querySelector('[data-accordion-icon]');
      panel?.classList.toggle('hidden');
      if (icon) icon.textContent = panel?.classList.contains('hidden') ? 'add' : 'remove';
    });
  });

  /* ─── Flash message auto-dismiss ────────────────────────────── */
  document.querySelectorAll('[data-flash]').forEach(el => {
    setTimeout(() => {
      el.style.opacity = '0';
      el.style.transition = 'opacity 0.5s';
      setTimeout(() => el.remove(), 500);
    }, 5000);
  });

  /* ─── Checkout: payment method toggle ──────────────────────── */
  const codRadio  = document.getElementById('pm-cod');
  const ccRadio   = document.getElementById('pm-credit');
  const ccPanel   = document.getElementById('cc-panel');

  function updatePaymentPanel() {
    const isCOD = codRadio?.checked;
    ccPanel?.classList.toggle('hidden', isCOD);
    if (ccPanel) {
      ccPanel.querySelectorAll('input').forEach(inp => {
        inp.required = !isCOD;
        inp.disabled = isCOD;
      });
    }
  }

  codRadio?.addEventListener('change', updatePaymentPanel);
  ccRadio?.addEventListener('change', updatePaymentPanel);
  updatePaymentPanel();

  /* ─── Contact form: submission feedback ─────────────────────── */
  document.getElementById('contact-form')?.addEventListener('submit', () => {
    const btn = document.getElementById('contact-submit-btn');
    if (btn) {
      btn.textContent = '...';
      btn.disabled = true;
    }
  });

  /* ─── Scroll progress bar ───────────────────────────────────── */
  const progress = document.getElementById('scroll-progress');
  if (progress) {
    window.addEventListener('scroll', () => {
      const scrollTop = document.documentElement.scrollTop;
      const docHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
      progress.style.width = (scrollTop / docHeight * 100) + '%';
    }, { passive: true });
  }

  /* ─── Animate elements on scroll (IntersectionObserver) ──── */
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('opacity-100', 'translate-y-0');
        entry.target.classList.remove('opacity-0', 'translate-y-4');
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.1 });

  document.querySelectorAll('[data-animate]').forEach(el => {
    el.classList.add('opacity-0', 'translate-y-4', 'transition-all', 'duration-500');
    observer.observe(el);
  });

});
