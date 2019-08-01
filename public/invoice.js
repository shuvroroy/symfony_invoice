function addProductRow(parent, child) {
    let index = parent.querySelectorAll('tr').length + 1;
    child = child.replace(/__name__/g, index);
    parent.insertAdjacentHTML('beforeend', child);
}

function deleteProductRow(element) {
    document.querySelector('#row-'+ element.id).remove();
    calculateSubTotal();
    calculateDiscount();
    calculateBalanceDue();
}

function updateDescriptionAndUnitPrice(element) {
    let identifier = element.dataset.id;
    let products = JSON.parse(document.querySelector('#products_data').dataset.products);
    let selectProduct = products.filter(product => {
        return product.id == element.value;
    });

    document.querySelector('#invoice_invoiceItems_'+ identifier +'_description').value = selectProduct.length ? selectProduct[0].description : '' ;
    document.querySelector('#invoice_invoiceItems_'+ identifier +'_unitPrice').value = selectProduct.length ? selectProduct[0].unitPrice : '';

    calculateLineTotal(element);
    calculateDiscount();
    calculateBalanceDue();
}

function calculateLineTotal(element) {
    let lineTotal = '';
    let id = element.id.split('_')[2];
    let qty = document.querySelector('#invoice_invoiceItems_'+ id +'_qty').value;
    let price = document.querySelector('#invoice_invoiceItems_'+ id +'_unitPrice').value;

    if (qty !== '' && price !== '') {
        lineTotal = (qty * price).toFixed(2);
    }

    document.querySelector('#invoice_invoiceItems_'+ id +'_lineTotal').value = lineTotal;

    calculateSubTotal();
    calculateDiscount();
    calculateBalanceDue();
    calculateTotal();
}

function calculateSubTotal() {
    let subTotal = 0.00;
    document.querySelectorAll('.lineTotal').forEach(item => {
        if (item.value === '') return;
        subTotal = subTotal + parseFloat(item.value);
    });

    document.querySelector('#subTotal').textContent = subTotal.toFixed(2);
    document.querySelector('#invoice_sub_total').value = subTotal.toFixed(2);
}

function calculateDiscount() {
    let element = document.querySelector('#invoice_discount');
    let subtotal = document.querySelector('#subTotal').textContent;
    if (subtotal === '') {
        document.querySelector('#discount').textContent = "0.00";
        return;
    }

    let discountPercent = element.value;
    if (discountPercent === '' || discountPercent === undefined) {
        document.querySelector('#discount').textContent = "0.00";
        calculateBalanceDue();
        return;
    }

    let discount = (parseFloat(subtotal)/100) * parseFloat(discountPercent);
    document.querySelector('#discount').textContent = discount.toFixed(2);
    calculateBalanceDue();
    calculateTotal();
}

function calculateBalanceDue()
{
    let deposit = parseFloat(document.querySelector('#invoice_deposit').value);
    let subTotal = parseFloat(document.querySelector('#subTotal').textContent);
    let discount = parseFloat(document.querySelector('#discount').textContent);
    if (deposit === '' || isNaN(deposit)) return;
    let dueAmount = subTotal - deposit -discount;
    document.querySelector('#balanceDue').textContent = dueAmount.toFixed(2);
}

function calculateTotal() {
    let subTotal = parseFloat(document.querySelector('#subTotal').textContent);
    let discount = parseFloat(document.querySelector('#discount').textContent);

    let total = subTotal - discount;
    document.querySelector('#grandTotal').textContent = total.toFixed(2);
    document.querySelector('#invoice_total').value = total.toFixed(2);
}

document.addEventListener('DOMContentLoaded', function(){
    let addMore = document.querySelector('#addRow');
    let parent = document.querySelector('#parentInvoice');
    let child = parent.dataset.child;

    addProductRow(parent, child);
    addMore.addEventListener('click', function (e) {
        addProductRow(parent, child);
    });
});