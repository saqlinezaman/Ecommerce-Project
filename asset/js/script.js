// recalculate grand total
function recalculateTotal() {
  let sum = 0;
  let totalQty = 0;

  // fixed selector with #cart-body
  document.querySelectorAll("#cart-body tr").forEach(function(tr) {
    const unit = parseFloat((tr.querySelector(".unit")?.textContent || "0").replace(/,/g, ""));
    let qty = parseInt(tr.querySelector(".qty")?.value || "0", 10) || 0;
    sum += unit * qty;
    totalQty += qty;

    // update line total in table
    const lineTotalEl = tr.querySelector(".line-total");
    if(lineTotalEl) lineTotalEl.textContent = (unit * qty).toFixed(2);
  });

  const grandTotal = sum.toFixed(2);

  // update totals in summary
  document.getElementById("grandTotal").textContent = grandTotal;
  document.getElementById("sumSubtotal").textContent = grandTotal;
  document.getElementById("sumGrand").textContent = grandTotal;

  // update nav cart badge if exists
  const badge = document.getElementById("navCartCount");
  if(badge) badge.textContent = totalQty;
}

// quantity input change (Ajax update + UI)
document.addEventListener('input', function(e){
    const qtyInput = e.target.closest('#cart-body .qty');
    if(!qtyInput) return;

    const tr = qtyInput.closest('tr');
    const itemId = tr?.getAttribute('data-item-id');
    let qty = parseInt(qtyInput.value,10);
    if(!qty || qty < 1) qty = 1;
    qtyInput.value = qty;
    qtyInput.disabled = true;

    fetch('ajax/cart_update_qty.php', {
        method: "POST",
        headers: {"Content-Type": "application/x-www-form-urlencoded"},
        credentials: 'same-origin',
        body: "item_id=" + encodeURIComponent(itemId) + "&qty=" + encodeURIComponent(qty)
    })
    .then(r => r.json())
    .then(d => {
        if(d.ok && d.line_total){
            tr.querySelector('.line-total').textContent = d.line_total;
            recalculateTotal();  // update grand total
        }
    })
    .finally(() => { qtyInput.disabled = false; });
});


// remove item from cart
document.addEventListener('click', function(e){
  const btn = e.target.closest('#cart-body .remove');
  if(!btn) return;
  const tr = btn.closest('tr');
  const itemId = tr?.getAttribute('data-item-id');

  fetch('ajax/cart_remove_item.php', {
    method: "POST",
    headers: {"Content-Type": "application/x-www-form-urlencoded"},
    body: "item_id=" + encodeURIComponent(itemId)
  })
  .then(r => r.json())
  .then(d => {
    if(d.ok){
      tr.remove();
      recalculateTotal();
      if(!document.querySelectorAll('#cart-body tr').length){
        location.reload();
      }
    }
  });
});
