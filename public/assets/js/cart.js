/**
 * cart.js — Deepify
 * Handles: add, remove, update qty, badge update, toast, JSON responses
 */

/* ─── Helpers ───────────────────────────────────────────────── */
function getCsrfToken() {
  return document.querySelector('meta[name="csrf-token"]')?.content || '';
}

function showToast(message, type = 'success') {
  const container = document.getElementById('toast-container');
  if (!container) return;
  const toast = document.createElement('div');
  toast.className = `toast ${type}`;
  toast.innerHTML = `
    <div class="flex items-center gap-2">
      <span class="material-symbols-outlined text-sm">
        ${type === 'success' ? 'check_circle' : type === 'error' ? 'error' : 'warning'}
      </span>
      <span>${message}</span>
    </div>`;
  container.appendChild(toast);
  requestAnimationFrame(() => toast.classList.add('show'));
  setTimeout(() => {
    toast.classList.remove('show');
    setTimeout(() => toast.remove(), 350);
  }, 3200);
}

function updateCartBadge(count) {
  document.querySelectorAll('[data-cart-count]').forEach(el => {
    el.textContent = count;
    el.classList.toggle('hidden', count <= 0);
  });
}

function setButtonLoading(btn, loading) {
  if (!btn) return;
  if (loading) {
    btn.dataset.originalText = btn.innerHTML;
    btn.innerHTML = '<span class="material-symbols-outlined text-sm animate-spin">sync</span>';
    btn.disabled = true;
  } else {
    btn.innerHTML = btn.dataset.originalText || btn.innerHTML;
    btn.disabled = false;
  }
}

/* ─── Add to Cart ───────────────────────────────────────────── */
async function addToCart(productId, quantity = 1, selectedSize = '', selectedColor = '') {
  const btn = document.querySelector(`[data-add-cart="${productId}"]`);
  setButtonLoading(btn, true);

  try {
    const res = await fetch('/cart/add', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': getCsrfToken(),
        'Accept': 'application/json',
      },
      body: JSON.stringify({ product_id: productId, quantity, selected_size: selectedSize, selected_color: selectedColor }),
    });

    const data = await res.json();
    if (data.success) {
      updateCartBadge(data.cart_count);
      showToast(data.message, 'success');
    } else {
      showToast(data.message || 'Failed to add item.', 'error');
    }
  } catch (err) {
    showToast('Connection error. Please try again.', 'error');
  } finally {
    setButtonLoading(btn, false);
  }
}

/* ─── Remove from Cart ──────────────────────────────────────── */
async function removeFromCart(key, rowEl) {
  try {
    const res = await fetch('/cart/remove', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': getCsrfToken(),
        'Accept': 'application/json',
      },
      body: JSON.stringify({ key }),
    });

    const data = await res.json();
    if (data.success) {
      rowEl?.remove();
      updateCartBadge(data.cart_count);
      updateCartTotals(data);
      if (data.is_empty) showEmptyCart();
      showToast('Item removed from cart.', 'success');
    }
  } catch (err) {
    showToast('Failed to remove item.', 'error');
  }
}

/* ─── Update Quantity ───────────────────────────────────────── */
async function updateQuantity(key, quantity, subtotalEl) {
  if (quantity < 1 || quantity > 10) return;

  try {
    const res = await fetch('/cart/update', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': getCsrfToken(),
        'Accept': 'application/json',
      },
      body: JSON.stringify({ key, quantity }),
    });

    const data = await res.json();
    if (data.success) {
      // Update row subtotal
      if (subtotalEl) {
        const price = parseFloat(subtotalEl.dataset.price || 0);
        subtotalEl.textContent = `$${(price * quantity).toFixed(2)}`;
      }
      updateCartBadge(data.cart_count);
      updateCartTotals(data);
    }
  } catch (err) {
    showToast('Failed to update quantity.', 'error');
  }
}

/* ─── Update totals in the summary panel ───────────────────── */
function updateCartTotals(data) {
  const sel = id => document.getElementById(id);
  const formatBoth = (val) => {
    const dec = parseFloat(val);
    if (isNaN(dec)) return '$' + val;
    // Format USD and EGP formally
    return `<span class='inline-flex flex-col items-end leading-[1.1]'><span class='font-headline'>$${dec.toFixed(2)}</span><span class='text-[9px] text-[var(--text-muted)] font-label tracking-wide opacity-80 mt-0.5 whitespace-nowrap'>${(dec * 48).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})} EGP</span></span>`;
  };

  if (sel('cart-subtotal')) sel('cart-subtotal').innerHTML = formatBoth(data.subtotal);
  if (sel('cart-shipping')) {
    const isFree = parseFloat(data.shipping) === 0;
    sel('cart-shipping').innerHTML = isFree ? (document.documentElement.lang === 'ar' ? 'مجاني' : 'FREE') : formatBoth(data.shipping);
    sel('cart-shipping').classList.toggle('text-green-500', isFree);
  }
  if (sel('cart-tax'))   sel('cart-tax').innerHTML   = formatBoth(data.tax);
  if (sel('cart-total')) sel('cart-total').innerHTML = formatBoth(data.total);
}

/* ─── Empty cart UI ─────────────────────────────────────────── */
function showEmptyCart() {
  const cartContent = document.getElementById('cart-content');
  const emptyState  = document.getElementById('cart-empty');
  if (cartContent) cartContent.classList.add('hidden');
  if (emptyState)  emptyState.classList.remove('hidden');
}

/* ─── Cart page: wire up events ─────────────────────────────── */
document.addEventListener('DOMContentLoaded', () => {
  // Remove buttons
  document.querySelectorAll('[data-remove-key]').forEach(btn => {
    btn.addEventListener('click', () => {
      const key = btn.dataset.removeKey;
      const row = btn.closest('[data-cart-row]');
      removeFromCart(key, row);
    });
  });

  // Qty +/- buttons
  document.querySelectorAll('[data-qty-btn]').forEach(btn => {
    btn.addEventListener('click', () => {
      const key        = btn.dataset.key;
      const dir        = btn.dataset.qtyBtn; // 'inc' or 'dec'
      const display    = btn.closest('[data-cart-row]')?.querySelector('[data-qty-display]');
      const subtotalEl = btn.closest('[data-cart-row]')?.querySelector('[data-subtotal]');
      if (!display) return;
      let qty = parseInt(display.textContent) + (dir === 'inc' ? 1 : -1);
      qty = Math.max(1, Math.min(10, qty));
      display.textContent = qty;
      updateQuantity(key, qty, subtotalEl);
    });
  });

  // "Add to Cart" product card buttons
  document.querySelectorAll('[data-add-cart]').forEach(btn => {
    btn.addEventListener('click', () => {
      const id  = btn.dataset.addCart;
      const qty = parseInt(document.getElementById(`qty-${id}`)?.textContent || '1');
      const sz  = document.querySelector(`[data-size-selected="${id}"]`)?.dataset.value || '';
      const cl  = document.querySelector(`[data-color-selected="${id}"]`)?.dataset.value || '';
      addToCart(id, qty, sz, cl);
    });
  });
});
