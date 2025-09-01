// card logic
function recalculateTotal() {
  let sum = 0;
  totalQty = 0;

  document.querySelectorAll("cart-body tr ").forEach(function (tr) {

    const unit = parseFloat(
      (tr.querySelector(".unit")?.textContent || "0").replace(/,/g, "")
    );

    let qty = parseInt(tr.querySelector(".qty")?.value || "0", 10) || 0;

    let line = unit * qty ;

    if(!isNaN(line)) sum += line;
    totalQty += qty;

  });

  const grandTotal = sum.toFixed(2);
  const g1 = document.getElementById('grandTotal');
  const g2 = document.getElementById('sumSubtotal');
  const g3 = document.getElementById('sumGrand');

  if(g1) g1.textContent = grandTotal;
  if(g2) g2.textContent = grandTotal;
  if(g3) g3.textContent = grandTotal;

  if(typeof window.updateNavCartBadge === 'function'){
    window.updateNavCartBadge(totalQty);
  }else{
    var badge = document.getElementById('navCartCount');

    if(badge) badge.textContent = totalQty;
  }

}

// qty change + ajax update Ui update re Calculation

document.addEventListener('input', function(e){
    
    const qtyInput = e.target.closest('#cart-body .qty');

    if(!qtyInput) return;

    const tr = qtyInput.closest('tr');
    const itemId = tr?.getAttribute('data-item-id');

    let qty = parseInt(qtyInput.value,10);

    if(!qty && qty < 1) qty = 1;
    qtyInput.value = qty;
    qtyInput.disabled = true;

    fetch('ajax/cart_update_qty.php',{
        method: "POST",
        headers: {"Content-Type": "application/x-www.form-urlencode"},
        credentials: 'same-origin',
        body: "item_id"+ encodeURIComponent(itemId)+'&qty'+encodeURIComponent(qty)
    }).then(r => r.json()).then(d => {
        const unit = parseFloat((tr.querySelector('.unit')?.textContent || '0').replace(/,/g, ""));
        tr.querySelector('line-total').textContent = (unit * qty).toFixed(2);
        recalculateTotal();
    }).catch(() => {}).finally(() => {qtyInput.disabled = false;}
   );

});

// remove item  ajax + ui remove + total

document.addEventListener('click', function(e){

  const btn = e.target.closest('#card-body .remove');
  if(!btn) return;
  const tr = btn.closest('tr');
  const itemId = tr?.getAttribute('data-item-id');

  fetch('ajax/cart_remove_item.php',{

    method: 'POST',
    headers: {"Content-Type": "application/x-www.form-urlencode"},
    credentials: 'same-origin',
    body: "item_id"+ encodeURIComponent(itemId)
  }).then(r => r.json()).then(d => {

    tr.parentNode.removeChild(tr);
    recalculateTotal();

    if(!document.querySelectorAll('#card-body tr').length){
      location.reload();
    }
  }).catch(()=> {});

});


