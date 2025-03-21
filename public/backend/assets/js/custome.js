// Function to Show Loading
function showLoading() {
    document.getElementById('loading-overlay').classList.remove('d-none');
}

// Function to Hide Loading
function hideLoading() {
    document.getElementById('loading-overlay').classList.add('d-none');
}

// Generic SweetAlert Confirmation Functions
function confirmAction(link = null, title, text, icon, confirmText, functionName = null, id = null) {
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
            if (link) {
                window.location.href = link;
            } else if (functionName) {
                Livewire.emit(functionName, id);
                hideLoading();
            }
        }
    });
}

// Delete Confirmation
$(function() {
    $(document).on('click', '#deleteRecord', function(e) {
        e.preventDefault();
        var link = $(this).attr("href");
        var funName = $(this).attr("funName");
        var id = $(this).attr("recId");
        confirmAction(
            link || null,
            "Are you sure?",
            "you want to Delete this record permanantly?",
            "warning",
            "Yes, delete it!",
            funName,
            id
        );
    });
});
// Edit Confirmation
$(function() {
    $(document).on('click', '#editRecord', function(e) {
        e.preventDefault();
        var link = $(this).attr("href");
        var funName = $(this).attr("funName");
        var id = $(this).attr("recId");
        confirmAction(
            link || null,
            "Are you sure?",
            "you want to edit this record?",
            "info",
            "Yes, Edit Record!",
            funName,
            id
        );
    });
});

// Select Record Confirmation
$(function() {
    $(document).on('click', '#selectRecord', function(e) {
        e.preventDefault();
        var link = $(this).attr("href");
        var funName = $(this).attr("funName");
        var id = $(this).attr("recId");
        confirmAction(
            link || null,
            "Are you sure?",
            "you want to Select this Record?",
            "info",
            "Yes, Select!",
            funName,
            id
        );
    });
});
// view Record Confirmation
$(function() {
    $(document).on('click', '#viewRecord', function(e) {
        e.preventDefault();
        var link = $(this).attr("href");
        var funName = $(this).attr("funName");
        var id = $(this).attr("recId");
        confirmAction(
            link || null,
            "Are you sure?",
            "you want to list all Records?",
            "info",
            "Yes, Show All!",
            funName,
            id
        );
    });
});
// Delete File Confirmation
$(function() {
    $(document).on('click', '#deleteFile', function(e) {
        e.preventDefault();
        var link = $(this).attr("href");
        var funName = $(this).attr("funName");
        var id = $(this).attr("recId");
        confirmAction(
            link || null,
            "Are you sure?",
            "you want to delete this file permanantly?",
            "warning",
            "Yes, Delete!",
            funName,
            id
        );
    });
});


//=========================================================================================================

// Generic SweetAlert Confirmation Functions
function confirmAction2(link, title, text, icon, confirmText) {
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


// Delete File Confirmation
$(function() {
    $(document).on('click', '#deletefile', function(e) {
        e.preventDefault();
        var link = $(this).attr("href");
        confirmAction2(link, 'Are you sure?', 'you want to Delete This File?', 'warning', 'Delete');
    });
});

// Logout Confirmation
$(function() {
    $(document).on('click', '#logout', function(e) {
        e.preventDefault();
        var link = $(this).attr("href");
        confirmAction2(link, 'Are you sure?', 'You will be logged out.', 'warning', 'Logout');
    });
});

// Delete Data Confirmation
$(function() {
    $(document).on('click', '#deleteData', function(e) {
        e.preventDefault();
        var link = $(this).attr("href");
        confirmAction2(link, 'Are you sure?', 'Delete This Carousel?', 'warning', 'Delete');
    });
});

// Download Confirmation
$(function() {
    $(document).on('click', '#download', function(e) {
        e.preventDefault();
        var link = $(this).attr("href");
        confirmAction2(link, 'Are you sure?', 'You want to download this?', 'info', 'Download');
    });
});

$(function() {
    $(document).on('click', '#download', function(e) {
        e.preventDefault(); // Prevent default click action
        var link = $(this).attr("href");

        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to download this file?',
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Download',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                showLoading(); // Show loading overlay

                setTimeout(() => {
                    hideLoading(); // Hide loading after delay
                    window.location.href = link; // Start download
                }, 1500); // 1.5-second delay before downloading
            }
        });
    });
});

// Open/View Record Confirmation
$(function() {
    $(document).on('click', '#open', function(e) {
        e.preventDefault();
        var link = $(this).attr("href");
        confirmAction2(link, 'Are you sure?', 'You want to View this Record?', 'info', 'Yes, Open Record!');
    });
});

// Update Record Confirmation
$(function() {
    $(document).on('click', '#update', function(e) {
        e.preventDefault();
        var link = $(this).attr("href");
        confirmAction2(link, 'Are you sure?', 'You want to Edit This Record?', 'success', 'Yes');
    });
});

// Edit Data Confirmation
$(function() {
    $(document).on('click', '#editData', function(e) {
        e.preventDefault();
        var link = $(this).attr("href");
        confirmAction2(link, 'Are you sure?', 'You want to Edit This Record?', 'info', 'Yes');
    });
});
// Edit Data Confirmation
$(function() {
    $(document).on('click', '#editProfile', function(e) {
        e.preventDefault();
        var link = $(this).attr("href");
        confirmAction2(link, 'Are you sure?', 'You want to edit Profile details?', 'info', 'Yes');
    });
});

// Select File Confirmation
$(function() {
    $(document).on('click', '#SelectData', function(e) {
        e.preventDefault();
        var link = $(this).attr("href");
        confirmAction2(link, 'Are you sure?', 'You want to Select This Info?', 'primary', 'Yes');
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


document.addEventListener('DOMContentLoaded', function() {
    window.addEventListener('swal:success', event => {
        Swal.fire({
            title: event.detail.title,
            text: event.detail.text,
            icon: event.detail.icon,
            confirmButtonText: 'OK'
        });
    });
});
document.addEventListener('DOMContentLoaded', function() {
    window.addEventListener('swal:error', event => {
        Swal.fire({
            title: event.detail.title,
            text: event.detail.text,
            icon: event.detail.icon,
            confirmButtonText: 'OK'
        });
    });
});
document.addEventListener('DOMContentLoaded', function() {
    window.addEventListener('swal:warning', event => {
        Swal.fire({
            title: event.detail.title,
            text: event.detail.text,
            icon: event.detail.icon,
            confirmButtonText: 'OK'
        });
    });
});
document.addEventListener('DOMContentLoaded', function() {
    window.addEventListener('swal:info', event => {
        Swal.fire({
            title: event.detail.title,
            text: event.detail.text,
            icon: event.detail.icon,
            confirmButtonText: 'OK'
        });
    });
});

// Show Alert Message
document.addEventListener("DOMContentLoaded", function() {
    showLoading(); // Show loading overlay

    setTimeout(() => {
        hideLoading(); // Hide loading before Swal appears

        if (session('swal'))
            Swal.fire({
                title: "{{ session('swal.title') }}",
                text: "{{ session('swal.text') }}",
                icon: "{{ session('swal.icon') }}",
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            }).then(() => {
                // Optional: Perform an action after Swal is closed
                console.log("Swal closed");
            });
        endif
    }, 2500); // Hide loading & show Swal after 1.5s
});