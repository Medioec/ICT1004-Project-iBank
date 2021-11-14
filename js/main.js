$(document).ready(function() {
    $('#example').DataTable( {
        select: true
    } );
    
    changepwdCheck();
} );


function changepwdCheck() {
    if (document.getElementById('y_changepwd').checked) {
        document.getElementById('ifYes').style.display = 'block';
    }
    
    else document.getElementById('ifYes').style.display = 'none';

};

