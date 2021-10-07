<?php


class SmallURL{

 public $newURL='';
 function isURLValid($origURL)
 {
  // Use curl_init() function to initialize a cURL session
  $curl = curl_init($origURL);
  // Use curl_setopt() to set an option for cURL transfer
  curl_setopt($curl, CURLOPT_NOBODY, true);
  // Use curl_exec() to perform cURL session
  $result = curl_exec($curl);
  if ($result !== false) 
   {    
    // Use curl_getinfo() to get information
    // regarding a specific transfer
    $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);    
    if ($statusCode == 404)
     {
        echo ("INVALID OR BLANK URL: $origURL, CANNOT CONVERT!<br>");
        return FALSE;
     }
    else
    {
        echo "URL $origURL OK!<br>";
        return TRUE;
    }
   }
  else 
   {
    echo ("INVALID OR BLANK URL  $origURL, CANNOT CONVERT!<br>");
    return FALSE;
   }
}
 
 function create_new_URL($origURL,$dateURLCreated, $conn)
  {
    if ($this->isURLValid($origURL) == FALSE)
     return $this->newURL;
    $newURL='';
    $charSet="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";  
    $nChars=strlen($charSet);
    for ($i=0; $i<7; $i++)
    {
      $chrNo=rand(0,$nChars-1);
      $newURL .= $charSet{$chrNo}; 
     }
    $newURL=$_SERVER['REQUEST_URI'].$newURL;
    $newURL=substr( $newURL, 1,strlen($newURL)-1);
    $sqlSelect="SELECT * FROM shorterurls WHERE OrigURL = '$origURL'";
    $selectResult=$conn->query($sqlSelect);
    if ($selectResult->num_rows >0)
     {
      while($row = $selectResult->fetch_assoc())
       {
          echo "$origURL ALREADY EXISTS as ". $row['ShortURL'] . "<br>";
          $hitCount=$row['HitCount'];
          ++$hitCount;
          $sqlUpdateHitCount="UPDATE shorterurls SET HitCount = $hitCount WHERE OrigURL = '$origURL' ";
          $conn->query($sqlUpdateHitCount);
       }
     }
   else
    {
     $sqlInsert="INSERT INTO shorterurls (OrigURL, ShortURL, DateCreated) VALUES ('$origURL', '$newURL', '$dateURLCreated')";
     if ($conn->query($sqlInsert) === TRUE)
      {
        echo "New URL created successfully as  $newURL <br>";
      } 
    else
     {
      echo "Error: " . $sqlInsert . "<br>" . $conn->error;
     }
    }
    return $newURL;
   }
 
}
//END OF CLASS

// Check connection

  $servername = "localhost";
  $username = "root";
  $password = "";
  $conn = new mysqli($servername, $username, $password,"urlshrink");  
  if ($conn->connect_error) 
  {
   die("Connection failed: " . $conn->connect_error);
  }

  $origURL="";
  $URL1= new SmallURL();
  $URL1->create_new_URL($origURL, date("m/d/Y H:m:s"), $conn);

  $origURL="http://www.facebook.com";
  $URL2= new SmallURL();
  $URL2->create_new_URL($origURL, date("m/d/Y H:m:s"), $conn);

  $origURL="http://www.linkedin.com";
  $URL3= new SmallURL();
  $URL3->create_new_URL($origURL, date("m/d/Y H:m:s"), $conn);

  $origURL="http://www.facebook.com";
  $URL4= new SmallURL();
  $URL4->create_new_URL($origURL, date("m/d/Y H:m:s"), $conn);

  $origURL="hello world";
  $URL5= new SmallURL();
  $URL5->create_new_URL($origURL, date("m/d/Y H:m:s"), $conn);




  
  
?>