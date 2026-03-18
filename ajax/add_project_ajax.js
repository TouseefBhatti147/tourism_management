document.getElementById('addProjectForm').addEventListener('submit', function(event) {
    // Prevent the default form submission
    event.preventDefault();

    const form = event.target;
    const formData = new FormData(form);
    const messageDiv = document.getElementById('formMessage');

    // Display a loading message
    messageDiv.style.display = 'block';
    messageDiv.className = 'alert alert-info';
    messageDiv.textContent = 'Submitting project... Please wait.';

    // Send the data using Fetch API
    fetch('upload_project.php', {
      method: 'POST',
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        // Show success message
        messageDiv.className = 'alert alert-success';
        messageDiv.textContent = data.message;
        // Reset the form
        form.reset();
      } else {
        // Show error message
        messageDiv.className = 'alert alert-danger';
        messageDiv.textContent = data.message;
      }
    })
    .catch(error => {
      // Show network or server error
      messageDiv.className = 'alert alert-danger';
      messageDiv.textContent = 'An error occurred while submitting the form. ' + error;
    });
  });
document.getElementById('addProjectForm').addEventListener('submit', function(event) {
    // Prevent the default form submission
    event.preventDefault();

    const form = event.target;
    const formData = new FormData(form);
    const messageDiv = document.getElementById('formMessage');

    // Display a loading message
    messageDiv.style.display = 'block';
    messageDiv.className = 'alert alert-info';
    messageDiv.textContent = 'Submitting project... Please wait.';

    // Send the data using Fetch API
    fetch('upload_project.php', {
      method: 'POST',
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        // Show success message
        messageDiv.className = 'alert alert-success';
        messageDiv.textContent = data.message;
        // Reset the form
        form.reset();
      } else {
        // Show error message
        messageDiv.className = 'alert alert-danger';
        messageDiv.textContent = data.message;
      }
    })
    .catch(error => {
      // Show network or server error
      messageDiv.className = 'alert alert-danger';
      messageDiv.textContent = 'An error occurred while submitting the form. ' + error;
    });
  });

