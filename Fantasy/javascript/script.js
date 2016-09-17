//This is the javascript file for various events generated on index.php file.

//This function is called 
function fillSelectedTable(email){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("selected").innerHTML = xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET", "fillSelected.php?id="+email, true);
    xmlhttp.send();

}

function fillAvailableTable(email){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("available").innerHTML = xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET", "fillAvailableTable.php?id="+email, true);
    xmlhttp.send();       
}

//This function is called when use clicks add link on index.php page.
function addPlayer(email,id){
     var comp_id = $("#comp")[0].selectedIndex;
    //alert(comp_id);
    if(id.length == 0){
        alert("Invalid Player !");
        return;
    } else if(email.length == 0){
          alert("Invalid User!");
          return;  
    }else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                var res = xmlhttp.responseText;
                var resint = parseInt(res,10);
               // confirm(res);
                if(resint == 1){
                    alert("Please adhere to squad constraints !");
                   // document.getElementById("available").innerHTML = "-1";
                    return;
                }else{
                   // confirm(res);
                   document.getElementById("available").innerHTML = xmlhttp.responseText;
                    
                    var xmlhttp1 = new XMLHttpRequest();
                    xmlhttp1.onreadystatechange = function(){
                        if(xmlhttp1.readyState == 4 && xmlhttp1.status == 200){
                            document.getElementById("selected").innerHTML = xmlhttp1.responseText;
                                
                        }
                    }
                    xmlhttp1.open("GET", "fillSelectedTable.php?player_id=" +"0"+ "&email="+email, true);
                    xmlhttp1.send();
                }
            }
        }
        //confirm("hello");
        xmlhttp.open("GET", "fillAvailableTable.php?player_id=" + id+ "&email="+email+"&comp_id="+comp_id, true);
        xmlhttp.send();       
    }
}
//This function is called when use clicks remove link on index.php page.
function removePlayer(email,id){
  //  document.getElementById("answer").innerHTML = email;          
    if(id.length == 0){
        alert("Invalid Player !");
        return;
    } else if(email.length == 0){
          alert("Invalid User!");
          return;  
    }else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("selected").innerHTML = xmlhttp.responseText;
                    var xmlhttp1 = new XMLHttpRequest();
                    xmlhttp1.onreadystatechange = function(){
                        if(xmlhttp1.readyState == 4 && xmlhttp1.status == 200){
                                document.getElementById("available").innerHTML = xmlhttp1.responseText;            
                        }
                    }
                    xmlhttp1.open("GET", "fillAvailableTable.php?player_id=" +"0"+ "&email="+email, true);
                    xmlhttp1.send();
 
            }
        }
        xmlhttp.open("GET", "fillSelectedTable.php?player_id=" + id+ "&email="+email, true);
        xmlhttp.send();       
    }
}

function updateComposition(ths){
   index = ths.selectedIndex;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("counts").innerHTML = xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET", "getComposition.php?id="+index, true);
    xmlhttp.send();       

}

//This is called when use submits team name and team composition using submit button.
$(document).ready(function(){
$("#submit").click(function(){
    var team_name = $("#team_name").val();
    var email = $("#your_email").val();
    var team_composition = $("#comp").val();
    var dataString = "team_name="+team_name+"&email="+email+
                        "&team_composition="+team_composition;
   if(team_name=="" || team_composition == "0"){
        alert("Please fill all fields !");
    }else{
        $.ajax({
        type: "POST",
        url: "submit.php",
        data: dataString,
        cache: false,
        success: function(result){
        $("#answer").html(result);
        }
        });
        }
        return false;
        });        
});
