$(".delete-user").click(function() {
    userId = $(this).closest('tr').attr('id');
    deleteUser(userId);
});

$(document).on("click", ".edit-user", function () {
    userId = $(this).closest('tr').attr('id');
    enterEditMode(userId);
});

$(document).on("click", ".save-edit-user", function () {
    userId = $(this).closest('tr').attr('id');
    saveEditedUser(userId);
});

$(document).on("click", ".cancel-edit-user", function(){
    userId = $(this).closest('tr').attr('id');
    exitEditMode(userId);
});

function enterEditMode(userId) {
    userName = $("#user-name-" + userId).text();
    userEmail = $("#user-email-" + userId).text();

    $("#edit-user-button-" + userId).empty();
    $("#edit-user-button-" + userId).append(
        '<button class="btn btn-sm btn-default save-edit-user" onclick="this.blur();">' +
        '<span class="glyphicon glyphicon-ok"></span>' +
        '</button>\n' +
        '<button class="btn btn-sm btn-default cancel-edit-user" onclick="this.blur();">' +
        '<span class="glyphicon glyphicon-remove"></span>' +
        '</button>'
    );

    $("#user-name-" + userId).empty();
    $("#user-name-" + userId).append(
        $('<input>', {
            id: "input-user-name-" + userId,
            class: 'form-control',
            type: 'text',
            val: userName
        })
    );

    $("#user-email-" + userId).empty();
    $("#user-email-" + userId).append(
        $('<input>', {
            id: "input-user-email-" + userId,
            class: 'form-control',
            type: 'text',
            val: userEmail
        })
    );
}

function exitEditMode(userId) {
    userName = $("#input-user-name-" + userId).val();
    userEmail = $("#input-user-email-" + userId).val();

    $("#user-name-" + userId).empty();
    $("#user-name-" + userId).append(
        $('<p>', {
            id: "user-name-" + userId
        }).text(userName)
    );

    $("#user-email-" + userId).empty();
    $("#user-email-" + userId).append(
        $('<p>', {
            id: "user-email-" + userId
        }).text(userEmail)
    );

    $("#edit-user-button-" + userId).empty();
    $("#edit-user-button-" + userId).append(
        '<button class="btn btn-sm btn-default edit-user" onclick="this.blur();">' +
        '<span class="glyphicon glyphicon-pencil"></span>' +
        '</button>'
    );
}

function saveEditedUser(userId) {
    name = $("#input-user-name-" + userId).val();
    email = $("#input-user-email-" + userId).val();

    $.ajax(
        {
            type : 'PUT',
            url : 'api/users/' + userId,
            headers : {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType : 'JSON',
            data: {
                "name" : name,
                "email" : email
            },
            success : function() {
                exitEditMode(userId);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log("ajax call to get_current_data results into error");
                console.log(xhr.status);
                console.log(thrownError);
            }
        });
}

function deleteUser(userId) {
    if (!confirm('Are you sure?')) {
        return;
    }

    $.ajax(
        {
            type : 'DELETE',
            url : 'api/users/' + userId,
            headers : {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType : 'JSON',
            success : function() {
                $(".user-acounts").remove("#" + userId);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log("ajax call to get_current_data results into error");
                console.log(xhr.status);
                console.log(thrownError);
            }
        });
}