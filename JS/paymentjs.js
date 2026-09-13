// ==================== Checkout page (Task 4) ====================

var checkoutForm = document.getElementById("checkoutForm");

if (checkoutForm) {

    // ---- quantity steppers ----
    document.querySelectorAll(".qty-minus").forEach(function (btn) {
        btn.addEventListener("click", function () {
            var input = btn.parentElement.querySelector(".qty-input");
            var val = parseInt(input.value || "0", 10);
            if (val > 0) {
                input.value = val - 1;
                recalcTotal();
            }
        });
    });

    document.querySelectorAll(".qty-plus").forEach(function (btn) {
        btn.addEventListener("click", function () {
            var input = btn.parentElement.querySelector(".qty-input");
            var max = parseInt(input.getAttribute("max") || "0", 10);
            var val = parseInt(input.value || "0", 10);
            if (val < max) {
                input.value = val + 1;
                recalcTotal();
            }
        });
    });

    document.querySelectorAll(".qty-input").forEach(function (input) {
        input.addEventListener("input", recalcTotal);
    });

    // ---- delivery location toggle ----
    document.querySelectorAll('input[name="delivery_location"]').forEach(function (radio) {
        radio.addEventListener("change", recalcTotal);
    });

    // ---- payment method toggle ----
    var cardFields = document.getElementById("cardFields");
    var mobileFields = document.getElementById("mobileFields");

    document.querySelectorAll('input[name="payment_method"]').forEach(function (radio) {
        radio.addEventListener("change", function () {
            var method = radio.value;
            if (method === "Credit Card") {
                cardFields.style.display = "block";
                mobileFields.style.display = "none";
            } else if (method === "bKash" || method === "Rocket") {
                cardFields.style.display = "none";
                mobileFields.style.display = "block";
            } else {
                cardFields.style.display = "none";
                mobileFields.style.display = "none";
            }
        });
    });

    function getSelectedItems() {
        var items = {};
        document.querySelectorAll(".book-row").forEach(function (row) {
            var bookId = row.getAttribute("data-book-id");
            var qty = parseInt(row.querySelector(".qty-input").value || "0", 10);
            if (qty > 0) {
                items[bookId] = qty;
            }
        });
        return items;
    }

    function recalcTotal() {
        var subtotal = 0;
        document.querySelectorAll(".book-row").forEach(function (row) {
            var price = parseFloat(row.getAttribute("data-price"));
            var qty = parseInt(row.querySelector(".qty-input").value || "0", 10);
            subtotal += price * qty;
        });

        var locationEl = document.querySelector('input[name="delivery_location"]:checked');
        var location = locationEl ? locationEl.value : "inside";
        var deliveryFee = DELIVERY_FEES[location];

        document.getElementById("subtotalDisplay").innerHTML = subtotal.toFixed(2);
        document.getElementById("deliveryDisplay").innerHTML = deliveryFee.toFixed(2);
        document.getElementById("totalDisplay").innerHTML = (subtotal + deliveryFee).toFixed(2);
    }

    recalcTotal();

    // ---- validation ----
    function addressValidation() {
        var address = document.getElementById("address");
        if (address.value.trim() === "") {
            document.getElementById("address-error").innerHTML = "Address cannot be empty";
            return false;
        }
        document.getElementById("address-error").innerHTML = "";
        return true;
    }

    function itemsValidation() {
        var items = getSelectedItems();
        if (Object.keys(items).length === 0) {
            document.getElementById("items-error").innerHTML = "Select at least one book";
            return false;
        }
        document.getElementById("items-error").innerHTML = "";
        return true;
    }

    function paymentFieldsValidation() {
        var method = document.querySelector('input[name="payment_method"]:checked').value;

        if (method === "Credit Card") {
            var cardDigits = document.getElementById("card_number").value.replace(/\D/g, "");
            if (cardDigits.length !== 16) {
                document.getElementById("card-error").innerHTML = "Card number must be 16 digits";
                return false;
            }
            document.getElementById("card-error").innerHTML = "";
            return true;
        }

        if (method === "bKash" || method === "Rocket") {
            var mobile = document.getElementById("mobile_number").value.trim();
            var pin = document.getElementById("mobile_pin").value.trim();
            if (!/^01[0-9]{9}$/.test(mobile)) {
                document.getElementById("mobile-error").innerHTML = "Enter a valid 11-digit BD mobile number";
                return false;
            }
            if (!/^[0-9]{6}$/.test(pin)) {
                document.getElementById("mobile-error").innerHTML = "PIN must be 6 digits";
                return false;
            }
            document.getElementById("mobile-error").innerHTML = "";
            return true;
        }

        return true;
    }

    checkoutForm.addEventListener("submit", function (e) {
        e.preventDefault();

        var addressOk = addressValidation();
        var itemsOk = itemsValidation();
        var paymentOk = paymentFieldsValidation();

        if (!addressOk || !itemsOk || !paymentOk) {
            return false;
        }

        var btn = document.getElementById("placeOrderBtn");
        var formError = document.getElementById("formError");
        btn.disabled = true;
        btn.innerHTML = "Placing order...";
        formError.innerHTML = "";

        var method = document.querySelector('input[name="payment_method"]:checked').value;
        var location = document.querySelector('input[name="delivery_location"]:checked').value;

        var formData = new FormData();
        formData.append("address", document.getElementById("address").value);
        formData.append("delivery_location", location);
        formData.append("payment_method", method);
        formData.append("items", JSON.stringify(getSelectedItems()));

        if (method === "Credit Card") {
            formData.append("card_number", document.getElementById("card_number").value.replace(/\D/g, ""));
        } else if (method === "bKash" || method === "Rocket") {
            formData.append("mobile_number", document.getElementById("mobile_number").value.trim());
            formData.append("mobile_pin", document.getElementById("mobile_pin").value.trim());
        }

        fetch("../control/place_order_control.php", {
            method: "POST",
            body: formData
        })
            .then(function (res) { return res.json(); })
            .then(function (data) {
                if (data.success) {
                    window.location.href = "order_confirmation.php?order_id=" + data.order_id;
                } else {
                    formError.innerHTML = data.message;
                    btn.disabled = false;
                    btn.innerHTML = "Place Order";
                }
            })
            .catch(function () {
                formError.innerHTML = "Something went wrong. Please try again.";
                btn.disabled = false;
                btn.innerHTML = "Place Order";
            });
    });
}

// ==================== Admin order status update (Task 4) ====================

var updateButtons = document.querySelectorAll(".update-status-btn");
updateButtons.forEach(function (btn) {
    btn.addEventListener("click", function () {
        var card = btn.closest(".order-card");
        var orderId = card.getAttribute("data-order-id");
        var status = card.querySelector(".status-select").value;
        var msg = card.querySelector(".status-msg");

        btn.disabled = true;
        msg.innerHTML = "Updating...";

        var formData = new FormData();
        formData.append("order_id", orderId);
        formData.append("status", status);

        fetch("../control/update_status_control.php", {
            method: "POST",
            body: formData
        })
            .then(function (res) { return res.json(); })
            .then(function (data) {
                btn.disabled = false;
                msg.innerHTML = data.success ? "Updated ✔" : data.message;
            })
            .catch(function () {
                btn.disabled = false;
                msg.innerHTML = "Failed to update.";
            });
    });
});
