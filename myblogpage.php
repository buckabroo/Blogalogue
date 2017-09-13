<html>
   <body>
   
      <form action = "<?php $_PHP_SELF ?>" method = "GET">
         Name: <input type = "text" name = "name" />
	<br/><br/>
         Post: <input type = "text" name = "post" />
         <input type = "submit"/>
	<br/>
      </form>
      <br/>
   </body>
</html>
<?php
    $name = $_GET["name"];
    $post = $_GET["post"];
    $dbhost = 'ec2-34-228-18-168.compute-1.amazonaws.com:3306';
    $dbuser = 'ekbuckley';
    $dbpass = '12345';
    $postnum = 1;
    $conn = mysqli_connect($dbhost, $dbuser, $dbpass, "myDB");
    if(! $conn ) 
    {
       	die('Could not connect: ' . mysqli_error());
    }   
    if( $name || $post ) {
    $sql2 = "SELECT * FROM myBlog;";
    $retval = mysqli_query( $conn, $sql2 );
    if(!$retval ) {
          die('Could not get data: ' . mysqli_error());
    }
    while($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {
  	$postnum++;
    }
    $sql = "INSERT INTO myBlog (name, post, postnum) VALUES ('$name', '$post', $postnum)";
    $retval = mysqli_query( $conn, $sql);
       if(!$retval ) {
          echo("Could not insert data:<br> $name:  $post, because it is a duplicate post.<br>Write a new post and submit again.<br>=====================================================<br>");
       }
    }
    $sql2 = "SELECT * FROM myBlog;";
    $retval = mysqli_query( $conn, $sql2 );
    if(!$retval ) {
          die('Could not get data: ' . mysqli_error());
    }
    while($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {
       echo "NAME :{$row['name']}  <br> ".
          "POST : {$row['post']} <br> ".
	  "POST #: {$row['postnum']}<br>".
          "--------------------------------<br>";
  	$postnum++;
    }
      
    mysqli_close($conn);
   
?>
<html>
   <body>   
      <form action = "<?php $_PHP_SELF ?>" method = "GET">
         Post number to remove: <input type = "number" name = "row" />
         <input type = "submit"/>
	<br/>
      </form>
      <br/>
   </body>
</html>
<?php

    $postnum = $_GET["row"];
    if($postnum){
    $dbhost = 'ec2-34-228-18-168.compute-1.amazonaws.com:3306';
    $dbuser = 'ekbuckley';
    $dbpass = '12345';
   
    $conn = mysqli_connect($dbhost, $dbuser, $dbpass, "myDB");
    if(! $conn ) 
    {
       	die('Could not connect: ' . mysqli_error());
    }

    $sql3 = "DELETE FROM myBlog WHERE postnum='$postnum';";
    $retval = mysqli_query( $conn, $sql3);
    if(!$retval ) {
	echo("Could not delete post");
    }
    echo("Post will be deleted after next submission or refresh");
    mysqli_close($conn);
   }

?>
