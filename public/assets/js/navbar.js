/**
 * navbar.js — Deepify
 * Handles: sticky nav, mobile drawer, dark/light toggle, EN/AR toggle, active links
 */

/* ─── i18n Strings ─────────────────────────────────────────── */
const i18n = {
  en: {
    'home':'Home','shop':'Shop','cart':'Cart','about':'About','contact':'Contact Us',
    'search-placeholder':'Search products...','brand-tagline':'Wear the Future.',
    'hero-tag':'NEW COLLECTION','hero-title':'Wear the Future.',
    'hero-sub':'Engineered for the next dimension of style.',
    'shop-now':'Shop Now','explore':'Explore Collections',
    'featured':'Featured Products','categories':'Collections',
    'add-to-cart':'Add to Cart','out-of-stock':'Out of Stock',
    'in-stock':'In Stock','on-sale':'Sale','new':'New',
    'products-count':'Showing {n} products','sort-by':'Sort by',
    'price-low':'Price: Low to High','price-high':'Price: High to Low',
    'newest':'Newest','featured-sort':'Featured','all-categories':'All',
    'filter':'Filter','wishlist':'Wishlist','related':'You Might Also Like',
    'size':'Size','color':'Color','qty':'Quantity',
    'your-cart':'Your Cart','empty-cart':'Your cart is empty',
    'empty-cart-sub':'Discover our products and start shopping',
    'cart-item':'Item','cart-price':'Price','cart-qty':'Qty',
    'cart-subtotal':'Subtotal','remove':'Remove',
    'subtotal':'Subtotal','shipping':'Shipping','tax':'Tax (8%)','total':'Total',
    'proceed':'Proceed to Checkout','continue-shopping':'Continue Shopping',
    'free':'FREE','free-ship-promo':'Free shipping on orders over $100',
    'checkout':'Checkout','full-name':'Full Name','email':'Email Address',
    'phone':'Phone Number','address':'Street Address','city':'City',
    'country':'Country','zip':'ZIP / Postal Code',
    'payment':'Payment Method','cod':'Cash on Delivery',
    'credit-card':'Credit Card','coming-soon':'Coming Soon',
    'notes':'Order Notes (optional)','place-order':'Place Order',
    'order-summary':'Order Summary',
    'order-success':'Order Placed Successfully!',
    'order-thanks':'Thank you, {name}! Your order #{id} has been placed.',
    'order-note':"You'll receive a confirmation email shortly.",
    'about-us':'About Us','our-story':'Our Story',
    'our-values':'Our Values','our-team':'Our Team',
    'contact-us':'Contact Us','name':'Name','subject':'Subject',
    'message':'Your Message','send':'Send Message',
    'newsletter':'Join our newsletter',
    'newsletter-sub':'Get updates on new drops, exclusive offers, and more.',
    'subscribe':'Subscribe',
    'copyright':'© 2024 Deepify. All rights reserved.',
    'free-shipping':'FREE SHIPPING','returns':'FREE RETURNS',
    'secure':'SECURE CHECKOUT','worldwide':'WORLDWIDE DELIVERY',
    'dark-mode':'Dark Mode','light-mode':'Light Mode',
    'lang-toggle':'العربية','breadcrumb-home':'Home',
    'breadcrumb-shop':'Shop',
  },
  ar: {
    'home':'الرئيسية','shop':'المتجر','cart':'السلة','about':'من نحن','contact':'اتصل بنا',
    'search-placeholder':'ابحث عن المنتجات...','brand-tagline':'ارتدِ المستقبل.',
    'hero-tag':'مجموعة جديدة','hero-title':'ارتدِ المستقبل.',
    'hero-sub':'مصمم للبعد القادم من الأناقة.',
    'shop-now':'تسوق الآن','explore':'استكشف المجموعات',
    'featured':'المنتجات المميزة','categories':'المجموعات',
    'add-to-cart':'أضف إلى السلة','out-of-stock':'غير متوفر',
    'in-stock':'متوفر','on-sale':'تخفيض','new':'جديد',
    'products-count':'عرض {n} منتجاً','sort-by':'ترتيب حسب',
    'price-low':'السعر: من الأقل','price-high':'السعر: من الأعلى',
    'newest':'الأحدث','featured-sort':'المميزة','all-categories':'الكل',
    'filter':'تصفية','wishlist':'المفضلة','related':'قد يعجبك أيضاً',
    'size':'المقاس','color':'اللون','qty':'الكمية',
    'your-cart':'سلتك','empty-cart':'سلتك فارغة',
    'empty-cart-sub':'اكتشف منتجاتنا وابدأ التسوق',
    'cart-item':'المنتج','cart-price':'السعر','cart-qty':'الكمية',
    'cart-subtotal':'الإجمالي','remove':'حذف',
    'subtotal':'المجموع الفرعي','shipping':'الشحن','tax':'الضريبة (8%)','total':'الإجمالي',
    'proceed':'المتابعة للدفع','continue-shopping':'مواصلة التسوق',
    'free':'مجاني','free-ship-promo':'شحن مجاني للطلبات فوق 100$',
    'checkout':'إتمام الشراء','full-name':'الاسم الكامل','email':'البريد الإلكتروني',
    'phone':'رقم الهاتف','address':'عنوان الشارع','city':'المدينة',
    'country':'الدولة','zip':'الرمز البريدي',
    'payment':'طريقة الدفع','cod':'الدفع عند الاستلام',
    'credit-card':'بطاقة ائتمان','coming-soon':'قريباً',
    'notes':'ملاحظات الطلب (اختياري)','place-order':'تأكيد الطلب',
    'order-summary':'ملخص الطلب',
    'order-success':'تم تقديم الطلب بنجاح!',
    'order-thanks':'شكراً، {name}! تم تقديم طلبك رقم #{id}.',
    'order-note':'ستتلقى رسالة تأكيد على بريدك الإلكتروني.',
    'about-us':'من نحن','our-story':'قصتنا',
    'our-values':'قيمنا','our-team':'فريقنا',
    'contact-us':'اتصل بنا','name':'الاسم','subject':'الموضوع',
    'message':'رسالتك','send':'إرسال الرسالة',
    'newsletter':'اشترك في نشرتنا',
    'newsletter-sub':'احصل على تحديثات حول المجموعات الجديدة والعروض الحصرية.',
    'subscribe':'اشترك',
    'copyright':'© 2024 ديبيفاي. جميع الحقوق محفوظة.',
    'free-shipping':'شحن مجاني','returns':'إرجاع مجاني',
    'secure':'دفع آمن','worldwide':'توصيل عالمي',
    'dark-mode':'الوضع الداكن','light-mode':'الوضع الفاتح',
    'lang-toggle':'English','breadcrumb-home':'الرئيسية',
    'breadcrumb-shop':'المتجر',
  }
};

/* ─── State ─────────────────────────────────────────────────── */
let currentLang  = localStorage.getItem('dp-lang')  || 'en';
let currentTheme = localStorage.getItem('dp-theme') || 'dark';

/* ─── Apply theme & lang immediately (also done inline in <head>) */
function applyTheme(theme) {
  currentTheme = theme;
  document.documentElement.classList.toggle('dark', theme === 'dark');
  localStorage.setItem('dp-theme', theme);
  // update toggle icons and labels
  document.querySelectorAll('[data-theme-icon]').forEach(icon => {
    icon.textContent = theme === 'dark' ? 'light_mode' : 'dark_mode';
  });
  document.querySelectorAll('[data-theme-label]').forEach(label => {
    label.textContent = i18n[currentLang][theme === 'dark' ? 'light-mode' : 'dark-mode'];
  });
}

function applyLang(lang) {
  currentLang = lang;
  document.documentElement.setAttribute('lang', lang);
  document.documentElement.setAttribute('dir', lang === 'ar' ? 'rtl' : 'ltr');
  localStorage.setItem('dp-lang', lang);

  // update all [data-i18n] elements
  document.querySelectorAll('[data-i18n]').forEach(el => {
    const key = el.getAttribute('data-i18n');
    if (i18n[lang][key] !== undefined) {
      if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') {
        el.placeholder = i18n[lang][key];
      } else {
        el.textContent = i18n[lang][key];
      }
    }
  });

  // update lang toggle buttons
  document.querySelectorAll('[data-lang-toggle]').forEach(btn => {
    btn.textContent = i18n[lang]['lang-toggle'];
  });

  // update document direction on specific elements
  document.querySelectorAll('[data-i18n-placeholder]').forEach(el => {
    const key = el.getAttribute('data-i18n-placeholder');
    if (i18n[lang][key]) el.placeholder = i18n[lang][key];
  });

  // mirror: swap text on search placeholder
  const searchInput = document.getElementById('nav-search');
  if (searchInput) searchInput.placeholder = i18n[lang]['search-placeholder'];
}

/* ─── DOM Ready ──────────────────────────────────────────────── */
document.addEventListener('DOMContentLoaded', () => {
  // Apply saved preferences
  applyTheme(currentTheme);
  applyLang(currentLang);

  /* ── Sticky nav ──────────────────────────────────────────── */
  const nav = document.getElementById('main-nav');
  let lastY = 0;
  window.addEventListener('scroll', () => {
    const y = window.scrollY;
    if (nav) {
      nav.classList.toggle('shadow-lg', y > 10);
      // hide on scroll down, show on scroll up (optional UX)
      // nav.style.transform = (y > lastY && y > 60) ? 'translateY(-100%)' : 'translateY(0)';
    }
    lastY = y;
  }, { passive: true });

  /* ── Mobile drawer ───────────────────────────────────────── */
  const menuBtn    = document.getElementById('mobile-menu-btn');
  const drawer     = document.getElementById('mobile-drawer');
  const overlay    = document.getElementById('drawer-overlay');
  const closeBtn   = document.getElementById('drawer-close-btn');

  function openDrawer() {
    drawer?.classList.add('open');
    overlay?.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
  }
  function closeDrawer() {
    drawer?.classList.remove('open');
    overlay?.classList.add('hidden');
    document.body.style.overflow = '';
  }
  menuBtn?.addEventListener('click', openDrawer);
  closeBtn?.addEventListener('click', closeDrawer);
  overlay?.addEventListener('click', closeDrawer);

  /* ── Theme toggle ────────────────────────────────────────── */
  document.querySelectorAll('[data-theme-toggle]').forEach(btn => {
    btn.addEventListener('click', () => {
      applyTheme(currentTheme === 'dark' ? 'light' : 'dark');
    });
  });

  /* ── Language toggle ─────────────────────────────────────── */
  document.querySelectorAll('[data-lang-toggle]').forEach(btn => {
    btn.addEventListener('click', () => {
      applyLang(currentLang === 'en' ? 'ar' : 'en');
    });
  });

  /* ── Active link highlighting ─────────────────────────────── */
  const path = window.location.pathname;
  document.querySelectorAll('[data-nav-link]').forEach(a => {
    const href = a.getAttribute('href') || '';
    const active =
      (href === '/' && path === '/') ||
      (href !== '/' && path.startsWith(href));
    a.classList.toggle('text-[#00C8FF]', active);
    a.classList.toggle('dark:text-[#00C8FF]', active);
  });

  /* ── Mobile search toggle ─────────────────────────────────── */
  document.getElementById('mobile-search-btn')?.addEventListener('click', () => {
    const bar = document.getElementById('mobile-search-bar');
    bar?.classList.toggle('hidden');
    bar?.querySelector('input')?.focus();
  });
});
