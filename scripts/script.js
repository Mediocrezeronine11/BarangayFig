// Fetch the taken positions from the server
let takenPositions = [];

// Fetch taken positions from your PHP script
fetch('fetch_taken_positions.php')
    .then(response => response.json())
    .then(data => {
        takenPositions = data; // Store fetched positions in the variable
        disableTakenPositions(); // Call function to disable taken positions
    })
    .catch(error => console.error('Error fetching taken positions:', error));

// Function to disable taken positions in the dropdown
function disableTakenPositions() {
    const positionSelect = document.getElementById('position');
    const options = positionSelect.options;

    // Loop through each option and disable it if it's in the takenPositions array
    for (let i = 0; i < options.length; i++) {
        if (takenPositions.includes(options[i].value)) {
            options[i].disabled = true;  // Make the option unclickable
        }
    }
}

// Disable the entire position dropdown if a taken position is selected
document.getElementById('position').addEventListener('change', function() {
    const selectedPosition = this.value;

    // Check if the selected position is taken
    if (takenPositions.includes(selectedPosition)) {
        this.disabled = true;  // Disable the entire dropdown
    }
});

// Show the position dropdown only if user_type is 'official'
document.getElementById('user_type').addEventListener('change', function() {
    const userType = this.value;
    const positionContainer = document.getElementById('position_container');

    if (userType === 'official') {
        positionContainer.style.display = 'block';
    } else {
        positionContainer.style.display = 'none';
        document.getElementById('position').value = '';  // Reset the selection
        document.getElementById('position').disabled = false;  // Re-enable the dropdown
    }
});
