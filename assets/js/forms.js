function generatePass(plength){

    var keylistalpha="abcdefghijklmnopqrstuvwxyz";
    var keylistint="123456789";
    var keylistspec="!@#_";
    var temp='';
    var len = plength/2;
    var len = len - 1;
    var lenspec = plength-len-len;

    for (i=0;i<len;i++)
        temp+=keylistalpha.charAt(Math.floor(Math.random()*keylistalpha.length));

    for (i=0;i<lenspec;i++)
        temp+=keylistspec.charAt(Math.floor(Math.random()*keylistspec.length));

    for (i=0;i<len;i++)
        temp+=keylistint.charAt(Math.floor(Math.random()*keylistint.length));

        temp=temp.split('').sort(function(){return 0.5-Math.random()}).join('');

    return temp;
}


function fpass(form, password) {
    // Create a new element input, this will be our hashed password field. 
    var user_fpass= document.createElement("input");
var npass = generatePass(8);
    //alert("Javascript");
    // Add the new element to our form. 
    form.appendChild(user_fpass);
    user_fpass.name = "user_fpass";
    user_fpass.type = "hidden";
    user_fpass.value = hex_sha512(npass);
    //alert(p.value);
    // Make sure the plaintext password doesn't get sent. 
    password.value = npass;
 
    // Finally submit the form. 
    form.submit();
}



function frmpost() {
    alert("Please Get Posted Dear");
    // Finally submit the form. 
    //form.submit();
}

function resetformhash(form, npassword, npasswordc) {
    //alert(npassword);
    //alert(npasswordc);
    if(npasswordc.value==npassword.value)
    {


    // Create a new element input, this will be our hashed password field. 
    var cp_pn = document.createElement("input");
    //alert("Javascript");
    // Add the new element to our form. 
    form.appendChild(cp_pn);
    cp_pn.name = "cp_pn";
    cp_pn.type = "hidden";
    cp_pn.value = hex_sha512(npassword.value);
    
    //alert(p.value);
    // Make sure the plaintext password doesn't get sent. 
    //opassword.value = "";
    npassword.value = "";
    npasswordc.value = "";
 
    // Finally submit the form. 
    form.submit();
    }
    else
    {
        alert("Passwords did not matched!!!");
    }
}

function cpformhash(form, opassword, npassword, npasswordc) {
    //alert(npassword);
    //alert(npasswordc);
    if(npasswordc.value==npassword.value)
    {


    // Create a new element input, this will be our hashed password field. 
    var cp_po = document.createElement("input");
    var cp_pn = document.createElement("input");
    //alert("Javascript");
    // Add the new element to our form. 
    form.appendChild(cp_po);
    form.appendChild(cp_pn);
    cp_pn.name = "cp_pn";
    cp_pn.type = "hidden";
    cp_pn.value = hex_sha512(npassword.value);
    cp_po.name = "cp_po";
    cp_po.type = "hidden";
    cp_po.value = hex_sha512(opassword.value);

    //alert(p.value);
    // Make sure the plaintext password doesn't get sent. 
    opassword.value = "";
    npassword.value = "";
    npasswordc.value = "";
 
    // Finally submit the form. 
    form.submit();
    }
    else
    {
        alert("New Passwords not matched!!!");
    }
}

function userformhash(form, password) {
    // Create a new element input, this will be our hashed password field. 
    var log_p = document.createElement("input");
    //alert("Javascript");
    // Add the new element to our form. 
    form.appendChild(log_p);
    log_p.name = "log_p";
    log_p.type = "hidden";
    log_p.value = hex_sha512(password.value);
    //alert(p.value);
    // Make sure the plaintext password doesn't get sent. 
    password.value = "";
 
    // Finally submit the form. 
    form.submit();
}

function formhash(form, password) {
    // Create a new element input, this will be our hashed password field. 
    var log_p = document.createElement("input");
    //alert("Javascript");
    // Add the new element to our form. 
    form.appendChild(log_p);
    log_p.name = "log_p";
    log_p.type = "hidden";
    log_p.value = hex_sha512(password.value);
    //alert(p.value);
    // Make sure the plaintext password doesn't get sent. 
    password.value = "";
 
    // Finally submit the form. 
    form.submit();
}
 
function regformhash(form,  email, password, conf) {
    //alert('Hi');
     // Check each field has a value
    if (email.value == ''     || 
          password.value == ''  || 
          conf.value == '') {
 
        alert('You must provide all the requested details. Please try again');
        return false;
    }
 
    
 
    // Check that the password is sufficiently long (min 6 chars)
    // The check is duplicated below, but this is included to give more
    // specific guidance to the user
    if (password.value.length < 6) {
        alert('Passwords must be at least 6 characters long.  Please try again');
        form.password.focus();
        return false;
    }
 
    // At least one number, one lowercase and one uppercase letter 
    // At least six characters 
 /*
    var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/; 
    if (!re.test(password.value)) {
        alert('Passwords must contain at least one number, one lowercase and one uppercase letter.  Please try again');
        return false;
    }
 */
    // Check password and confirmation are the same
    if (password.value != conf.value) {
        alert('Your password and confirmation do not match. Please try again');
        form.password.focus();
        return false;
    }
    
    // Create a new element input, this will be our hashed password field. 
    var p = document.createElement("input");
 
    // Add the new element to our form. 
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(password.value);
    // Make sure the plaintext password doesn't get sent. 
    password.value = "";
    conf.value = "";
 
    // Finally submit the form. 
    form.submit();
    return true;
}