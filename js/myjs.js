function myajax(){

    var data=document.getElementById("mydata").value;

    var filter=document.getElementById("filter").value;

    var xttp=new XMLHttpRequest();

    xttp.onreadystatechange=function(){

        if(this.readyState==4 && this.status==200){

            document.getElementById("myprint").innerHTML=
            this.responseText;
        }
    };

    xttp.open(
        "GET",
        "../control/search_books_control.php?search="
        +encodeURIComponent(data)
        +"&filter="+filter,
        true
    );

    xttp.send();
}