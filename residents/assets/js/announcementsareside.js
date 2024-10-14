// Mao ni sa akoa Ago Ago Pre!
document.addEventListener("DOMContentLoaded", function () {
    fetchAnnouncements(); // Fetch and display announcements on page load
    loadPinnedAnnouncements(); // Fetch and display pinned announcements on page load

    let newAnnouncementsCount = 0; // Initialize new announcements count
    let lastAnnouncementId = 0; // Initialize the last announcement ID
    let notifications = []; // Array to track notifications and their timestamps
    

    // Function to calculate time ago
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

    // Function to format date
    function formatDate(date) {
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        return date.toLocaleDateString(undefined, options);
    }

// Fetch announcements
function fetchAnnouncements() {
    fetch('submit_announcement.php')
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('announcementContainer');
            container.innerHTML = ''; // Clear previous content
            const notificationList = document.getElementById('announcementDropdownList'); // Select the notification list in the dropdown

            let currentNewCount = 0; // Temporary variable to track new announcements

            data.forEach(announcement => {
                const announcementDate = new Date(`${announcement.announcement_date} ${announcement.announcement_time}`);
                const relativeDate = timeAgo(announcementDate);
                const fullDate = formatDate(announcementDate);

                const imageHTML = announcement.image_path 
                    ? `<img src="../admin/uploads/${announcement.image_path}" alt="Announcement Image" class="img-fluid mt-3 rounded">` 
                    : '';

                const announcementHTML = `
                <div class="container mt-3">
        <div class="alert alert-info d-flex align-items-center" role="alert">
          <i class="ri-info-i rounded-circle p-1 me-2 text-light bg-dark" style="width: 20px; height: 20px; display: flex; align-items: center; justify-content: center;">
</i>

            <span>For any concerns regarding your assessment, please visit the Feedback or contact them at.</span>
        </div>
    </div>
                <div class="container mt-4">
                    <div class="notification bg-white rounded shadow-sm mb-4">
                        <div class="notification-header text-white d-flex justify-content-between align-items-center p-3 rounded-top" style="background-color: #008080;">

                            <div class="small text-light fw-bold">Announcement</div>
                            <div class="notification-time small text-light fw-bold">${relativeDate} (${fullDate})</div>
                        </div>
                        <div class="notification-body p-3">
                            <p>${announcement.content}</p>
                            ${imageHTML}
                        </div>
                    </div>
                </div>
                `;

                container.insertAdjacentHTML('beforeend', announcementHTML);

                // Check for new announcements
                if (announcement.id > lastAnnouncementId) {
                    lastAnnouncementId = announcement.id; // Update the last ID
                    currentNewCount++; // Increment the temporary new announcements count

                    // Only add the most recent new announcement to the dropdown
                    addToNotificationDropdown(announcement.content, relativeDate); // Add to dropdown menu
                }
            });

            // Update the total new announcements count
            newAnnouncementsCount += currentNewCount;

            // Update the notification badge
            updateNotificationBadge(newAnnouncementsCount);
        })
        .catch(error => console.error('Error fetching announcements:', error));
}

// Update notification badge
function updateNotificationBadge(count) {
    const badge = document.getElementById('notificationBadge'); // Update the dropdown's badge

    // Check if the dropdown menu is visible
    const dropdownMenu = document.querySelector('.dropdown-menu'); // Get the dropdown menu
    const isDropdownOpen = dropdownMenu.classList.contains('show');

    if (isDropdownOpen) {
        // If the dropdown is open, reset the badge text to '0' and hide it
        badge.textContent = '0'; 
        badge.classList.add('d-none'); 
        newAnnouncementsCount = 0; // Reset the count after displaying
        return; // Exit the function
    }

    if (count > 0) {
        badge.textContent = count; // Set the badge to the new announcements count
        badge.classList.remove('d-none'); // Show the badge
    } else {
        badge.classList.add('d-none'); // Hide the badge if no new announcements
    }
}



// Add notification to dropdown
function addToNotificationDropdown(content, relativeDate) {
    const notificationList = document.getElementById('announcementDropdownList'); 
    

    const newNotificationHTML = `
    <div class="d-flex justify-content-center">
        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" style="width: 300px;">
            <div class="me-auto">
                <span class="fs-7 fw-bold" style="word-wrap: break-word; overflow-wrap: break-word; max-width: 200px;">${content}</span>
            </div>
            <small class="text-muted">${relativeDate}</small>
        </a>
    </div>
`;



    notificationList.insertAdjacentHTML('afterbegin', newNotificationHTML); // Add new notification to the top
}

// Event listener to reset notification badge when the dropdown is opened
const dropdownToggle = document.querySelector('.dropdown-toggle');
dropdownToggle.addEventListener('shown.bs.dropdown', function () {
    updateNotificationBadge(0); // Reset the badge to 0
});

// Poll for new announcements every 10 seconds
setInterval(fetchAnnouncements, 10000); // Fetch announcements every 10 seconds


});

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

// Fetch and display pinned announcements
async function loadPinnedAnnouncements() {
    const pinnedContainer = document.querySelector('.col-md-4 .card-body');
    pinnedContainer.innerHTML = '<p class="text-muted">Loading announcements...</p>'; // Show loading state

    try {
        const response = await fetch('submit_announcement.php?pinned=1');
        const data = await response.json();
        
        if (data.length > 0) {
            // Create an array to hold the announcement HTML
            const pinnedHTMLArray = data.map(pinnedAnnouncement => {
                const imageHTML = pinnedAnnouncement.image_path 
                    ? `<img src="../admin/uploads/${pinnedAnnouncement.image_path}" alt="Announcement Image" class="img-fluid mb-3" style="max-height: 300px; width: 100%;">`
                    : '';

                return `
                    <div class="post mb-4" style="min-height: 250px;">
                        <div class="d-flex align-items-center mb-3">
                            <img alt="Profile picture" class="rounded-circle me-3" height="50" src="../logosaLafili.png" width="50"/>
                            <div class="me-auto">
                                <span class="fw-bold fs-5">${pinnedAnnouncement.posted_by || 'Admin'}</span>
                                <span class="badge bg-light text-dark ms-2">Pinned</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center text-muted mb-3">
                            <i class="ri-chat-3-line me-2"></i>
                            <div class="text-muted fs-6">Posted on ${pinnedAnnouncement.announcement_date} at ${pinnedAnnouncement.announcement_time}</div>
                        </div>
                        <div class="post-content text-muted mb-3 fs-6">
                            ${pinnedAnnouncement.content}
                        </div>
                        ${imageHTML}
                    </div>
                    <hr/>
                `;
            });
            pinnedContainer.innerHTML = pinnedHTMLArray.join(''); // Insert all at once
        } else {
            pinnedContainer.innerHTML = '<p class="text-muted">No pinned announcements available.</p>';
        }
    } catch (error) {
        console.error('Error fetching pinned announcements:', error);
        pinnedContainer.innerHTML = '<p class="text-danger">Error fetching pinned announcements. Please try again later.</p>';
    }
}

// Function to show the modal for posting an announcement
document.getElementById('announcementInput').addEventListener('click', function () {
    var myModal = new bootstrap.Modal(document.getElementById('primaryAddressModal'));
    myModal.show();
});
