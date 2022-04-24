class user{
	constructor(name, email, password){
		this.name= name;
		this.email=email;
		this.password=password;
		this.pfp="pfp.png";
		this.status="....";
		this.bio=".....";
		this.feild=".....";
	}

   newpfp(pfp){
   	this.pfp=pfp;
   }

   newstatus(status){
   	this.status=status;
   }

   newbio(bio){
   	this.bio=bio;
   }

   newfeild(feild){
   	this.feild=feild;
   }

}

const users= new Array();

$(document).ready(function(){
$(".button").click(function(){


if($("#firstname").val().trim()!="" &&$("#lastname").val().trim()!="" &&$("#email").val().trim()!="" &&$("#pass").val().trim()!=""&&$("#confirmpasword").val().trim()!=""){

    
if($("#confirmpasword").val()!=$("#pass").val()){
	console.log($("#confirmpasword").val());
	console.log($("#pass").val());
	
  $("#confirmpasword").val("");
  $("#conerror").css("display","block");

}else{

	var name = $("#firstname").val()+" "+$("#lastname").val();
	var email= $("#email").val();
	var pass= $("#pass").val();


    var x= new user(name,email,pass);
	users.push(x);

	$(".clear").val("");
	alert("signup complete");

}




}else{

	alert("pleas fill all the boxes");
}




});
});


