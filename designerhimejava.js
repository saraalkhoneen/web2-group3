function func() {
    var name = localStorage.getItem('username');
    if (name !== undefined && name !== null) {
        document.getElementById('welcomeMessage').innerHTML = "Welcome Back " + name + "!";
        document.getElementById('firstName').innerHTML = name;
    } else {
        document.getElementById('welcomeMessage').innerHTML = "Hello!";
        document.getElementById('firstName').innerHTML = "undefined";
    }

    var lastname = localStorage.getItem('lastName');
    if (lastname !== undefined && lastname !== null) {
        document.getElementById('lastName').innerHTML = lastname;
    } else {
        document.getElementById('lastName').innerHTML = "undefined";
    }

    var email = localStorage.getItem('email');
    if (email !== undefined && email !== null) {
        document.getElementById('email').innerHTML = email;
    } else {
        document.getElementById('email').innerHTML = "undefined";
    }

    var brand = localStorage.getItem('brand');
    if (brand !== undefined && brand !== null) {
        document.getElementById('brand').innerHTML = brand;
    } else {
        document.getElementById('brand').innerHTML = "undefined";
    }

    var specality = localStorage.getItem('specality');
    if (specality !== undefined && specality !== null) {
        document.getElementById('specality').innerHTML = specality;
    } else {
        document.getElementById('specality').innerHTML = "undefined";
    }

    var projectname = JSON.parse(localStorage.getItem('projectname'));
    var projectimg = JSON.parse(localStorage.getItem('projectimg'));
    var projectcat = JSON.parse(localStorage.getItem('projectcat'));
    var projectdesc = JSON.parse(localStorage.getItem('projectdesc'));

    if (projectname === null) {
        document.getElementById('Designs').innerHTML += "<tr><td colspan=4>you have No projects</td></tr>";
    } else {
        for (let i = 0; i < projectname.length; i++) {
            document.getElementById('Designs').innerHTML += "<tr><td>" + projectname[i] + "</td>";
            document.getElementById('Designs').innerHTML += "<td>" + projectimg[i] + "</td>";
            document.getElementById('Designs').innerHTML += "<td>" + projectcat[i] + "</td>";
            document.getElementById('Designs').innerHTML += "<td>" + projectdesc[i] + "</td>";
            document.getElementById('Designs').innerHTML += "<td><a href=\"edit\">Edit Project</a></td>";
            document.getElementById('Designs').innerHTML += "<td><a onclick=\"deletedesign(this);\" href=\"delete\">Delete Project</a></td></tr>";// when clicked should delete
        }
    }

    var clientname = JSON.parse(localStorage.getItem('clientname'));
    var room = JSON.parse(localStorage.getItem('room'));
    var dimensions = JSON.parse(localStorage.getItem('dimensions'));
    var category = JSON.parse(localStorage.getItem('category'));
    var colorpref = JSON.parse(localStorage.getItem('colorpref'));
    var date = JSON.parse(localStorage.getItem('date'));

    if (clientname === null) {
        document.getElementById('Requests').innerHTML += "<tr><td colspan=6>you have No Requests</td></tr>";
    } else {
        for (let i = 0; i < clientname.length; i++) {
            document.getElementById('Requests').innerHTML += "<tr><td>" + clientname[i] + "</td>";
            document.getElementById('Requests').innerHTML += "<td>" + room[i] + "</td>";
            document.getElementById('Requests').innerHTML += "<td>" + dimensions[i] + "</td>";
            document.getElementById('Requests').innerHTML += "<td>" + category[i] + "</td>";
            document.getElementById('Requests').innerHTML += "<td>" + colorpref[i] + "</td>";
            document.getElementById('Requests').innerHTML += "<td>" + date[i] + "</td>";
            document.getElementById('Requests').innerHTML += "<td><a href=\"consult page\">Accept</a></td>";
            document.getElementById('Requests').innerHTML += "<td><a onclick=\"deleterequest(this);\" href=\"delete\">Decline</a></td></tr>";
        }
    }
} 

function deletedesign(){
    var i = r.parentNode.parentNode.rowIndex;
  document.getElementById("Designs").deleteRow(i);
}

function deleterequest(){
    var i = r.parentNode.parentNode.rowIndex;
  document.getElementById("Requests").deleteRow(i);
}