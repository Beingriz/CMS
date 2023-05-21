// Delete
$(function() {
    $(document).on('click', '#delete', function(e) {
        e.preventDefault();
        var link = $(this).attr("href");


        Swal.fire({
            title: 'Are you sure?',
            text: "Delete This Data?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link

            }
        })


    });

});
// DeleteFile
$(function() {
    $(document).on('click', '#deletefile', function(e) {
        e.preventDefault();
        var link = $(this).attr("href");


        Swal.fire({
            title: 'Are you sure?',
            text: "Delete This File?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Delete'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link
            }
        })


    });

});
// Logout
$(function() {
    $(document).on('click', '#logout', function(e) {
        e.preventDefault();
        var link = $(this).attr("href");


        Swal.fire({
            title: 'Are you sure?',
            text: "you will be logged out.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Logout'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link
            }
        })


    });

});
// DeleteData
$(function() {
    $(document).on('click', '#deleteData', function(e) {
        e.preventDefault();
        var link = $(this).attr("href");


        Swal.fire({
            title: 'Are you sure?',
            text: "Delete This Carousel?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Delete'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link
            }
        })


    });

});
// Download
$(function() {
    $(document).on('click', '#download', function(e) {
        e.preventDefault();
        var link = $(this).attr("href");


        Swal.fire({
            title: 'Are you sure?',
            text: "you want to download this?",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Download'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link

            }
        })


    });

});

// Update
$(function() {
    $(document).on('click', '#open', function(e) {
        e.preventDefault();
        var link = $(this).attr("href");


        Swal.fire({
            title: 'Are you sure?',
            text: "You want to View this Record?",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Open Record!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link
                Swal.fire(
                    'File Opened!',
                    'Your file has been Open Now.',
                    'success'
                )
            }
        })


    });

});
// Open / View
$(function() {
    $(document).on('click', '#update', function(e) {
        e.preventDefault();
        var link = $(this).attr("href");


        Swal.fire({
            title: 'Are you sure?',
            text: "you want to Edit This Record?",
            icon: 'success',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link
                    // Swal.fire(
                    //     'Updated!',
                    //     'Your Record has been Updated.',
                    //     'success'
                    // )
            }
        })


    });

});
// Edit / View
$(function() {
    $(document).on('click', '#editData', function(e) {
        e.preventDefault();
        var link = $(this).attr("href");


        Swal.fire({
            title: 'Are you sure?',
            text: "you want to Edit This Record?",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link
                    // Swal.fire(
                    //     'Updated!',
                    //     'Your Record has been Updated.',
                    //     'success'
                    // )
            }
        })


    });

});
// Select File
$(function() {
    $(document).on('click', '#SelectData', function(e) {
        e.preventDefault();
        var link = $(this).attr("href");


        Swal.fire({
            title: 'Are you sure?',
            text: "you want to Select This Info?",
            icon: 'primary',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link
                    // Swal.fire(
                    //     'Updated!',
                    //     'Your Record has been Updated.',
                    //     'success'
                    // )
            }
        })


    });

});

// No file Choosen

document.getElementById('image').addEventListener('change', function() {
    if (this.files.length === 0) {
        Livewire.emit('reset');
    }
});