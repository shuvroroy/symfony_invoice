function getProductById(identifier, id) {
    if (id == '') {
        document.querySelector('#invoice_invoiceItems_'+ identifier +'_description').value = '';
        document.querySelector('#invoice_invoiceItems_'+ identifier +'_unitPrice').value = '';
        return;
    }
    let url = `http://localhost:8000/api/products/${id}`;
    let request = new Request(url, { method: 'GET' });
    fetch(request)
        .then(response => response.json())
        .then(response => {
            let product = JSON.parse(response.data);
            document.querySelector('#invoice_invoiceItems_'+ identifier +'_description').value = product.description;
            document.querySelector('#invoice_invoiceItems_'+ identifier +'_unitPrice').value = product.unitPrice;
        })
        .catch(error => {
            console.log(error);
        });
}
function addProductRow(parent, child) {
    let index = parent.querySelectorAll('tr').length;
    child = child.replace(/__name__/g, (index - 1));
    parent.insertAdjacentHTML('beforeend', child);
}

function deleteProductRow(element) {
    document.querySelector('#row-'+ element.id).remove();
    calculateSubTotal();
    calculateDiscount();
    calculateBalanceDue();
}

function updateDescriptionAndUnitPrice(element) {
    getProductById(element.dataset.id, element.value);
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
function updateAll() {
    
}