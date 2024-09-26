let interrupt=0;
document.getElementById("eye").setAttribute('src','./img/eye-slash.svg')
document.getElementById("eye").onclick=function(){
 let element1=document.getElementById("pass");
 let element2=document.getElementById("eye");
 if(interrupt==0){
    element1.setAttribute('type','text');
    element2.setAttribute('src','./img/eye.svg')
    interrupt++;
 }
 else{
    element1.setAttribute('type','password');
    element2.setAttribute('src','./img/eye-slash.svg')
    interrupt=interrupt-1;
 }
}
