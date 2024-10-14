// mao ni saakong Ago Ago Pre!
document.addEventListener("DOMContentLoaded", function () {
    fetchAnnouncements(); // Fetch and display announcements on page load

    function timeAgo(date) {
        const now = new Date();
        const seconds = Math.floor((now - date) / 1000);
        const minutes = Math.floor(seconds / 60);
        const hours = Math.floor(minutes / 60);
        const days = Math.floor(hours / 24);
        const years = Math.floor(days / 365);

        if (years > 0) {
            return `${years} year${years > 1 ? 's' : ''} ago`;
        } else if (days > 0) {
            return `${days} day${days > 1 ? 's' : ''} ago`;
        } else if (hours > 0) {
            return `${hours} hour${hours > 1 ? 's' : ''} ago`;
        } else if (minutes > 0) {
            return `${minutes} minute${minutes > 1 ? 's' : ''} ago`;
        } else {
            return 'Just now';
        }
    }

    function formatDate(date) {
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        return date.toLocaleDateString(undefined, options);
    }

    function fetchAnnouncements() {
        fetch('submit_announcement.php')
            .then(response => response.json())
            .then(data => {
                const container = document.getElementById('announcementContainer');
                container.innerHTML = ''; // Clear previous content

                data.forEach(announcement => {
                    // Create a Date object from the announcement date and time
                    const announcementDate = new Date(`${announcement.announcement_date} ${announcement.announcement_time}`);

                    // Use the timeAgo function to format the date
                    const relativeDate = timeAgo(announcementDate);
                    const fullDate = formatDate(announcementDate); // Format full date

                    // Check if the announcement has an image
                    const imageHTML = announcement.image_path 
                        ? `<img src="uploads/${announcement.image_path}" alt="Announcement Image" class="img-fluid mt-3 rounded">` 
                        : '';
                        

                    // Append each announcement to the container
                    const announcementHTML = `
                    <div class="bg-white rounded-3 shadow p-4 mb-4 position-relative border border-secondary">
                        <div class="text-center mb-3">
                            <h4 class="fw-bold" style= color:"#CB6843";>Announcement</h4>
                            <hr />
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <img alt="Profile picture" class="rounded-circle me-2" height="50" src="../logosaLafili.png" width="50"/>
                            <div>
                                <div class="fw-bold">Admin</div>
                                <div class="text-muted">${relativeDate} (${fullDate})</div> <!-- Display relative date and full date -->
                            </div>
                        </div>
                        <div class="mb-3">
                            <p>${announcement.content}</p>
                            ${imageHTML} 
                        </div>
                        <div class="d-flex position-absolute top-0 end-0 me-3 mt-3">
                            <button class="btn btn-danger text-light me-2" aria-label="Pin" onclick="openPinModal(${announcement.id})">
                                <i class="ri-pushpin-fill"></i>
                            </button>
                        </div>
                    </div>
                `;
                
                    container.insertAdjacentHTML('beforeend', announcementHTML); // Insert each announcement
                });
            })
            .catch(error => console.error('Error fetching announcements:', error));
    }
});


// sa post daw
document.getElementById("announcementForm").onsubmit = function() {
    document.getElementById("postAnnouncementButton").disabled = true;
};

// Function to open the pin confirmation modal
function openPinModal(announcementId) {
    const modal = new bootstrap.Modal(document.getElementById('pinConfirmationModal'));
    document.getElementById('confirmPinButton').onclick = function () {
        pinAnnouncement(announcementId); // Pass the announcementId to the pin function
        modal.hide(); // Close the modal after confirmation
    };
    modal.show(); // Show the modal
}

// Function to pin the announcement
function pinAnnouncement(announcementId) {
    fetch('pin_announcement.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id: announcementId }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Announcement pinned successfully!");
            loadPinnedAnnouncements(); // Reload pinned announcements or update UI
        } else {
            alert("Error: " + data.error);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert("An error occurred. Please try again.");
    });
}


// jQuery function to handle posting announcements
$(document).ready(function () {
    $('#postAnnouncementButton').click(function () {
        var announcement = $('#announcementModalInput').val().trim(); // Trim input value

        // Check if the announcement input is not empty
        if (announcement) {
            $.ajax({
                type: 'POST',
                url: 'submit_announcement.php',
                data: { announcementInput: announcement },
                dataType: 'json', // Expect a JSON response
                success: function (response) {
                    $('#announcementModalInput').val(''); // Clear input field after successful post
                    location.reload(); // Reload the page to show the new announcement
                },
                error: function (xhr) {
                    console.error(xhr.responseText); // Log error details
                    alert('Error posting announcement. Please try again.'); // User-friendly error message
                }
            });
        } else {
            alert('Please enter an announcement.'); // Alert if the input is empty
        }
    });
});



// Sa akoa ning pinned duuh

// Fetch and display pinned announcements
function loadPinnedAnnouncements() {
    fetch('submit_announcement.php?pinned=1') // Ensure the correct parameter is used
        .then(response => response.json())
        .then(data => {
            const pinnedContainer = document.querySelector('.col-md-4 .card-body');
            pinnedContainer.innerHTML = ''; // Clear existing content

            if (data.length > 0) {
                data.forEach(pinnedAnnouncement => {
                    // Check if there is an image path
                    const imageHTML = pinnedAnnouncement.image_path 
                        ? `<img src="uploads/${pinnedAnnouncement.image_path}" alt="Announcement Image" class="img-fluid mb-3" style="max-height: 300px; width: 100%;">` // Set max-height for the image
                        : '';

                    const pinnedHTML = `
                        <div class="post mb-4" style="min-height: 250px;"> <!-- Increased bottom margin and set min-height -->
                            <div class="d-flex align-items-center mb-3"> <!-- Increased bottom margin -->
                                <img alt="Profile picture" class="rounded-circle me-3" height="50" src="../logosaLafili.png" width="50"/> <!-- Increased size -->
                                <div class="me-auto">
                                    <span class="fw-bold fs-5">${pinnedAnnouncement.posted_by || 'Admin'}</span> <!-- Increased font size -->
                                    <span class="badge bg-light text-dark ms-2">Pinned</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center text-muted mb-3"> <!-- Increased bottom margin -->
                                <i class="ri-chat-3-line me-2"></i> <!-- Increased left margin -->
                                <div class="text-muted fs-6">Posted on ${pinnedAnnouncement.announcement_date} at ${pinnedAnnouncement.announcement_time}</div> <!-- Increased font size -->
                            </div>
                            <div class="post-content text-muted mb-3 fs-6"> <!-- Increased bottom margin and font size -->
                                ${pinnedAnnouncement.content}
                            </div>
                            ${imageHTML} <!-- Insert image if available -->
                        </div>
                        <hr/>
                    `;
                    pinnedContainer.insertAdjacentHTML('beforeend', pinnedHTML); // Insert each pinned announcement
                });
            } else {
                // If no pinned announcements, show a message
                pinnedContainer.innerHTML = '<p class="text-muted">No pinned announcements available.</p>';
            }
        })
        .catch(error => {
            console.error('Error fetching pinned announcements:', error);
            const pinnedContainer = document.querySelector('.col-md-4 .card-body');
            pinnedContainer.innerHTML = '<p class="text-danger">Error fetching pinned announcements. Please try again later.</p>';
        });
}

// Call loadPinnedAnnouncements when the page loads
document.addEventListener("DOMContentLoaded", function () {
    loadPinnedAnnouncements(); // Fetch and display pinned announcements on page load
});

// Function to show the modal for posting announcement
document.getElementById('announcementInput').addEventListener('click', function () {
    var myModal = new bootstrap.Modal(document.getElementById('primaryAddressModal'));
    myModal.show();
});



// Sa Textarea nga dropdown sa post ni pare!
document.addEventListener("DOMContentLoaded", function () {
    const dropdown = document.getElementById('announcementDropdown');
    const announcementTextarea = document.getElementById('announcementTextarea');

    // Sample data for announcements (English and Bisaya)
    const announcements = {
        1: `Pahibalo!!
Barangay San Miguel, Tagum City
Oktubre 9, 2024

Sa Tanan nga Pumuluyo sa Barangay San Miguel,

Maayong Adlaw!

Gusto namo ipaabot ang mga importante nga update, kalihokan, ug mga aktibidad nga mahitabo sa atong barangay.

1. [Barangay Clean-Up Drive]

2. [Kultura ug Arte Festival]

3. [Health and Wellness Seminar]

4. [Barangay Sports Fest]

5. [Apil ang tanan sa mga dula ug paligsahan!]

Daghang salamat sa inyong atensyon ug kooperasyon.

Tinud-anay nga nagpasalamat,


[Imong Ngalan]                            [Oras og Kanus a]
Kapitan sa Barangay`,

        2: `Pahibalo!!
Barangay San Miguel, Tagum City
Oktubre 9, 2024

Maayong Adlaw, Pumuluyo!

Gusto namo ipahibalo nga adunay miting nga pagahimoon sa:

Petsa: [Ibutang ang Petsa]
Oras: [Ibutang ang Oras]
Lugar: [Ibutang ang Lugar]

Ang miting maghisgot sa bag-ong iskedyul para sa mga kalihokan sa komunidad. Dako ang among pagpasalamat sa inyong kooperasyon ug partisipasyon.

Pinakamaayong panghinaut,
[Imong Ngalan]
Kapitan sa Barangay,


[Imong Ngalan]                         [Oras og Kanus a]
Kapitan sa Barangay`,

        3: `Pahibalo!!
Barangay San Miguel, Tagum City
Oktubre 9, 2024

Sa Tanan nga Pumuluyo sa Barangay San Miguel,

Maayong Adlaw!

Mga Pumuluyo,

Kini usa ka pahinumdom nga padayon nga atimanon ang kalimpyo ug kaluwasan sa inyong palibot. Palihug magmatngon ug isugid dayon ang bisan unsang kahina-hinalang kalihokan sa atong komunidad.

Daghang salamat sa inyong padayon nga suporta.

Tinud-anay nga nagpasalamat,


[Imong Ngalan]                    [Oras og Kanus a]
Kapitan sa Barangay`,

        4: ""
    };

    dropdown.addEventListener('change', function () {
        const selectedValue = dropdown.value;
        if (selectedValue) {
            announcementTextarea.value = announcements[selectedValue]; // Populate the textarea with the selected announcement text
        } else {
            announcementTextarea.value = ''; // Clear the textarea if no option is selected
        }
    });
});
