document.addEventListener('DOMContentLoaded', function() {
    setCurrentDateTime();

    document.querySelectorAll('.editBtn').forEach(function(button) {
        button.addEventListener('click', function() {
            var row = button.closest('tr');
            toggleEdit(row);
        });
    });
});

function setCurrentDateTime() {
    var now = new Date();
    var year = now.getFullYear();
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var day = ("0" + now.getDate()).slice(-2);
    var hours = ("0" + now.getHours()).slice(-2);
    var minutes = ("0" + now.getMinutes()).slice(-2);
    var datetimeLocal = `${year}-${month}-${day}T${hours}:${minutes}`;
    
    document.getElementById('entryDate').value = datetimeLocal;
}

function toggleEdit(row) {
    var inputs = row.querySelectorAll('input, select');

    inputs.forEach(function(input) {
        if (input.hasAttribute('readonly')) {
            input.removeAttribute('readonly');
        } else if (!input.readOnly && input.type !== 'text') {
            input.readOnly = false;
        }

        if (input.tagName.toLowerCase() === 'select') {
            input.disabled = !input.disabled;
        }
    });
}

function calculateTotal(exitInput) {
    var row = exitInput.closest('tr');
    var entryDate = row.querySelector('input[name="entryDate[]"]').value;
    var exitDate = exitInput.value;
    var vehicleType = row.querySelector('select[name="vehicleType[]"]').value;
    var totalAmountInput = row.querySelector('input[name="totalAmount[]"]');

    if (entryDate && exitDate) {
        var entryTime = new Date(entryDate);
        var exitTime = new Date(exitDate);
        var minutes = Math.floor((exitTime - entryTime) / (1000 * 60));

        var total;
        if (vehicleType === '1') { 
            total = minutes * 1.00;
        } else if (vehicleType === '2') {
            total = minutes * 3.00;
        } else { 
            total = 0;
        }

        totalAmountInput.value = `$${total.toFixed(2)}`;
    }
}

function handleSubmit() {
    var form = document.getElementById('parkingForm');
    
    fetch(form.action, {
        method: 'POST',
        body: new FormData(form)
    })
    .then(response => response.text())
    .then(result => {
        console.log(result); 
    })
    .catch(error => console.error('Error:', error));

    return false;
}
