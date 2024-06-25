document.getElementById("addUserForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent default form submission
    var formData = new FormData(this); // Create FormData object from form data
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "add_user.php", true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success) {
                // If success, display success message and optionally reload content
                alert("User added successfully!");
                // Reload content or redirect to another page as needed
                // loadContent('add_user.php');
            } else {
                // If errors, display error messages
                var errorContainer = document.getElementById("error-container");
                errorContainer.innerHTML = ""; // Clear previous errors
                response.errors.forEach(function(error) {
                    var errorElement = document.createElement("p");
                    errorElement.textContent = error;
                    errorContainer.appendChild(errorElement);
                });
            }
        }
    };
    xhr.send(formData); // Send form data via AJAX
});


// Function to load content from URL using AJAX
function loadContent(url) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', url, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.querySelector('.content').innerHTML = xhr.responseText;
        }
    };
    xhr.send();
}

// Event listener for submenu links
var submenuLinks = document.querySelectorAll('.submenu__link');
submenuLinks.forEach(function(link) {
    link.addEventListener('click', function(event) {
        event.preventDefault();
        var url = this.getAttribute('href');
        loadContent(url);
    });
});

