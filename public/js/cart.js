// public/js/cart.js
console.log('[CART] script loaded (public/js/cart.js)');

window.addEventListener('DOMContentLoaded', () => {
  console.log('[CART] DOMContentLoaded');

  const ROUTES = (window.Laravel && window.Laravel.routes) || {};
  const CSRF   = (window.Laravel && window.Laravel.csrfToken) || (document.querySelector('meta[name="csrf-token"]')?.content || '');
  const APP    = window.App || { isAuth:false, routes:{} };

  const badge       = document.getElementById('cartBadge');
  const itemsBox    = document.getElementById('cartItems');
  const totalBox    = document.getElementById('cartTotal');
  const offcanvasEl = document.getElementById('cartOffcanvas');
  const offcanvas   = offcanvasEl ? new bootstrap.Offcanvas(offcanvasEl) : null;

  function isJsonResponse(res){ return (res.headers.get('content-type')||'').includes('application/json'); }
  function currency(n){ const v=Number.isFinite(n)?n:0; try{return new Intl.NumberFormat('es-PE',{style:'currency',currency:'PEN'}).format(v);}catch{return `S/ ${v.toFixed(2)}`;} }

  async function api(url, method='GET', data=null){
    console.log('[CART] fetch', method, url, data);
    const res = await fetch(url, {
      method,
      headers: {'Accept':'application/json','X-CSRF-TOKEN':CSRF, ...(data?{'Content-Type':'application/json'}:{})},
      body: data ? JSON.stringify(data) : null
    });
    if (!isJsonResponse(res)) { const t=await res.text(); throw new Error(`No JSON (${res.status}) ${t.slice(0,120)}`); }
    if (!res.ok) { const j=await res.json().catch(()=>({})); throw new Error(j.message || `HTTP ${res.status}`); }
    return await res.json();
  }

  function render(cart){
    console.log('[CART] render', cart);
    if (badge)    badge.textContent = cart?.count ?? 0;
    if (totalBox) totalBox.textContent = currency(cart?.total ?? 0);
    if (!itemsBox) return;
    itemsBox.innerHTML = '';
    const entries = Object.values(cart?.items || {});
    if (!entries.length){ itemsBox.innerHTML = '<div class="text-muted small">Tu carrito está vacío.</div>'; return; }
    entries.forEach(it=>{
      const price = Number(it.price)||0, qty=Number(it.qty)||0;
      const d=document.createElement('div');
      d.className='list-group-item py-3';
      d.innerHTML=`
        <div class="d-flex gap-2">
          <img src="${it.image ?? 'https://via.placeholder.com/60'}" class="rounded" width="60" height="60" alt="">
          <div class="flex-grow-1">
            <a href="${it.url ?? '#'}" class="text-decoration-none fw-semibold">${it.name}</a>
            <div class="small text-muted">Precio: ${currency(price)}</div>
            <div class="d-flex align-items-center gap-2 mt-2">
              <button class="btn btn-sm btn-outline-secondary btn-dec" data-id="${it.rowId}">-</button>
              <input class="form-control form-control-sm qty-input" data-id="${it.rowId}" style="width:64px" type="number" min="1" value="${qty}">
              <button class="btn btn-sm btn-outline-secondary btn-inc" data-id="${it.rowId}">+</button>
              <span class="ms-auto fw-semibold">${currency(price * qty)}</span>
              <button class="btn btn-sm btn-outline-danger ms-2 btn-remove" data-id="${it.rowId}">
                <i class="bi bi-trash"></i>
              </button>
            </div>
          </div>
        </div>`;
      itemsBox.appendChild(d);
    });
  }

  // cargar estado inicial
  ROUTES.index && api(ROUTES.index).then(render).catch(err=>console.error('[CART] init error', err));

  // agregar
  document.addEventListener('click', async (e)=>{
    const btn = e.target.closest('.btn-add-to-cart, [data-add-to-cart]');
    if (!btn) return;
    e.preventDefault(); e.stopPropagation();
    console.log('[CART] add click', btn.dataset);

    if (!ROUTES.add) { console.error('[CART] missing ROUTES.add'); return; }

    const prevHtml = btn.innerHTML; btn.disabled = true;
    btn.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span>Añadiendo...`;

    const rawVariant = btn.dataset.variant; let variant = null;
    if (rawVariant){ try{ variant = JSON.parse(rawVariant); }catch{ variant = rawVariant; } }

    const payload = {
      id: btn.dataset.id,
      name: btn.dataset.name,
      price: Number.parseFloat(btn.dataset.price) || 0,
      qty: Math.max(1, Number.parseInt(btn.dataset.qty || '1',10)),
      image: btn.dataset.image || null,
      url: btn.dataset.url || null,
      variant
    };

    try{
      const cart = await api(ROUTES.add,'POST',payload);
      render(cart);
      offcanvas?.show();
      console.log('[CART] added ok');
    }catch(err){
      console.error('[CART] add error', err);
      alert('No se pudo agregar al carrito. Revisa la consola.');
    }finally{
      btn.disabled = false;
      btn.innerHTML = prevHtml;
    }
  });

  // acciones en el panel
  itemsBox?.addEventListener('click', async (e)=>{
    const inc=e.target.closest('.btn-inc'); const dec=e.target.closest('.btn-dec'); const rm=e.target.closest('.btn-remove');
    try{
      if ((inc||dec) && ROUTES.base){
        const id=(inc||dec).dataset.id;
        const input=itemsBox.querySelector(`.qty-input[data-id="${id}"]`);
        let qty=parseInt(input?.value||'1',10); qty=inc?qty+1:Math.max(1,qty-1);
        const cart=await api(`${ROUTES.base}/${id}`,'PATCH',{qty}); render(cart);
      }
      if (rm && ROUTES.base){
        const id=rm.dataset.id; const cart=await api(`${ROUTES.base}/${id}`,'DELETE'); render(cart);
      }
    }catch(err){ console.error('[CART] item action error', err); }
  });

  itemsBox?.addEventListener('change', async (e)=>{
    const input=e.target.closest('.qty-input'); if (!input || !ROUTES.base) return;
    let qty=Math.max(1, parseInt(input.value||'1',10));
    try{ const cart=await api(`${ROUTES.base}/${input.dataset.id}`,'PATCH',{qty}); render(cart); }
    catch(err){ console.error('[CART] qty change error', err); }
  });

  document.getElementById('btnClearCart')?.addEventListener('click', async (e)=>{
    e.preventDefault();
    if (!ROUTES.clear) return;
    try{ const cart=await api(ROUTES.clear,'DELETE'); render(cart); }
    catch(err){ console.error('[CART] clear error', err); }
  });
  
});
