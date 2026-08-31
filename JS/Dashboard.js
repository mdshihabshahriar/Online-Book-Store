function removeCustomer(customerId) {
    if (confirm("Are you sure you want to remove this customer?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "../control/customercontrol.php?action=delete&id=" + customerId, true);
        
        xhr.onload = function() {
            if (this.status === 200) {
                var row = document.getElementById("row-" + customerId);
                if (row) {
                    row.remove();
                }
                alert("Customer removed successfully.");
            } else {
                alert("Failed to remove customer.");
            }
        };
        
        xhr.send();
    }
}