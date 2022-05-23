



class post{
	constructor(subject,text){
		this.subject= subject;
		this.text= text;
		this.likes=0;
    var s=subject+" "+ text;
    this.content= s.split(" ");
	}


   like(){
   	this.likes++;
   }

   unlike(){
   this.likes--;
   }

}
const posts= new Array();

$(document).ready(function(){

$("#upload").click(function(){
  $(".poster").css("display","block");
  $("#sub").val("");
   $("#postbody").val("");

});

$("#cancle").click(function(){
	 $(".poster").css("display","none");
});
$(".poster button").click(function(){
 
  
if($("#sub").val().trim()!="" &&$("#postbody").val().trim()!="" ){
	var x = new post($("#sub").val(),$("#postbody").val());

   posts.push(x);
    $(".posts").prepend(
     '<div class="feed"><h4>'+x.subject+'</h4><div id="wrapper"><p>'+x.text+'</p></div><button id="button-'+posts.length+'" class="like-btn" data-postId="'+(posts.length-1)+'"><span>0</span><span style="margin-left:10px">upvote</span></button></div>' );
    $(".poster").css("display","none");
    $(".like-btn").on("click",function(){
    	var post=posts[Number($(this).attr("data-postId"))]
    	post.like()
    	console.log($(this).children())
    	$(this).children()[0].innerText=post['likes'];
    	console.log(post)
    })
  
}
 else{
 	$("#alert").css("display","block");
 } 


});



$("#trend").click(function(){

posts.sort(function(a, b){
  let x = a.likes;
  let y = b.likes;
  if (x < y) {return -1;}
  if (x > y) {return 1;}
  return 0;
});

const trenpo= new Array();
for (var i = 0; i <posts.length; i++) {
	trenpo[i]=  '<div class="feed"><h4>'+posts[i].subject+'</h4><p>'+posts[i].text+'</p><button id="button-'+posts.length+'" class="like-btn" data-postId="'+(i)+'"><span>0</span><span style="margin-left:10px">upvote</span></button></div>'
}
console.log(trenpo);
$('.posts').html("");
//$('.posts').html(trenpo[trenpo.length-1]);

for (var i = trenpo.length-1; i >=0 ; i--) {

	 $(".posts").append(trenpo[i]);
}

});







$("#refresh").click(function(){
$('.posts').html("");
  
});

var count=0;
$("#zoom").click(function(){
   if(count%2==0){

  $(".posts p,h4").css("font-size", "x-large");
  count++;

} else {
 $(".posts p,h4").css("font-size", "medium");
 count++;
}
});





});


