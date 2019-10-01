/**************evaluation commentaires***********************/
var done=false
var pic = new Array();
pic[0]=new Image();
  pic[0].src="../assets/images/star.png";
pic[1]=new Image();
  pic[1].src="../assets/images/star2.png";
var bareme = new Array("peu ","passablement ","moyennement","presque","") 
 
  function rate(level){
  if (done){return false;}
    for(i=1;i<6;i++){ document.getElementById('_'+i).src=(level<i)?pic[0].src:pic[1].src;
    document.getElementById('choix').innerHTML="Votre choix : "+level+" étoile(s)   "+bareme[level-1]+" satisfaisant" 
    }
    }
    
  function zero(){
      for(i=1;i<6;i++){ document.getElementById('_'+i).src=pic[0].src;
      done=false;
      document.getElementById('choix').innerHTML="Votre choix : 0 étoile(s)" 
  
      }
      }
  function valider(){
    alert('Votre évaluation a été enregistrée!');
  done=true;
  document.getElementById('choix').innerHTML+='   VALID&Eacute;';

}