function changeOrderStatus(orderId, newStatus) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "../control/ordercontrol.php?action=update_status&id=" + orderId + "&status=" + newStatus, true);

    xhr.onload = function() {
        if (this.status === 200) {
            var statusTag = document.getElementById("status-" + orderId);
            if (statusTag) {
                statusTag.innerText = newStatus.toUpperCase();
            }
            alert("Order #" + orderId + " status updated to " + newStatus.toUpperCase());
        } else {
            alert("Failed to update order status.");
        }
    };

    xhr.send();
}