var user = 'swang46';

setTimeout(function(){
    var pass_index = localStorage.getItem("index");
    if(parseInt(pass_index) > passwds.length) {
        alert("Finish");
    }
    document.getElementById('user_id').value = user;
    document.getElementById('password').value = passwds[parseInt(pass_index)];
    //alert(passwds[parseInt(pass_index)]);
    localStorage.setItem("index",(parseInt(pass_index)+1).toString());
    document.getElementById('entry-login').click();
}, 1000);
