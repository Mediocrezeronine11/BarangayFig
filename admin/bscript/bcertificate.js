$(document).ready(function() {
    $('#searchInput').on('keyup', function() {
        var searchValue = $(this).val();
        $.ajax({
            url: 'search.php', // Your PHP script to handle the search
            method: 'POST',
            data: { search: searchValue },
            success: function(data) {
                $('#resultsTable tbody').html(data);
            }
        });
    });
});