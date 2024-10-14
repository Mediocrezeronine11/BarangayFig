$(document).ready(function () {
    // Mao ning sidebar code pare
    $('.sidebar-dropdown-menu').slideUp('fast');

    $('.sidebar-menu-item.has-dropdown > a, .sidebar-dropdown-menu-item.has-dropdown > a').click(function(e) {
        e.preventDefault();

        if (!$(this).parent().hasClass('focused')) {
            $(this).parent().parent().find('.sidebar-dropdown-menu').slideUp('fast');
            $(this).parent().parent().find('.has-dropdown').removeClass('focused');
        }

        $(this).next().slideToggle('fast');
        $(this).parent().toggleClass('focused');
    });

    $('.sidebar-toggle').click(function() {
        $('.sidebar').toggleClass('collapsed');

        // Use off() to prevent multiple event bindings
        $('.sidebar.collapsed').off('mouseleave').mouseleave(function() {
            $('.sidebar-dropdown-menu').slideUp('fast');
            $('.sidebar-menu-item.has-dropdown, .sidebar-dropdown-menu-item.has-dropdown').removeClass('focused');
        });
    });

    $('.sidebar-overlay').click(function() {
        $('.sidebar').addClass('collapsed');
        $('.sidebar-dropdown-menu').slideUp('fast');
        $('.sidebar-menu-item.has-dropdown, .sidebar-dropdown-menu-item.has-dropdown').removeClass('focused');
    });

    if (window.innerWidth < 768) {
        $('.sidebar').addClass('collapsed');
    }

    // Search functionality
$('#searchInput').on('input', function() {
    const searchTerm = $(this).val();

    $.ajax({
        url: `search_blotter.php?search=${encodeURIComponent(searchTerm)}`,
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            console.log('Search data:', data);

            const tableBody = $('#blotterTableBody');
            tableBody.empty();

            if (data.length > 0) {
                let number = 1; // Initialize the number counter
                data.forEach(row => {
                    const statusClass = row.status === 'Pending' ? 'border-danger' :
                                                row.status === 'Active' ? 'border-success' :
                                                row.status === 'Settled' ? 'border-info' :
                                                row.status === 'Scheduled' ? 'border-secondary' : 'border-secondary';

                    const tableRow = `
                        <tr>
                            <td class="text-center">
                                <input type="checkbox" name="select_record[]" value="${row.id}" class="form-check-input">
                            </td>
                            <td class="text-center">${number++}.</td> <!-- Added Number -->
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="ms-3">
                                        <p class="fw-bold mb-1">${row.complainant}</p>
                                        <p class="text-muted mb-0">Complainant</p>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">${row.respondent}</td>
                            <td class="text-center">${row.victim}</td>
                            <td class="text-center">${row.blotter_type}</td>
                            <td class="text-center">${row.location}</td>
                            <td class="text-center">${row.date}</td>
                            <td class="text-center">${row.time_am_pm}</td>
                            <td class="text-center" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 150px;">
                                ${row.details}
                            </td>
                            <td class="text-center">
                                <span class="border-bottom shadow-sm ${statusClass} px-2 py-1 rounded-pill d-inline-block">
                                    ${row.status}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex flex-column flex-sm-row justify-content-end m-3">
                                    <button type="button" class="btn btn-link btn-m btn-rounded text-dark ms-sm-2 shadow-sm fw-semibold" data-bs-toggle="modal" data-bs-target="#viewBlotterModal" data-id="${row.id}">Details</button>
                                        <button type="button" class="btn btn-link btn-m btn-rounded mb-2 mb-sm-0 shadow-sm fw-semibold" data-bs-toggle="modal" data-bs-target="#editBlotterModal" data-id="${row.id}">Update</button>
                                </div>
                            </td>
                        </tr>
                    `;
                    tableBody.append(tableRow);
                });
            } else {
                tableBody.html('<tr><td colspan="12" class="text-center">No data found</td></tr>'); // Updated to colspan=12 for the added column
            }

            // Rebind the checkbox handlers
            $('#selectAll').off('click').on('click', function() {
                $('input[name="select_record[]"]').prop('checked', this.checked);
            });

            $('input[name="select_record[]"]').off('change').on('change', function() {
                const allChecked = $('input[name="select_record[]"]').length === $('input[name="select_record[]"]:checked').length;
                $('#selectAll').prop('checked', allChecked);
            });
        },
        error: function(error) {
            console.error('Error searching data:', error);
        }
    });
});


$(document).ready(function() {
    // Refresh Button Click Event
    $('#refreshButton').on('click', function() {
        location.reload(); // Reload the current page
    });

    $('#searchDropdown').on('change', function() {
        const selectedField = $(this).val(); // Get selected field
        $('#searchInput').show().val(''); // Show the search input and clear previous input
        $('#searchInput').off('input').on('input', debounce(function() {
            const searchTerm = $(this).val();
            const url = searchTerm 
                ? `search_blotterschedule.php?search=${encodeURIComponent(searchTerm)}&field=${selectedField}` 
                : `search_blotterschedule.php?status=Scheduled`; // Fetch only scheduled when search is empty

            $.ajax({
                url: url, // Updated URL based on search term
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    console.log('Search data:', data);

                    const tableBody = $('#blotterScheduleTableBody');
                    tableBody.empty();

                    if (data.length > 0) {
                        let number = 1; // Initialize the number counter
                        data.forEach(row => {
                            const statusClass = row.status === 'Pending' ? 'border-danger' :
                                                row.status === 'Active' ? 'border-success' :
                                                row.status === 'Settled' ? 'border-info' :
                                                row.status === 'Scheduled' ? 'border-secondary' : 'border-secondary';

                            const tableRow = `
                                <tr>
                                    <td class="text-center">
                                        <input type="checkbox" name="select_record[]" value="${row.id}" class="form-check-input">
                                    </td>
                                    <td class="text-center">${number++}.</td> <!-- Added Number -->
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="ms-3">
                                                <p class="fw-bold mb-1">${row.complainant}</p>
                                                <p class="text-muted mb-0">Complainant</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">${row.respondent}</td>
                                    <td class="text-center">${row.victim}</td>
                                    <td class="text-center">${row.blotter_type}</td>
                                    <td class="text-center">${row.location}</td>
                                    <td class="text-center text-success">
                                        <span class="fw-bold">${formatTime(row.start_time)}</span>
                                    </td>
                                    <td class="text-center text-danger">
                                        <span class="fw-bold">${formatTime(row.end_time)}</span>
                                    </td>
                                    <td class="text-center">${row.days_of_week}</td>
                                    <td class="text-center" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 150px;">
                                        ${row.details}
                                    </td>
                                    <td class="text-center">
                                        <span class="border-bottom shadow-sm ${statusClass} px-2 py-1 rounded-pill d-inline-block">
                                            ${row.status}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex flex-column flex-sm-row justify-content-end m-3">
                                            <button type="button" class="btn btn-link btn-m btn-rounded text-dark ms-sm-2 shadow-sm fw-semibold" data-bs-toggle="modal" data-bs-target="#viewBlotterModal" data-id="${row.id}">Details</button>
                                            <button type="button" class="btn btn-link btn-m btn-rounded ms-sm-2 shadow-sm fw-semibold" data-bs-toggle="modal" data-bs-target="#editBlotterModal" data-id="${row.id}">Update</button>
                                        </div>
                                    </td> <!-- Actions Column -->
                                </tr>
                            `;
                            tableBody.append(tableRow);
                        });
                    } else {
                        tableBody.html('<tr><td colspan="13" class="text-center">No data found</td></tr>'); // Updated to colspan=13 for the added column
                    }

                    // Rebind the checkbox handlers
                    $('#selectAll').off('click').on('click', function() {
                        $('input[name="select_record[]"]').prop('checked', this.checked);
                    });

                    $('input[name="select_record[]"]').off('change').on('change', function() {
                        const allChecked = $('input[name="select_record[]"]').length === $('input[name="select_record[]"]:checked').length;
                        $('#selectAll').prop('checked', allChecked);
                    });
                },
                error: function(error) {
                    console.error('Error searching data:', error);
                }
            });
        }, 300)); // Debounce for 300ms
    });
});

// Debounce function
function debounce(func, delay) {
    let timeout;
    return function() {
        const context = this;
        const args = arguments;
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(context, args), delay);
    };
}

// Helper function to format time
function formatTime(dateTime) {
    const date = new Date(dateTime);
    return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: true });
}



    
    // Modal handling for editing blotter record
    $('#editBlotterModal').on('show.bs.modal', function(event) {
        const button = $(event.relatedTarget);
        const id = button.data('id');

        $.ajax({
            url: `fetch_blotter_data.php?id=${encodeURIComponent(id)}`,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                console.log('Edit data:', data);

                if (data) {
                    $('#editBlotterId').val(data.id || '');
                    $('#editComplainant').val(data.complainant || '');
                    $('#editRespondent').val(data.respondent || '');
                    $('#editVictim').val(data.victim || '');
                    $('#editLocation').val(data.location || '');
                    $('#editDate').val(data.date || '');
                    $('#editTime').val(data.time_am_pm || '');
                    $('#editStatus').val(data.status || '');
                    $('#editBlotterType').val(data.blotter_type || '');
                    $('#editDetails').val(data.details || '');
                }
            },
            error: function(error) {
                console.error('Error fetching data:', error);
            }
        });
    });

    // Modal handling for deleting blotter record
    $('#deleteBlotterModal').on('show.bs.modal', function(event) {
        const button = $(event.relatedTarget);
        const id = button.data('id');
        $('#deleteId').val(id);
    });

    // Handle "Delete Selected" button
    $('#deleteSelectedBtn').click(function() {
        const selected = $('input[name="select_record[]"]:checked').map(function() {
            return $(this).val();
        }).get();

        if (selected.length === 0) {
            alert('No records selected!');
            return;
        }

        $('#bulkDeleteModal').modal('show');

        $('#confirmBulkDelete').click(function() {
            $.ajax({
                url: 'delete_selected.php',
                method: 'POST',
                data: { ids: selected },
                success: function(response) {
                    $('#bulkDeleteModal').modal('hide');
                    location.reload(); // Refresh the page to reflect changes
                }
            });
        });
    });
});

// Modal sa View handling Pare
$(document).ready(function () {
    // Modal handling for viewing blotter record
    $('#viewBlotterModal').on('show.bs.modal', function(event) {
        const button = $(event.relatedTarget);
        const id = button.data('id'); // Get the data-id attribute from the button

        $.ajax({
            url: `fetch_blotter_data.php?id=${encodeURIComponent(id)}`,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                console.log('View data:', data);

              
                if (!data.error) {
                    // Populate modal fields with data
                    $('#viewComplainant').val(data.complainant || '');
                    $('#viewRespondent').val(data.respondent || '');
                    $('#viewVictim').val(data.victim || '');
                    $('#viewBlotterType').val(data.blotter_type || '');
                    $('#viewLocation').val(data.location || '');
                    $('#viewDate').val(data.date || '');
                    $('#viewTime').val(data.time_am_pm || '');
                    $('#viewStatus').val(data.status || '');
                    $('#viewDetails').val(data.details || '');
                    $('#viewScheduleDate').val(data.schedule_date || ''); // Include schedule_date
                    $('#viewScheduleTime').val(data.schedule_time || ''); // Include schedule_time
                } else {
                    // Handle error or no record found
                    $('#viewComplainant').val('No data available');
                    $('#viewRespondent').val('No data available');
                    $('#viewVictim').val('No data available');
                    $('#viewBlotterType').val('No data available');
                    $('#viewLocation').val('No data available');
                    $('#viewDate').val('No data available');
                    $('#viewTime').val('No data available');
                    $('#viewDetails').val('No data available');
                    $('#viewStatus').val('No data available');
                    $('#viewScheduleDate').val('No data available'); // Handle for schedule_date
                    $('#viewScheduleTime').val('No data available'); // Handle for schedule_time
                }
            },
            error: function(error) {
                console.error('Error fetching data:', error);
                $('#viewComplainant').val('Error fetching data');
                $('#viewRespondent').val('Error fetching data');
                $('#viewVictim').val('Error fetching data');
                $('#viewBlotterType').val('Error fetching data');
                $('#viewLocation').val('Error fetching data');
                $('#viewDate').val('Error fetching data');
                $('#viewTime').val('Error fetching data');
                $('#viewDetails').val('Error fetching data');
                $('#viewStatus').val('Error fetching data');
                $('#viewScheduleDate').val('Error fetching data'); // Error handling for schedule_date
                $('#viewScheduleTime').val('Error fetching data'); // Error handling for schedule_time
            }
        });
    });
});





// modal sa dropdown tho
document.addEventListener("DOMContentLoaded", function () {
    const dropdown = document.getElementById('announcementDropdown');
    const announcementText = document.getElementById('announcementText');

    // Sample data for announcements
    const announcements = {
        1: "This is the text for Announcement 1.",
        2: "This is the text for Announcement 2.",
        3: "This is the text for Announcement 3."
    };

    dropdown.addEventListener('change', function () {
        const selectedValue = dropdown.value;
        if (selectedValue) {
            announcementText.innerHTML = announcements[selectedValue]; // Display the corresponding text
        } else {
            announcementText.innerHTML = ''; // Clear the text if no option is selected
        }
    });
});



// blotter_schedule ni par
 $(document).ready(function() {
        // Assuming you have a button with the ID 'scheduleButton'
        $('#scheduleButton').on('click', function() {
            $('#scheduleSection').toggle(); // Toggle the visibility of the schedule section
        });
    });

// Helper function to determine status class
function getStatusClass(status) {
    switch (status) {
        case 'Pending': return 'border-danger';
        case 'Active': return 'border-success';
        case 'Settled': return 'border-info';
        case 'Scheduled': return 'border-secondary';
        default: return 'border-danger';
    }
}

// Sa Edit Modal Schedule ni
function toggleScheduleFields() {
    const status = document.getElementById('editStatus').value;
    const scheduleFields = document.getElementById('scheduleFields');
    // Show schedule fields only if the selected status is "Schedule"
    if (status === 'Schedule') {
        scheduleFields.style.display = 'block';
    } else {
        scheduleFields.style.display = 'none';
    }
}


// sa Schedule ni Pare
document.getElementById('formStatus').addEventListener('change', function() {
    var scheduleSection = document.getElementById('scheduleSection');
    if (this.value === 'Schedule') {
        scheduleSection.style.display = 'block';
    } else {
        scheduleSection.style.display = 'none';
    }
});



// Record per page pare
function updateRecordsPerPage() {
    var recordsPerPage = document.getElementById('recordsPerPage').value;
    var currentPage = new URLSearchParams(window.location.search).get('page') || 1;
    window.location.href = '?page=' + currentPage + '&recordsPerPage=' + recordsPerPage;
}

// Info Records ni Pare
function updateRecordsPerPage() {
    var recordsPerPage = document.getElementById('recordsPerPage').value;
    var url = new URL(window.location.href);
    url.searchParams.set('recordsPerPage', recordsPerPage);
    url.searchParams.set('page', 1); // Reset to first page
    window.location.href = url.toString();
}

// saakong selected delete ni par
document.addEventListener('DOMContentLoaded', function () {
    const selectAllCheckbox = document.getElementById('selectAll');
    const deleteSelectedBtn = document.getElementById('deleteSelectedBtn');
    const deleteSelectedModal = new bootstrap.Modal(document.getElementById('deleteSelectedModal'));
    const deleteSelectedForm = document.getElementById('deleteSelectedForm');
    const deleteSelectedIds = document.getElementById('deleteSelectedIds');

    // Toggle all checkboxes
    selectAllCheckbox.addEventListener('change', function () {
        const checkboxes = document.querySelectorAll('input[name="select_record[]"]');
        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
    });

    // Handle delete selected button click
    deleteSelectedBtn.addEventListener('click', function () {
        const selectedIds = Array.from(document.querySelectorAll('input[name="select_record[]"]:checked'))
            .map(checkbox => checkbox.value)
            .join(',');

        if (selectedIds) {
            deleteSelectedIds.value = selectedIds;
            deleteSelectedModal.show();
        } else {
            alert('No records selected!');
        }
    });
});
