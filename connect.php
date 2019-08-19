<?php

//połącz z bazą danych
function connectDB(){
    $servername = "localhost";
    $username = "root";
    $dbname = "tree";
    $password = "";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    mysqli_set_charset($conn, "utf8");
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    //echo "Connected successfully";
    
    return $conn;
}

//przerwij połącznie z bazą danych
function closeDB($conn){
    $conn->close();
}


//buduj drzewo w html
function buildTree($obj, $parentId = 0, $fst = true){

    if($fst)
        echo '<ul>';
    else
        echo '<ul class="nested">';
    
    foreach ($obj as $element) { 
        
        if ($element->parent_id == $parentId) {
            
            echo '<li>';
            
            $tmp = false;
            foreach($obj as $el){
                if($el->parent_id == $element->id){
                    echo '<span class="caret"'.' data-id="'.$element->id.'"'.'>'.$element->name.'</span>';
                    $tmp = true;
                    break;
                } 
            }
            if($tmp != true)
                echo '<span '.'data-id="'.$element->id.'"'.'>'.$element->name.'</span>';
            //echo '<li class="caret">';
            
            
            buildTree($obj, $element->id, false);
            echo "</li>";
        }
        
    }
    echo "</ul>";
  
}
//tablica obiektów
function resultToArrayOfObject($result){
    $t = array();
	while ($obj = $result->fetch_object()) {
        $t[] = $obj;
    }
    return $t;
}
//usuń węzeł wraz z dziećmi
function removeNode($conn,$id) {
	
    $sql = "SELECT * FROM tree WHERE parent_id=".$id;
	$result = $conn->query($sql);
    while($obj = $result->fetch_object()) {
        removeNode($conn,$obj->id);
	}
	$sql2 = "DELETE FROM tree WHERE id=".$id;
	$result = $conn->query($sql2);
}	

//sprwawdzanie czy posiada dzieci z tym samym numerem id, w celu uniknięcia przeniesiania węzła do dziecka tego elementu
function ifChild($obj,$IdNode,$IdNodeToGo){
    if($IdNodeToGo==$IdNode)return 0;
    
    foreach ($obj as $element) {
        if ($element->parent_id == $IdNode) {
            
            if($element->id == $IdNodeToGo){
                return 0;
            }else
            if(ifChild($obj, $element->id, $IdNodeToGo)==0){
                return 0;
            };  
            
        }
    }
    return 1;
}

?>