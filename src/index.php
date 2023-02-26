
<?php
echo "<br>";

// nazwa uz - root  haslo - example, nazwa bazy danych - pogoda
$mysqli = new mysqli("db", "root", "example", "pogoda");

//$file=fopen("miasta.txt","a");
//file_put_contents("miasta.txt","");

$sql = 'SELECT * FROM miasto';

if ($result = $mysqli->query($sql)) {
    while ($data = $result->fetch_object()) {
        $dane[] = $data;
    }
}

//iot1
$sql = 'SELECT * FROM iot1';

if ($result = $mysqli->query($sql)) {
    while ($data1 = $result->fetch_object()) {
        $dane1[] = $data1;
    }
}

//iot2
$sql = 'SELECT  * FROM iot2';




if ($result = $mysqli->query($sql)) {
    while ($data2 = $result->fetch_object()) {
        $dane2[] = $data2;
    }
}

$sql = 'SELECT  * FROM Zestawienie';




if ($result = $mysqli->query($sql)) {
    while ($data3 = $result->fetch_object()) {
        $dane3[] = $data3;
    }
}


///$czas =;
///$temp_wewn = 0;
//$temp_zewn = 0;
//$cisnienie = 0;
//$predkosc_wiatru = 0;
//$naslonecznienie = 0;
//$wilg_zewn = 0;

$len_d = count($dane);
$len_d1 = count($dane1);
$len_d2 = count($dane2);

$czas = $dane1[$len_d1 - 1]->czas;
$temp_wewn =$dane1[$len_d1 -1]->temp_wewn;
$temp_zewn =$dane1[$len_d1 -1]->temp_zewn;
$cisnienie = $dane1[$len_d1-1]->cisnienie;
$wilg_zewn = $dane1[$len_d1-1]->wilg_zewn;
$predkosc_wiatru = $dane2[$len_d2 -1]->predkosc_wiatru;
$naslonecznienie = $dane2[$len_d2 -1]->naslonecznienie;

$czasArrey =[];
$tempArrey = [];
foreach ($dane1 as $d1)
{

    array_push($czasArrey,$d1->czas);
    array_push($tempArrey,$d1->temp_zewn);

}


?>


<html>

<link rel="stylesheet" href="styl.css">
<head>


</head>

<body>
   


 
<h2>Wigety- szybki podgląd</h2>
<div id="wigety">


   

    <div class = "pole_danych"> 
        <h1 class="opis" >Aktualny czas:</h1>
        <h1 class="dana" id="czas">Dana:</h1>


    </div>
    <div class = "pole_danych"> 

        <h1 class="opis" >Temp. wewnetrzna:</h1>
        <h1 class="dana" id="temp_wewn">Dana:</h1>  
       

    </div>

    <div class = "pole_danych"> 

    <h1 class="opis" >Temp. zewnetrzna:</h1>
    <h1 class="dana" id="temp_zewn">Dana:</h1>
   
    </div>

    <div class = "pole_danych"> 

    <h1 class="opis" >Ciśnienie:</h1>
    <h1 class="dana" id="cisnienie">Dana:</h1>
    </div>
    <div class = "pole_danych"> 

<h1 class="opis" >Pręd. wiatru:</h1>
<h1 class="dana" id="predkosc_wiatru">Dana:</h1>
</div>

<div class = "pole_danych"> 

<h1 class="opis" >Naslonecznienie:</h1>
<h1 class="dana" id="naslonecznienie">Dana:</h1>
</div>
<div class = "pole_danych"> 

<h1 class="opis" >Wilgotnosc zewnetrzna:</h1>
<h1 class="dana" id="wilg_zewn">Dana:</h1>
</div>



</div>

<div id="wykres">


</br>

<canvas id="myCanvas" width=500px height= 500px > </canvas>
<h3>Wykres temperatury w żależnosci od czasu</h3>

</div>

<h2>Dane tabelaryczne</h2>



    <script>
        var zmienna = "<?php echo  $czas; ?>";
        var result = document.getElementById("czas");
        result.innerText = zmienna;

         zmienna = "<?php echo  $temp_wewn; ?>";
        result = document.getElementById("temp_wewn");
        result.innerText = (zmienna+"°C");

        zmienna = "<?php echo  $temp_zewn; ?>";
        result = document.getElementById("temp_zewn");
        result.innerText = (zmienna+"°C");

        zmienna = "<?php echo  $cisnienie; ?>";
        result = document.getElementById("cisnienie");
        result.innerText = zmienna;

        zmienna = "<?php echo  $predkosc_wiatru; ?>";
        result = document.getElementById("predkosc_wiatru");
        result.innerText = zmienna;

        zmienna = "<?php echo  $naslonecznienie; ?>";
        result = document.getElementById("naslonecznienie");
        result.innerText = zmienna;

        zmienna = "<?php echo  $wilg_zewn; ?>";
        result = document.getElementById("wilg_zewn");
        result.innerText = zmienna;

        var czasAr = <?php echo json_encode($czasArrey); ?>;
        var tempAr = <?php echo json_encode($tempArrey); ?>;
        
        //alert(czasAr);
        var cv = document.getElementById("myCanvas");
      var ctx = cv.getContext('2d');
      //ct.save();
      
      var w = cv.width;
      var h = cv.height;
      
      //Origin
      var originX = 0.1* h;
      var originY =0.9*w;
        ctx.beginPath();
        ctx.moveTo(originX,originY);
        ctx.lineTo(originX+0.8*w,originY);
        ctx.lineTo(originX+0.8*w-10,originY-10);
        ctx.moveTo(originX+0.8*w,originY);
        ctx.lineTo(originX+0.8*w-10,originY+10);
      
        ctx.moveTo(originX,originY);
        ctx.lineTo(originX,originY-0.7*h);
        ctx.lineTo(originX+10,originY-0.7*h+10);
        ctx.moveTo(originX,originY-0.7*h);
        ctx.lineTo(originX-10,originY-0.7*h+10);
     
     ctx.stroke();
     
     for(let i =0;i<25 ;i++)
     {
         var tekst =String(i);
         ctx.fillText(tekst, originX+15*i, originY+10);
     }
     for(let i =0;i<12 ;i++)
     {
      var tekst =String( 5*i)+"°C";
         ctx.fillText(tekst, originX-25, originY-30*i);
    
     }
    
    
     //Wykres na podstawie danych
     var czasArLen = czasAr.length;
       for(let j = 0 ; j < czasArLen; j++)
       {
        var h = parseInt (czasAr[j].charAt(0)+ czasAr[j].charAt(1));
        var min = parseInt(czasAr[j].charAt(3)+ czasAr[j].charAt(4));
       
        var positionX = originX + 15 *(h +(min/60));
        var positionY = originY - tempAr[j]*6;
        ctx.fillStyle = "red";
        ctx.fillRect(positionX,positionY,5,5);
    
    }
 

    

    </script>




  
</body>


</html>

<?php


echo "<div   style= 'float: left; padding:  10px;  '>";
echo "<table BORDER>";
echo "<tr>
<th> Miasto </th> <th>Czas</th>  <th> Temperatura </th>  <th> Stan </th>  </tr>";
foreach ($dane as $d) {
    echo "<tr>";
    echo "<td>" . $d->nazwa . "</td>";
    echo "<td>" . $d->czas . "</td>";
    echo "<td>" . $d->temperatura . "</td>";
    echo "<td>" . $d->stan . "</td>";
  

    echo "</tr>";
}
echo "</table> </div>" ;







echo "<div style=' float: left; padding:  10px;' >";
echo "<table BORDER>";
echo "<tr>
<th> id </th> <th>Czas</th>  <th> temp_wewn </th>  <th> temp_zewn </th>  <th> wilg_wewn </th>   <th> wilg_zewn </th>  <th> cisnienie </th> </tr>";
foreach ($dane1 as $d1) {
    echo "<tr>";
    echo "<td>" . $d1->id . "</td>";
    echo "<td>" . $d1->czas . "</td>";
    echo "<td>" . $d1->temp_wewn . "</td>";
    echo "<td>" . $d1->temp_zewn . "</td>";
    echo "<td>" . $d1->wilg_wewn . "</td>";
    echo "<td>" . $d1->wilg_zewn . "</td>";
    echo "<td>" . $d1->cisnienie . "</td>";

 
    echo "</tr>";

}
echo "</table> </div>" ;






echo "<div padding:  10px;' >";
echo "<table BORDER>";
echo "<tr>
<th> id </th> <th>Czas</th>  <th> Predkosc_wiatru </th>  <th> Naslonecznienie </th> </tr>";
foreach ($dane2 as $d2) {
    echo "<tr>";
    echo "<td>" . $d2->id . "</td>";
    echo "<td>" . $d2->czas . "</td>";
    echo "<td>" . $d2->predkosc_wiatru . "</td>";
    echo "<td>" . $d2->naslonecznienie. "</td>";
   

   
    echo "</tr>";




}
echo "</table> </div>" ;

echo "<div padding:  10px;' >";
echo "<table BORDER>";
echo "<tr>
<th> id </th> <th>Czas</th>  <th> Predkosc_wiatru </th>  <th> Naslonecznienie </th> </tr>";
foreach ($dane3 as $d3) {
    echo "<tr>";
    echo "<td>" . $d3->RECORD . "</td>";
    echo "<td>" . $d3->MIASTO . "</td>";
    echo "<td>" . $d3->IOT1 . "</td>";
    echo "<td>" . $d3->IOT2 . "</td>";
    echo "<td>" . $d3->DATA . "</td>";

   
    echo "</tr>";



}
echo "</table> </div>" ;


?>

