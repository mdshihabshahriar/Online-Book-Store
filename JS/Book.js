function validateBookForm() {
    let isValid = true;

  
    let title = document.getElementById("title").value.trim();
    let author = document.getElementById("author").value.trim();
    let description = document.getElementById("description").value.trim();
    let price = document.getElementById("price").value.trim();
    let category = document.getElementById("category").value.trim();
    let stock = document.getElementById("stock").value.trim();
    let imageInput = document.getElementById("image");

   
    let parsedPrice = parseFloat(price);
    let parsedStock = parseInt(stock, 10);

    
    if (title === "") {
        alert("Title must not be empty.");
        return false;
    }

   
    if (author === "") {
        alert("Author must not be empty.");
        return false;
    }

   
    if (description === "") {
        alert("Description must not be empty.");
        return false;
    }

   
    if (price === "" || isNaN(parsedPrice) || parsedPrice <= 0) {
        alert("Price must be a valid number greater than 0.");
        return false;
    }

    
    if (category === "") {
        alert("Please enter a category ID.");
        return false;
    }

    
    if (stock === "" || isNaN(parsedStock) || parsedStock < 0) {
        alert("Stock cannot be empty or negative.");
        return false;
    }

   
    if (imageInput.files.length > 0) {
        let file = imageInput.files[0];
        let fileName = file.name.toLowerCase();
        let allowedExtensions = ["jpg", "jpeg", "png"];
        let fileExtension = fileName.split('.').pop();

        if (!allowedExtensions.includes(fileExtension)) {
            alert("Only JPG, JPEG, and PNG files are allowed.");
            return false;
        }

       
        if (file.size > 2097152) {
            alert("Image file size must be under 2MB.");
            return false;
        }
    }

    return isValid;
}