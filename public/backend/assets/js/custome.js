// Loading Overlay Functions
function showLoading() {
    document.getElementById('loading-overlay').classList.remove('d-none');
}

function hideLoading() {
    document.getElementById('loading-overlay').classList.add('d-none');
}

// Generic SweetAlert Confirmation Functions
function confirmAction(link, title, text, icon, confirmText) {
    Swal.fire({
        title: title,
        text: text,
        icon: icon,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: confirmText
    }).then((result) => {
        if (result.isConfirmed) {
            showLoading();
            window.location.href = link;
        }
    });
}

// Delete Confirmation
$(function() {
    $(document).on('click', '#delete', function(e) {
        e.preventDefault();
        var link = $(this).attr("href");
        confirmAction(link, 'Are you sure?', 'Delete This Data?', 'warning', 'Yes, delete it!');
    });
});

// Delete File Confirmation
$(function() {
    $(document).on('click', '#deletefile', function(e) {
        e.preventDefault();
        var link = $(this).attr("href");
        confirmAction(link, 'Are you sure?', 'Delete This File?', 'warning', 'Delete');
    });
});

// Logout Confirmation
$(function() {
    $(document).on('click', '#logout', function(e) {
        e.preventDefault();
        var link = $(this).attr("href");
        confirmAction(link, 'Are you sure?', 'You will be logged out.', 'warning', 'Logout');
    });
});

// Delete Data Confirmation
$(function() {
    $(document).on('click', '#deleteData', function(e) {
        e.preventDefault();
        var link = $(this).attr("href");
        confirmAction(link, 'Are you sure?', 'Delete This Carousel?', 'warning', 'Delete');
    });
});

// Download Confirmation
$(function() {
    $(document).on('click', '#download', function(e) {
        e.preventDefault();
        var link = $(this).attr("href");
        confirmAction(link, 'Are you sure?', 'You want to download this?', 'info', 'Download');
    });
});

// Open/View Record Confirmation
$(function() {
    $(document).on('click', '#open', function(e) {
        e.preventDefault();
        var link = $(this).attr("href");
        confirmAction(link, 'Are you sure?', 'You want to View this Record?', 'info', 'Yes, Open Record!');
    });
});

// Update Record Confirmation
$(function() {
    $(document).on('click', '#update', function(e) {
        e.preventDefault();
        var link = $(this).attr("href");
        confirmAction(link, 'Are you sure?', 'You want to Edit This Record?', 'success', 'Yes');
    });
});

// Edit Data Confirmation
$(function() {
    $(document).on('click', '#editData', function(e) {
        e.preventDefault();
        var link = $(this).attr("href");
        confirmAction(link, 'Are you sure?', 'You want to Edit This Record?', 'info', 'Yes');
    });
});

// Select File Confirmation
$(function() {
    $(document).on('click', '#SelectData', function(e) {
        e.preventDefault();
        var link = $(this).attr("href");
        confirmAction(link, 'Are you sure?', 'You want to Select This Info?', 'primary', 'Yes');
    });
});

// Reset File Selection if No File Chosen
document.getElementById('image').addEventListener('change', function() {
    if (this.files.length === 0) {
        Livewire.emit('reset');
    }
});

// Show Loading Overlay for All Form Submissions
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', showLoading);
    });
});

// Show the spinner when a Livewire request starts
document.addEventListener('livewire:request-start', function() {
    document.getElementById('loading-overlay').classList.remove('d-none');
});

// Hide the spinner when a Livewire request ends
document.addEventListener('livewire:request-end', function() {
    document.getElementById('loading-overlay').classList.add('d-none');
});

// Optional: You can also hide the spinner when Livewire has loaded the content
document.addEventListener('livewire:load', function() {
    document.getElementById('loading-overlay').classList.add('d-none');
});

// Show Loading Overlay for All Anchor Tag Clicks
$(document).ready(function() {
    // Show spinner when any anchor tag is clicked
    $('a').on('click', function(event) {
        // Exclude links with specific classes or attributes if needed
        if (!$(this).hasClass('no-spinner') && $(this).attr('target') !== '_blank') {
            $('#loading-overlay').removeClass('d-none');
        }
    });

    // Hide spinner on page load (if overlay is shown initially)
    $(window).on('load', function() {
        $('#loading-overlay').addClass('d-none');
    });
});