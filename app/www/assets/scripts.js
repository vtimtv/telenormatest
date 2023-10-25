window.addEventListener('load', function () {
    const myModal = new bootstrap.Modal(document.getElementById('staticBackdrop'));
    document.getElementById('newuserbtn').addEventListener('click', function () {
        let fields = ['id', 'fname', 'lname', 'position'];
        for(var k in fields){
            document.getElementById(fields[k]).value = '';
        }
        handleFormErrors($('#staticBackdrop').find('form'), null);
        $('#exampleModalLabel').text('New User');
        myModal.show();
    });

    document.getElementById('closebtn').addEventListener('click', function () {
        myModal.hide();
    });
    document.getElementById('createuserbtn').addEventListener('click', function (btn) {
        try {
            let fields = ['id', 'fname', 'lname', 'position'];
            var user = new URLSearchParams();
            for (var k in fields) {
                user.append(fields[k], document.getElementById(fields[k]).value);
            }
            handleFormErrors($('#staticBackdrop').find('form'), null);
            axios.post('./user', user).then(function (res) {
                    console.log(res);
                    handleFormErrors($('#staticBackdrop').find('form'), res.data);
                    if(!res.data.errors) {
                        myModal.hide();
                        fillusers(res);
                        console.log(res);
                    }
                }
            ).catch((error) => {
                    console.log(error);
                    if (error.response) {
                        handleFormErrors($('#staticBackdrop').find('form'), error.response.data);
                    }
                }
            );
        } catch (ex) {}
    });
    axios.get('./userslist').then(function(res){
            console.log(res);
            fillusers(res);
        }
    );
    function fillusers(res){
        var tbl = $('#userstable');
        tbl.empty();
        if(res && res.data){
            for(var k in res.data){
                var user = res.data[k];
                var tr = $('<tr></tr>').appendTo(tbl);
                $('<td></td>').text(user.fname).appendTo(tr);
                $('<td></td>').text(user.lname).appendTo(tr);
                $('<td></td>').text(POSITIONS[user.position]).appendTo(tr);
                var btnsTd = $('<td></td>').appendTo(tr);
                $('<button></button>').addClass('btn btn-sm btn-primary').appendTo(btnsTd).text('Edit').data('user', user).on('click', function(){
                    var usr = $(this).data('user');
                    $('#exampleModalLabel').text('Edit User (ID=' + usr.id + ')');
                    var fields = ['id', 'fname', 'lname', 'position'];
                    for(var k in fields){
                        document.getElementById(fields[k]).value = usr[fields[k]];
                    }
                    handleFormErrors($('#staticBackdrop').find('form'), null);
                    myModal.show();
                });
                $('<button></button>').addClass('btn btn-sm btn-danger').appendTo(btnsTd).text('Delete').data('user_id', user['id']).on('click', function(){
                    var user_id = $(this).data('user_id');
                    if(confirm('Are you sure to delete user with ID=' + user_id)) {
                        var user = new URLSearchParams();
                        user.append('id', user_id);
                        axios.post('./userdelete', user).then(function (res) {
                                console.log(res);
                                handleFormErrors($('#staticBackdrop').find('form'), res.data);
                                if (!res.data.errors) {
                                    myModal.hide();
                                    fillusers(res);
                                    console.log(res);
                                }
                            }
                        ).catch((error) => {
                                console.log(error);
                                if (error.response) {
                                    handleFormErrors($('#staticBackdrop').find('form'), error.response.data);
                                }
                            }
                        );
                    }
                });
            }
        }
    }


});

function handleFormErrors(form, res){
    form.find('.alert').remove();
    form.find('.form-control.is-invalid').removeClass('is-invalid');
    form.find('.form-select.is-invalid').removeClass('is-invalid');
    if(res && res.errors){
        var alertW = $('<div class="alert alert-danger">').prependTo(form);
        var lst = $('<ul>').appendTo(alertW);
        for (var errs in res.errors){
            $('[name="' + errs + '"]').addClass('is-invalid');
            $('<li>').text(res.errors[errs]).appendTo(lst);
        }
    }
}
