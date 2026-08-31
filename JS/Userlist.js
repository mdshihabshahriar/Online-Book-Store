function deleteUserRow(userId) {
    if (confirm("Are you sure you want to delete this user?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "../control/customercontrol.php?action=delete&id=" + userId, true);
        
        xhr.onload = function() {
            if (this.status === 200) {
                var row = document.getElementById("user-row-" + userId);
                if (row) {
                    row.remove();
                }
                alert("User deleted successfully.");
            } else {
                alert("Failed to delete user.");
            }
        };
        
        xhr.send();
    }
}

function changeUserRole(userId, newRole) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "../control/customercontrol.php?action=update_role&id=" + userId + "&role=" + newRole, true);
    
    xhr.onload = function() {
        if (this.status === 200) {
            var roleBadge = document.getElementById("role-badge-" + userId);
            if (roleBadge) {
                roleBadge.innerText = newRole.toUpperCase();
            }
            alert("Role updated successfully.");
        } else {
            alert("Failed to update role.");
        }
    };
    
    xhr.send();
}