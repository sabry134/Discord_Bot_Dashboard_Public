$(document).ready(function () {
    $.get('http://localhost:3000/api/emails', function (emails) {
        emails.reverse();

        let emailList = $('#emailList');
        emails.forEach(function (email) {
            emailList.append(`
            <li class="email-item" style="margin-left: 120px;width: 85%; background-color: grey;">
                <a href="email.php?id=${email.id}" class="email-card" data-id="${email.id}">
                    <div class="card-content">
                        <p><strong>Object:</strong> ${email.title}</p>
                        <p><strong>Username:</strong> ${email.username}</p>
                        <p><strong>Date:</strong> ${email.date}</p>
                    </div>
                </a>
            </li>
        `);
        });
    });

    $('#emailList').on('click', '.deleteEmail', function (e) {
        e.preventDefault();
        e.stopPropagation();
        const emailId = $(this).closest('.email-card').data('id');
        deleteEmail(emailId);
    });

    $('#emailList').on('click', '.archiveEmail', function (e) {
        e.preventDefault();
        e.stopPropagation();
        const emailId = $(this).closest('.email-card').data('id');
        archiveEmail(emailId);
    });

    const urlParams = new URLSearchParams(window.location.search);
    const emailId = urlParams.get('id');
    if (emailId) {
        $.get(`http://localhost:3000/api/emails/${emailId}`, function (email) {
            let emailDetails = $('#emailDetails');
            emailDetails.html(`
            <div class="email-details-container" style="margin: 0 auto; width: 70%; background-color: grey; border-radius: 20px; display: flex; flex-direction: column; justify-content: center; padding-right: 20px; color: white;">
                <p style="margin-left: 40px; margin-top: 30px; word-wrap: break-word; font-size: 20px;"><strong>Username:</strong> ${email.username}</p>
                <p style="margin-left: 40px; word-wrap: break-word; font-size: 20px;"><strong>Date:</strong> ${email.date}</p>
                <p style="margin-left: 40px; word-wrap: break-word; font-size: 20px;"><strong>Object:</strong> ${email.title}</p>
                <p style="margin-left: 40px; margin-top: 10px; word-wrap: break-word;"><strong>Content:</strong><br></br>${email.content}</p>
            <div class="email-options" style="margin-left: 40px; margin-bottom: 20px;">
                <a href="#" class="deleteEmail" style="text-decoration: none; background-color: white; color: black; padding: 10px 20px; border-radius: 5px;">Delete</a>
            </div>
            </div>
        `);

            emailDetails.on('click', '.deleteEmail', function (e) {
                e.preventDefault();
                e.stopPropagation();
                deleteEmail(emailId);
            });

            emailDetails.on('click', '.archiveEmail', function (e) {
                e.preventDefault();
                e.stopPropagation();
                archiveEmail(emailId);
            });
        });
    }

    function deleteEmail(emailId) {
        $.ajax({
            url: `http://localhost:3000/api/emails/${emailId}`,
            type: 'DELETE',
            success: function () {
                alert('Email deleted');
                window.location.href = 'requests.php';
            },
            error: function () {
                alert('Failed to delete email');
            },
        });
    }

    function archiveEmail(emailId) {
        $.post(`http://localhost:3000/api/emails/${emailId}/archive`, function (response) {
            alert('Email archived');
            window.location.href = 'requests.php';
        }).fail(function () {
            alert('Failed to archive email');
        });
    }
});
